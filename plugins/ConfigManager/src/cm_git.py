from src import cm_debug as deb
import subprocess
import os
import re
import time

class cm_git():
    def __init__(self, **parms):
        self.debug = parms.get("debug", False)
        self.path = parms.get("path", '/tmp/ConfManager/configs')
        if not os.path.exists( self.path ):
            if self.debug: deb.cm_debug.show( marker='debGit', message = 'Git directory does not exist')
            try:
                os.makedirs( self.path, exist_ok=True )
                time.sleep(4)
            except Exception as e:
                if self.debug: deb.cm_debug.show( marker='debGit', message = 'Error: {}'.format(e))
                if self.debug: deb.cm_debug.show( marker='debGit', message = 'Git can not create directory for config. Exit')
                quit()
            if not os.path.exists( self.path ):
                if self.debug: deb.cm_debug.show( marker='debGit', message = 'Git can not create directory for config. Exit')
                quit()
            if self.debug: deb.cm_debug.show( marker='debGit', message = 'Git directory was created successfully')
        stdout, stderr = subprocess.Popen([ "git", "-C", self.path , "status", "-s"], stdout=subprocess.PIPE, stderr=subprocess.STDOUT, universal_newlines=True).communicate()
        if self.debug: deb.cm_debug.show( marker='debGit', message = 'Git short status request: {}'.format(stdout.strip()))
        if stdout and re.match('^fatal:', stdout):
            if self.debug: deb.cm_debug.show( marker='debGit', message = 'Git met error: {}'.format(stdout))
            if re.match('.*\sNot a git repository', stdout):
                if self.debug: deb.cm_debug.show( marker='debGit', message = 'Try to initiate git repo')
                stdout, stderr = subprocess.Popen([ "git", "-C", self.path , "init"], stdout=subprocess.PIPE, stderr=subprocess.STDOUT, universal_newlines=True).communicate()
                if self.debug: deb.cm_debug.show( marker='debGit', message = 'Initiate output: {}'.format(stdout))
            else:
                if self.debug: deb.cm_debug.show( marker='debGit', message = 'Unknown error :( Exit')
                quit()
        #print(stdout,'####', stderr)
        if self.debug: deb.cm_debug.show( marker='debGit', message = 'Git was Initiated')

    def check(self, **parms):
        if self.debug: deb.cm_debug.show( marker='debGit', message = 'Check Git Ckeck start')
        stdout, stderr = subprocess.Popen([ "git", "-C", self.path , "status", "-s"], stdout=subprocess.PIPE, stderr=subprocess.STDOUT, universal_newlines=True).communicate()
        if self.debug: deb.cm_debug.show( marker='debGit', message = 'Git short status request: {}'.format(stdout.strip()))
        if stdout.strip() != '': self.commit(commit_list = stdout.strip())

    def commit(self, **parms):
        if self.debug: deb.cm_debug.show( marker='debGit', message = 'Git Start Commit' )
        stdout_add, error = subprocess.Popen([ "git", "-C", self.path , "add", "-A"], stdout=subprocess.PIPE, universal_newlines=True).communicate()
        tdout_comm, error = subprocess.Popen([ "git", "-C", self.path , "commit", "-m", 'TacacsGUI'], stdout=subprocess.PIPE, universal_newlines=True).communicate()
        #commitData = parms['commit_list'].split("\n")
        # for ln in commitData:
        #     status, filename = ln.split()
        #     if self.debug: deb.cm_debug.show( marker='debGit', message = 'Git line: {}'.format(ln) )
        #     if re.match('^\?', status) or re.match('^A', status): message = 'Created'
        #     elif re.match('^M', status): message = 'Modified'
        #     elif re.match('^D', status): message = 'Deleted'
        #     elif re.match('^R', status): message = 'Renamed'
        #     else: message = 'Unknown attrebutes: {}'.format(status)
        #     if self.debug: deb.cm_debug.show( marker='debGit', message = 'Git Commit message: {}, for file {}'.format(message, filename) )
        #     stdout_add, error = subprocess.Popen([ "git", "-C", self.path , "add", filename], stdout=subprocess.PIPE, universal_newlines=True).communicate()
        #     stdout_comm, error = subprocess.Popen([ "git", "-C", self.path , "commit", "-m", message], stdout=subprocess.PIPE, universal_newlines=True).communicate()
        #     if self.debug: deb.cm_debug.show( marker='debGit', message = 'Git Add/Commit output: {} / {}'.format(stdout_add, stdout_comm) )

    def check_pid(self, pid):
        """ Check For the existence of a unix pid. """
        if not pid: return False
        try:
            os.kill(int(pid), 0)
        except OSError:
            return False
        else:
            return True
