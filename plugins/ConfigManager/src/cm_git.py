from src import cm_debug as deb
import subprocess
import os
import re
import time
import git

class cm_git():
    def __init__(self, **parms):
        self.debug = parms.get("debug", False)
        self.path = parms.get("path", '/tmp/ConfManager/configs')

        if self.debug: deb.cm_debug.show( marker='debGit', message = 'Git repo path: {}'.format(self.path))

        try:
            self.git_repo = git.Repo(self.path)
        except Exception as e:
            if self.debug: deb.cm_debug.show( marker='debGit', message = 'Git is trying to create repo')
            self.git_repo = git.Repo.init(self.path)

        try:
            if self.git_repo.working_tree_dir == self.path:
                if self.debug: deb.cm_debug.show( marker='debGit', message = 'Git Initiated Successfully')
            else:
                if self.debug: deb.cm_debug.show( marker='debGit', message = 'Git NOT Initiated. Exit')
                quit()
        except Exception as e:
            if self.debug: deb.cm_debug.show( marker='debGit', message = 'Git Erro: {} . Exit'.format(e))
        # if not os.path.exists( self.path ):
        #     if self.debug: deb.cm_debug.show( marker='debGit', message = 'Git directory does not exist')
        #     try:
        #         os.makedirs( self.path, exist_ok=True )
        #         time.sleep(4)
        #     except Exception as e:
        #         if self.debug: deb.cm_debug.show( marker='debGit', message = 'Error: {}'.format(e))
        #         if self.debug: deb.cm_debug.show( marker='debGit', message = 'Git can not create directory for config. Exit')
        #         quit()
        #     if not os.path.exists( self.path ):
        #         if self.debug: deb.cm_debug.show( marker='debGit', message = 'Git can not create directory for config. Exit')
        #         quit()
        #     if self.debug: deb.cm_debug.show( marker='debGit', message = 'Git directory was created successfully')
        # stdout, stderr = subprocess.Popen([ "git", "-C", self.path , "status", "-s"], stdout=subprocess.PIPE, stderr=subprocess.STDOUT, universal_newlines=True).communicate()
        # if self.debug: deb.cm_debug.show( marker='debGit', message = 'Git short status request: {}'.format(stdout.strip()))
        # if stdout and re.match('^fatal:', stdout):
        #     if self.debug: deb.cm_debug.show( marker='debGit', message = 'Git met error: {}'.format(stdout))
        #     if re.match('.*\s[Nn]ot a git repository', stdout):
        #         if self.debug: deb.cm_debug.show( marker='debGit', message = 'Try to initiate git repo')
        #         stdout, stderr = subprocess.Popen([ "git", "-C", self.path , "init"], stdout=subprocess.PIPE, stderr=subprocess.STDOUT, universal_newlines=True).communicate()
        #         if self.debug: deb.cm_debug.show( marker='debGit', message = 'Initiate output: {}'.format(stdout))
        #     else:
        #         if self.debug: deb.cm_debug.show( marker='debGit', message = 'Unknown error :( Exit')
        #         quit()
        # #print(stdout,'####', stderr)
        # if self.debug: deb.cm_debug.show( marker='debGit', message = 'Git was Initiated')

    def check(self, **parms):
        after = parms.get("after", False)
        if not self.git_repo.git.status('--short'):
            if self.debug: deb.cm_debug.show( marker='debGit', message = 'Git Nothing to Commit' )
            return False
        if self.debug:
            deb.cm_debug.show( marker='debGit', message = 'Git Commit Available' )
            print(self.git_repo.git.status('--short'))
        if not after:
            self.commit()
        # if self.debug: deb.cm_debug.show( marker='debGit', message = 'Check Git Ckeck start')
        # stdout, stderr = subprocess.Popen([ "git", "-C", self.path , "status", "-s"], stdout=subprocess.PIPE, stderr=subprocess.STDOUT, universal_newlines=True).communicate()
        # if self.debug: deb.cm_debug.show( marker='debGit', message = 'Git short status request: {}'.format(stdout.strip()))
        # if stdout.strip() != '': self.commit(commit_list = stdout.strip())

    def commit(self, **parms):
        if self.debug: deb.cm_debug.show( marker='debGit', message = 'Git Start Commit' )
        self.git_repo.git.add('-A')
        committer = git.Actor("tacacsgui", "confmanager@tacacsgui.com")
        self.git_repo.index.commit(message='TacacsGUI',committer=committer)
        self.check(after=True)
        # stdout_add, error = subprocess.Popen([ "git", "-C", self.path , "add", "-A"], stdout=subprocess.PIPE, universal_newlines=True).communicate()
        # tdout_comm, error = subprocess.Popen([ "git", "-C", self.path , "commit", "-m", 'TacacsGUI'], stdout=subprocess.PIPE, universal_newlines=True).communicate()
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
