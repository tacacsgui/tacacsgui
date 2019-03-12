from src import cm_debug as deb
import os

class cm_writer():
    def __init__(self, **parms):
        self.debug = parms.get("debug", False)
        if self.debug: deb.cm_debug.show( marker='debW', message = 'Writer was Initiated')

    def write(self, **parms):
        if self.debug: deb.cm_debug.show( marker='debW', message = 'Write init')
        if not 'path' in parms:
            if self.debug: deb.cm_debug.show( marker='debW', message = 'Path not found exit!')
            quit()
        if not 'data' in parms or not parms['data']:
            if self.debug: deb.cm_debug.show( marker='debW', message = 'Data not found or empty. Return')
            return 'Warning: Data not found or empty. Return'
        group = parms.get('group', '')
        if group:
            if self.debug: deb.cm_debug.show( marker='debW', message = 'Group set: {}'.format(group) )
            if not os.path.isdir(parms['path']+'/'+group):
                if self.debug: deb.cm_debug.show( marker='debW', message = 'Create dir: {}'.format(group) )
                os.mkdir(path)
            group +='/'
        if self.debug: deb.cm_debug.show( marker='debW', message = 'Write to file {}'.format(parms['path']+'/'+group+parms['name']) )

        try:
            with open(parms['path']+'/'+group+parms['name'], "w") as config_file:
                config_file.write(parms['data'])
        except Exception as e:
            if self.debug: deb.cm_debug.show( marker='debW', message = 'Write error {}'.format(e) )
            return 'Error: Write Error: {}'.format(e)
        if self.debug: deb.cm_debug.show( marker='debW', message = 'Write to file successfully' )
        return False

    def preview(self, **parms):
        marker = parms.get("marker", "")
        data = parms.get("data", "")
        omitLines = parms.get("omitLines", "")
        if omitLines:
            omitLines = self.omitLSanitize(omitLines)
        finalData = data.split("\n")
        for ln in omitLines:
            if int(ln-1) <= len(finalData):
                if marker:
                    finalData[ln-1] = marker + finalData[ln-1]
                else:
                    del finalData[ln-1]
        return "\n".join(finalData)

    def omitLSanitize(self, omitLines):
        sanitizedList = []
        for oL in omitLines:
            if (str(oL)).isdigit():
                sanitizedList += [int(oL)]
                continue
            if ( len( (str(oL)).split('-') ) == 2 ):
                sanitizedList += list( range( int(sorted( (str(oL)).split('-') )[0]),int(sorted( (str(oL)).split('-') )[1]) + 1 ) )
                continue
        return sorted( list( set( sanitizedList ) ), reverse=True )
