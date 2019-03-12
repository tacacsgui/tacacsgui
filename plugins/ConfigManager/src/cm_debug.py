import datetime
import time

class cm_debug():
    def __init__(self, **parms):
        self.test = parms.get("test", "")
        print(self.test)

    @staticmethod
    def show(**parms):
        #time.sleep(2)
        marker = parms.get("marker", "deb")
        print( datetime.datetime.fromtimestamp(time.time()).strftime('%Y-%m-%d %H:%M:%S')+' ['+marker+'] '+ parms.get("message", "undefined!") )
        return True
