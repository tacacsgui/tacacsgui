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
        # group = parms.get('group', '')
        # if group:
        #     if self.debug: deb.cm_debug.show( marker='debW', message = 'Group set: {}'.format(group) )
        #     if not os.path.isdir(parms['path']+'/'+group):
        #         if self.debug: deb.cm_debug.show( marker='debW', message = 'Create dir: {}'.format(group) )
        #         os.mkdir(path)
        #     group +='/'
        if self.debug: deb.cm_debug.show( marker='debW', message = 'Write to file {}'.format(parms['path']+parms['name']) )
        #if self.debug: deb.cm_debug.show( marker='debW', message = 'Write a file: {}'.format(parms['data']) )

        try:
            with open(parms['path']+parms['name'], "w+") as config_file:
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
        if self.debug: deb.cm_debug.show( marker='debW', message = 'Line: {}'.format(omitLines) )
        for ln in omitLines:
            if int(ln) <= len(finalData):
                if marker:
                    finalData[ln] = marker + finalData[ln]
                else:
                    if self.debug: deb.cm_debug.show( marker='debW', message = 'Delete {} line: {}'.format(str(ln), finalData[ln]) )
                    del finalData[ln]
        return "\n".join(finalData)

    def omitLSanitize(self, omitLines):
        import re
        sanitizedList = []
        if self.debug: deb.cm_debug.show( marker='debW', message = 'OmitLines Sanitize: '+str(omitLines) )
        for oL in omitLines:
            oL = re.sub("\s+", "", str(oL).strip())
            if oL.lstrip('-').isdigit():
                sanitizedList += [int(oL)]
                continue
            if ( re.match('^\d-\d', oL) and len( (oL).split('-') ) == 2 ):
                if self.debug: deb.cm_debug.show( marker='debW', message = 'OmitLines Sanitize Range: '+str( (oL).split('-') ) )
                sanitizedList += list( range( int(sorted( (oL).split('-'), key=int )[0]), int(sorted( (oL).split('-'), key=int )[1]) + 1 ) )
                continue
        list_final = list( set( sanitizedList ) )
        list_final.sort()
        # if self.debug: deb.cm_debug.show( marker='debW', message = 'OmitLines Sanitize Result: '+str(sorted( list( set( sanitizedList ) ), reverse=True )) )
        if self.debug: deb.cm_debug.show( marker='debW', message = 'OmitLines Sanitize Result: '+str( list_final ) )
        # return sorted( list( set( sanitizedList ) ), reverse=True )
        return list_final
