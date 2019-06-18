from sqlalchemy import Column, Integer, String, Text, DateTime
from sqlalchemy.ext.declarative import declarative_base
import time
import datetime

Base = declarative_base()

class CM_Log(Base):
    __tablename__ = 'cm_log'
    id = Column('id', Integer, primary_key=True)
    date = Column('date', DateTime, default=datetime.datetime.fromtimestamp(time.time()).strftime('%Y-%m-%d %H:%M:%S'))
    timestamp = Column('timestamp', Integer, default=time.time())
    device_id = Column('device_id', Integer, default=0)
    device_name = Column('device_name', String(255), default='')
    query_id = Column('query_id', Integer, default=0)
    query_name = Column('query_name', String(255), default='')
    ip = Column('ip', String(16), default='')
    protocol = Column('protocol', String(64), default='')
    port = Column('port', Integer, default=0)
    uname_type = Column('uname_type', String(64), default='')
    uname = Column('uname', String(255), default='')
    path = Column('path', String(255), default='')
    status = Column('status', String(64), default='')
    message = Column('message', Text(), default='')

    def __repr__(self):
        return "<CM_Log(date='%s', device_id='%s', query='%s', ip='%s', protocol='%s', port='%s', uname_type='%s', uname='%s', path='%s', status='%s', message='%s')>" % (
                                self.date, self.device_id, self.query, self.ip, self.protocol, self.port, self.uname_type, self.uname, self.path, self.status, self.message)
