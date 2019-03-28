#!/usr/bin/env python3

import argparse

def debug(**parms):
    print( '{} {}'.format(datetime.datetime.fromtimestamp(time.time()).strftime('%Y-%m-%d %H:%M:%S'), parms.get("message", "undefined!")) )
    return True

netplan_dir='/etc/netplan'
version = '1.0.0'
parser = argparse.ArgumentParser(description='''TGUI Network Manager. Developed by Aleksey Mochalin''')
parser.add_argument('-v', '--version', action='version',
                    version='TGUI Network Manager {version}'.format(version=version), help='show current version') #%(prog)s - show file name
parser.add_argument('-l', '--list', action='store_true',
                    help='interface list')
parser.add_argument('--ip', action='store_true',
                    help='only with interface list')
parser.add_argument('-i', '--info', metavar='[interface name]',
                    help='show interface info')
parser.add_argument('--netplan', action='store_true',
                    help='get info from netplan file')
parser.add_argument('-s', '--set', metavar='[interface_name]', nargs='+',
                    help='set interface settings, [interface name] [ip address] [mask]')
parser.add_argument('-gw', '--gateway', metavar='[gateway]',
                    help='set gateway, only with --set')
parser.add_argument('-nm', '--nameservers', metavar='[nameservers]', nargs='+',
                    help='set nameservers, space separated, only with --set command')
parser.add_argument('--interactive', action='store_true',
                    help='interactive mode of interface set')
parser.add_argument('-y','--yes', action='store_true',
                    help='default yes')
parser.add_argument('-d','--debug', action='store_true',
                    help='debug mode')
parser.add_argument('-t','--test', action='store_true',
                    help='test script')

args = parser.parse_args()
#Start
#TEST
if args.test:
    try:
        import yaml
        import os
        import datetime
        import time
        import subprocess
        from ipaddress import IPv4Network, IPv4Address, IPv4Interface
        import netifaces
    except Exception as e:
        print('Error: {}'.format(e))
        quit()
    print('success', end='\n')
    quit()
#LIBRARIES
import yaml
import os
import datetime
import time
import subprocess
from ipaddress import IPv4Network, IPv4Address, IPv4Interface
import netifaces
#Variables
netplan_file=''
#Start main work
if args.debug: debug( message='Args list: {}'.format(args) )
if args.debug: debug( message="Start searching netplan file")
for r, d, f in os.walk(netplan_dir):
    for file in f:
        if '.yaml' in file:
            if args.debug: debug(message='Trying file {}'.format( '/'.join((r, file)) ) )
            try:
                with open('/'.join((r, file)), 'r') as stream:
                    data_loaded = yaml.load(stream)
                if 'network' in data_loaded and 'ethernets' in data_loaded['network']:
                    if args.debug: debug(message='Well done! File found')
                    if args.debug: debug(message='List of interface: {}'.format( str(list(data_loaded['network']['ethernets'].keys())) ) )
                    netplan_file=file
            except Exception as e:
                if args.debug: debug(message="Incorrect file {}. Try next one. Error: {}".format( '/'.join((r, file)), e ) )
                continue;
if not netplan_file:
    print('No one file found. Exit')
    quit()

if args.list:
    if args.netplan:
        if args.debug: debug(message='Get data from netplan')
        for inter in list(data_loaded['network']['ethernets'].keys()):
            print(inter, end='\n')
        quit()
    if args.debug: debug(message='Get data from netifaces')
    if args.ip:
        for inter in netifaces.interfaces():
            print('{}-{}'.format( inter, netifaces.ifaddresses(inter)[netifaces.AF_INET][0]['addr']), end='\n')
        quit()
    print('\n'.join(netifaces.interfaces()), end='\n')
    quit()
if args.info:
    if not args.info in netifaces.interfaces():
        print('Interface not found!', end='\n')
        quit()
    if args.netplan:
        if args.debug: debug(message='Get data from netplan')
        if not args.info in data_loaded['network']['ethernets']:
            print('Interface not configured', end='\n')
            quit()
        link = data_loaded['network']['ethernets'][args.info]
        address=', '.join(link.get('addresses',[]))
        if link.get('dhcp4',False):
            if link['dhcp4'] == 'yes':
                address = 'dhcp'
        if not (address == '' and address == 'dhcp'):
            address = IPv4Interface(address).with_netmask
        print('ip address: {}\ndefaultgw: {}\nnameservers: {}'.format(
            address, link.get('gateway4',''),
            ' '.join( link.get('nameservers',{}).get('addresses','') )
        ), end='\n')
        quit()
    if args.debug: debug(message='Get data from netifaces')
    if not netifaces.ifaddresses(args.info).get(netifaces.AF_INET, False):
        print('Interface not configured', end='\n')
        quit()
    if netifaces.ifaddresses(args.info).get(netifaces.AF_INET, False):
        print('Netifaces info:')
        link = netifaces.ifaddresses(args.info)[netifaces.AF_INET][0]
        nameservers = ''
        if args.info in data_loaded['network']['ethernets']:
            if args.debug: debug(message=str(data_loaded['network']['ethernets']))
            nameservers = ', '.join( data_loaded['network']['ethernets'][args.info].get('nameservers',{}).get('addresses',[]) )
        default = netifaces.gateways()['default'][netifaces.AF_INET][0]
        print('ip address: {}\ndefaultgw: {}\nnameservers: {}'.format(
            link.get('addr','')+'/'+ str(IPv4Network('0.0.0.0/'+ link.get('netmask','')).prefixlen), default,
            nameservers
        ), end='\n')
        quit()
if args.set:
    if os.geteuid() != 0:
        print('Add sudo please!', end='\n')
        quit()
    if not args.set[0] in netifaces.interfaces():
        print('Interface not found!', end='\n')
        quit()
    if args.interactive:
        welcome='''########################
Welcome to interactive mode of
Network Interface Configuration
########################
'''
        print(welcome)
        while True:
            try:
                address=input('IP Address: ')
                if address == 'dhcp': break
                address=str(IPv4Address(address))
                prefix=int(IPv4Network('0.0.0.0/'+ input('Mask: ')).prefixlen)
                if not 32 > prefix > 4:
                    raise ValueError('Prefix must be less or equal 32 or more 4. Your prefix is: {}'.format(prefix))
                address+='/'+str(prefix)
                network_address=IPv4Network(address, strict=False)
                print('Network Address: ' + str(network_address))
                gateway=str(input('Gateway (Optional): '))
                if gateway: gateway=IPv4Address(gateway)
                nameservers=str(input('Nameservers (Optional, comma separated): '))
                if nameservers: nameservers = [ str(IPv4Address(str(x).strip())) for x in nameservers.split(',') ]

                break
            except ValueError as e:
                print('Error: {}'.format(e))
                if 'y' in str(input('Try one more time? (y/n): ')):
                    continue
                quit()
    else:
        try:
            if len(args.set) < 2:
                raise ValueError('Where is an ip address?')
            if args.set[1] != 'dhcp':
                address=str(IPv4Address(args.set[1]))
                if len(args.set) < 3:
                    raise ValueError('Where is a network mask?')
                prefix=int(IPv4Network('0.0.0.0/'+ args.set[2]).prefixlen)
                if not 32 > prefix > 4:
                    raise ValueError('Prefix must be less or equal 32 or more 4. Your prefix is: {}'.format(prefix))
                address+='/'+str(prefix)
                network_address=IPv4Network(address, strict=False)
                gateway=''
                if args.gateway: gateway=IPv4Address(args.gateway)
                nameservers = []
                if args.nameservers: nameservers = [ str(IPv4Address(str(x))) for x in args.nameservers ]
            else: address=args.set[1]
        except ValueError as e:
            print('Error: {}'.format(e))
            quit()
    if not args.yes:
        print('########################')
        if address != 'dhcp':
            print('Please check settings:\nIP Address: {}\nGateway: {}\nNameservers: {}'
              .format(str(address), str(gateway), ', '.join(nameservers) ) )
        else:
            print('Please check settings:\nIP Address: {}'
                .format( address ) )
        if not 'y' in input('Is it correct? (y/n): '):
            print('Not correct. Quit.')
            quit()
    if args.debug: debug(message='Correct settings. Creating config file {}/{}'.format(netplan_dir,netplan_file) )

    data_loaded['network']['ethernets'][args.set[0]] = {}
    if address == 'dhcp':
        data_loaded['network']['ethernets'][args.set[0]]['dhcp4'] = 'yes'
        data_loaded['network']['ethernets'][args.set[0]]['dhcp6'] = 'yes'
    else:
        data_loaded['network']['ethernets'][args.set[0]]['dhcp4'] = 'no'
        data_loaded['network']['ethernets'][args.set[0]]['dhcp6'] = 'no'
        data_loaded['network']['ethernets'][args.set[0]]['addresses'] = [address]
        if gateway:
            data_loaded['network']['ethernets'][args.set[0]]['gateway4'] = str(gateway)
        if len(nameservers):
            data_loaded['network']['ethernets'][args.set[0]]['nameservers'] = {}
            data_loaded['network']['ethernets'][args.set[0]]['nameservers']['addresses'] = nameservers
    with open(netplan_dir+'/'+netplan_file, 'w') as stream:
        yaml.dump(data_loaded, stream)
    subprocess.call('netplan apply', shell=True)
    print('done', end='\n')
    quit()

parser.print_help()
