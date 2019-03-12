from src import cm_debug as deb

class cm_engine():
    def __init__(self, **parms):
        self.debug = parms.get("debug", False)
        if self.debug: deb.cm_debug.show( marker='debE', message = 'Engine was Initiated')
    def run(self, **parms):
        import pexpect
        hostname = parms.get("ip", "10.0.0.1")
        proto = parms.get("protocol", "ssh")
        port = str( parms.get("port", 22) )
        creden = parms.get("credential", {})

        username = creden.get("username", '')
        password = creden.get("password", '')
        timeout = parms.get("timeout", 3)
        prompt = parms.get("prompt", ['#','>'])
        if not len(prompt): prompt = ['#','>']
        exceprions = parms.get("expectations", [])
        if self.debug: deb.cm_debug.show( marker='debE', message = 'Device IP or Hostname: ' + hostname +':'+port + ' Username: ' + username )
    ###	TELNET EXPECT AUTHENTICATION	###
        # try:
        if proto == 'telnet':
            if self.debug: deb.cm_debug.show( marker='debE', message = 'Telnet. ' + hostname +':'+port + ' Try to connect...')
            child = pexpect.spawn('telnet ' + hostname + ' ' + port, encoding='utf8')
            child.timeout = int(timeout)
            if username:
                if self.debug: deb.cm_debug.show( marker='debE', message = 'Expect: ' + ', '.join(['login as:', 'sername:']) )
                child.expect(['login as:', 'sername:'])
                if self.debug: deb.cm_debug.show( marker='debE', message = 'Before: ' + child.before )
                if self.debug: deb.cm_debug.show( marker='debE', message = 'Send Username: ' + username )
                child.sendline (username)
            if password:
                if self.debug: deb.cm_debug.show( marker='debE', message = 'Expect: ' + ', '.join(['assword:']) )
                child.expect(['assword:'])
                if self.debug: deb.cm_debug.show( marker='debE', message = 'Before: ' + child.before )
                if self.debug: deb.cm_debug.show( marker='debE', message = 'Send Password' )
                child.sendline(password)
	###	SSH EXPECT AUTHENTICATION	###
        elif proto == 'ssh':
            if self.debug: deb.cm_debug.show( marker='debE', message = 'SSH. ' + hostname +':'+port + ' Try to connect...')
            child = pexpect.spawn('ssh -tt -oStrictHostKeyChecking=no -p '+port+' -o ConnectTimeout=10 '+username+'@'+hostname, encoding='utf8')
            #child.logfile = sys.stdout
            child.timeout = int(timeout)
            if password:
                child.expect(['assword:'])
                if self.debug: deb.cm_debug.show( marker='debE', message = 'Before: ' + child.before )
                child.sendline(password)

        write2file = False
    ###	START SEND COMMANDS	###
        lastExpection = int( len(exceprions) - 1 )
        deviceFile = ''
        for expection in exceprions:
            if expection['expect']:
                if self.debug: deb.cm_debug.show( marker='debE', message = 'Expect: ' + expection['expect'] )
                child.expect(expection['expect'])
                if self.debug: deb.cm_debug.show( marker='debE', message = 'Before: ' + child.before )
            else:
                if self.debug: deb.cm_debug.show( marker='debE', message = 'Expect: ' + ', '.join(prompt) )
                child.expect(prompt)
                if self.debug: deb.cm_debug.show( marker='debE', message = 'Before: ' + child.before )
            if write2file:
                #print(child.before)
                if self.debug: deb.cm_debug.show( marker='debE', message = 'Write to buffer...' )
                deviceFile += child.before
            if self.debug: deb.cm_debug.show( marker='debE', message = 'Send Line: ' + expection['send'] )
            child.sendline( expection['send'] )
            write2file = bool(expection['write'])
        if write2file:
            if self.debug: deb.cm_debug.show( marker='debE', message = 'Write to buffer...End' )
            deviceFile += child.befores
        return deviceFile
