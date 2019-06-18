#!/usr/bin/env python3

import argparse
import os
import yaml
import sys
import subprocess
from src import cm_debug as deb, cm_engine as cme, cm_writer as cmw, cm_git as cmg, cm_logging as cml
version = '1.0.0'
pid_path = '/opt/tgui_data/confManager/pid'
parser = argparse.ArgumentParser(description='''Configuration Manager. Developed by Mochalin Aleksey''')
parser.add_argument('-v', '--version', action='version',
                    version='Configuration Manager {version}'.format(version=version), help='show current version') #%(prog)s - show file name
parser.add_argument('-c', '--config', metavar='[path]', default=str(os.path.dirname(os.path.realpath(__file__)))+'/config.yaml',
                    help='configuration path, e.g. /opt/ConfManager/config.yaml. Default, try to find config.yaml inside of script directory')
parser.add_argument('-d', '--debug', action='store_true',
                    help='enable debug messages')
parser.add_argument('-s', '--status', action='store_true',
                    help='check current status')
parser.add_argument('-gc', '--git-commit', action='store_true',
                    help='fast commit')
parser.add_argument('--cron-set', metavar='[path]',
                    help='set cron configuration')
parser.add_argument('--cron-status', action='store_true',
                    help='show cron status')
parser.add_argument('--cron-stop', action='store_true',
                    help='stop cron')
parser.add_argument('-tq', '--test-queries', metavar='[path]',
                    help='output query in stdout')
parser.add_argument('-m', '--marker', metavar='[marker]', nargs='+',
                    help='mark omitted lines, if not set line will be omitted. Used only with --test-queries')
parser.add_argument('-an', '--anchors', action='store_true',
                    help='add START_ and END_ to the beginning and the end of output respectively')

args = parser.parse_args()
#check script status
if args.cron_set:
    if not os.path.isfile(args.cron_set):
        print('File not Found!')
        quit()
    with open(args.cron_set, 'r') as stream:
        cron_loaded = yaml.load(stream)
    temp_file="/opt/tacacsgui/temp/crontemp"
    git = cron_loaded.get('git', {})
    cm = cron_loaded.get('cm', {})
    week = cm.get('week', '0') if cm.get('period', 'day') != 'day' else "*"
    hours, minutes = cm.get('time', '00:00').split(':')
    import re
    cron_content ='''#### TGUI CM ####
{} {} * * {} {} -c /opt/tgui_data/confManager/config.yaml > /dev/null 2>/dev/null &
#### TGUI GIT ####
*/{} * * * * {} --git-commit -c /opt/tgui_data/confManager/config.yaml > /dev/null 2>/dev/null &
'''.format(
        re.sub('^0', '', minutes), re.sub('^0', '', hours), week,
        os.path.realpath(__file__), git.get('period', 60), os.path.realpath(__file__)
    )
    try:
        with open(temp_file, "w") as config_file:
            config_file.write(cron_content)
    except Exception as e:
        if args.debug: deb.cm_debug.show( marker='debCron', message = 'Write error {}'.format(e) )
        print('Error: Write Error: {}'.format(e))
        quit()
    subprocess.Popen([ "crontab", temp_file]).communicate()
    print('done',end='\n')
    quit()
if args.cron_stop:
    temp_file="/opt/tacacsgui/temp/crontemp"
    try:
        with open(temp_file, "w") as config_file:
            config_file.write('')
    except Exception as e:
        if args.debug: deb.cm_debug.show( marker='debCron', message = 'Write error {}'.format(e) )
        print('Error: Write Error: {}'.format(e))
        quit()
    subprocess.Popen([ "crontab", temp_file]).communicate()
    print('done',end='\n')
    quit()
if args.cron_status:
    stdout, stderr = subprocess.Popen([ "crontab", "-l"], stdout=subprocess.PIPE, stderr=subprocess.STDOUT, universal_newlines=True).communicate()
    print(stdout, end="")
    quit()
if args.status:
    if args.debug: deb.cm_debug.show(message='Check script status', marker='des')
    if args.config == 'config.yaml':
        if args.debug: deb.cm_debug.show(message='Configuration does not set. Try to find default config.yaml', marker='des')
    if not os.path.isfile(args.config):
        if args.debug: deb.cm_debug.show(message='Configuration file ({}) not found'.format(args.config), marker='des')
        quit()
    git = cmg.cm_git(debug=args.debug, config=args.config)
    git.check()
    stdout, stderr = subprocess.Popen([ "crontab", "-l"], stdout=subprocess.PIPE, stderr=subprocess.STDOUT, universal_newlines=True).communicate()
    cronstatus = 'Planned' if '#### TGUI CM ####' in stdout else 'Not Planned'
    if os.path.isfile(pid_path):
        if args.debug: deb.cm_debug.show(message='Pid file found')
        with open(pid_path, 'r') as pid_old_file:
            pid_old = pid_old_file.read()
        if args.debug: deb.cm_debug.show(message='PID in file: ' + str(pid_old))
        if git.check_pid(pid_old):
            if args.debug: deb.cm_debug.show(message='Process already running. Exit')
            print('running '+pid_old+' ' + str(os.path.getmtime(pid_path)) +' '+cronstatus, end='\n')
        else:
            print('ready ' + str(os.path.getmtime(pid_path)) +' '+cronstatus, end='\n')
    quit()

#Main section
if args.debug: deb.cm_debug.show(message='Check configuration file')

try:
    if args.test_queries:
        if args.debug: deb.cm_debug.show(message='Run test preview for file: ' + args.test_queries)
        if not os.path.isfile(args.test_queries):
            raise ValueError('Configuration File ' + args.test_queries + ' not found!')
        if args.debug: deb.cm_debug.show(message='Open file ' + args.test_queries)
        with open(args.test_queries, 'r') as stream:
            data_loaded = yaml.load(stream)
        if args.debug: deb.cm_debug.show(message='Go to main script')
    else:
        if not os.path.isfile(args.config):
            raise ValueError('Configuration File ' + args.config + ' not found!')
        with open(args.config, 'r') as stream:
            data_loaded = yaml.load(stream)
        if not data_loaded:
            raise ValueError('Configuration File is empty!')
except Exception as e:
  print( "Error: {}".format( e ) )
  quit()

if args.debug: deb.cm_debug.show(message='Configuration found')
try:
    data_loaded
except NameError:
    if args.debug: deb.cm_debug.show( message = "Unexpected Error!" )
    quit()
if not 'queries' in data_loaded:
	if args.debug: deb.cm_debug.show(message='Query List empty')
	quit()

#quick commit
if args.git_commit:
    if args.debug: deb.cm_debug.show(message='Quick Commit Start')
    git = cmg.cm_git( **data_loaded['git'], debug=args.debug )
    git.check()
    quit()

engine = cme.cm_engine( debug=args.debug )
writer = cmw.cm_writer( debug=args.debug )

if not args.test_queries:
    loggin = cml.cm_logging( debug=args.debug, **data_loaded['log'] )
    git = cmg.cm_git( **data_loaded['git'], debug=args.debug )
    git.check()
    #quit()
    #old pid
    if os.path.isfile(pid_path):
        if args.debug: deb.cm_debug.show(message='Pid file found')
        with open(pid_path, 'r') as pid_old_file:
            pid_old = pid_old_file.read()
        if args.debug: deb.cm_debug.show(message='PID from file: ' + str(pid_old))
        if git.check_pid(pid_old):
            if args.debug: deb.cm_debug.show(message='Process already running. Exit')
            print('running ' + str(os.path.getmtime(pid_path)), end='\n')
            quit()
    #new pid
    pid = str(os.getpid())
    with open(pid_path, "w") as pid_file:
        pid_file.write(pid)


for query in list(data_loaded['queries']):
	if args.debug: deb.cm_debug.show( message = 'Start for ' + query['name'])
	query['omitLines'] = query.get('omitLines',[])
	creden = query.get('credential', {})
	log_data = {
        'protocol': query.get('protocol', 'unkown'),
        'port': query.get('port', 0),
        'ip': query.get('ip', 'unknown'),
        'device_id': query.get('device_id', 0),
        'device_name': query.get('device_name', ''),
        'query_id': query.get('query_id', 0),
        'query_name': query.get('query_name', ''),
        'uname_type': creden.get('type', ''),
        'uname': creden.get('username', ''),
        'path': query.get('path', ''),
        }
	path = query.get('path','')
	if not path: path += '/'
	if not args.test_queries and os.path.exists(data_loaded['git']['path']+path+query['name']):
		dir_ok = True
		if not os.path.exists(os.path.dirname(data_loaded['git']['path']+path+query['name'])):
			try:
				os.makedirs(os.path.dirname(data_loaded['git']['path']+path+query['name']))
			except Exception as e:
				if args.debug: deb.cm_debug.show( message = "Can't creat directory: "+path)
				dir_ok = False
		if dir_ok:
			open(data_loaded['git']['path']+path+query['name'], 'a').close()
	try:
		deviceFile = engine.run(**query)
		#if args.debug: deb.cm_debug.show( message = "From engine: "+ deviceFile)
		if args.anchors:
			deviceFile = 'START_ ' + deviceFile + ' END_';
		if args.test_queries:
			print( writer.preview( data=deviceFile, omitLines=query['omitLines'], marker=' '.join(args.marker) ) )
		else:
			if args.debug: deb.cm_debug.show( message = "Writer params: omit_lines: {}, path: {}".format(query['omitLines'], data_loaded['git']['path'] + query['path']))
			preview = writer.preview( data=deviceFile, omitLines=query['omitLines'] )
			# if args.debug: deb.cm_debug.show( message = "### OUTPUT PREVIEW START ###\n" + preview)
			# if args.debug: deb.cm_debug.show( message = '### OUTPUT PREVIEW END ###')
			writer.write( data=preview, path=data_loaded['git']['path'] + path, name=query['name'] )
			loggin.add(**log_data, status='success')
	except Exception as e:
		if args.debug: deb.cm_debug.show( message = "Engine Error:\n{}".format( e ) )
		if not args.test_queries: loggin.add(**log_data, status='error', message=e)
		continue
	if args.debug: deb.cm_debug.show( message = "Success for "  + query['name'] )
if args.debug: deb.cm_debug.show( message = 'End of Quering loop' )
if not args.test_queries:
    with open(pid_path, "w") as pid_file:
        pid_file.write('')
    if not args.anchors: git.check()
