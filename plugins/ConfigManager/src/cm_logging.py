from src import cm_debug as deb
from src.Models.CM_Log import CM_Log
#from alembic import op
from sqlalchemy import create_engine, MetaData, Table, Column, Integer, String, Text, DateTime
from sqlalchemy.orm import sessionmaker
import io
import datetime
import time

class cm_logging():
    def __init__(self, **parms):
        self.debug = parms.get("debug", False)
        self.target = parms.get("target", False)
        if self.target == 'mysql': self.db_init(**parms)
        if self.debug: deb.cm_debug.show( marker='debL', message = 'Loggin was Initiated')

    def db_init(self, **parms):
        uname = parms.get("username", 'username')
        passwd = parms.get("password", 'password')
        host = parms.get("host", 'host')
        database = parms.get("database", 'database')
        try:
            self.db = create_engine( 'mysql://{}:{}@{}/{}'.format(uname,passwd,host,database), encoding='utf8' )
            if not self.db.dialect.has_table(self.db, 'cm_log'):
                if self.debug: deb.cm_debug.show( marker='debL', message = 'Where is my table?')
                metadata = MetaData(self.db)
                # Create a table with the appropriate Columns
                Table('cm_log', metadata,
                      Column('id', Integer, primary_key=True),
                      Column('date', DateTime),
                      Column('timestamp', Integer),
                      Column('device_id', Integer),
                      Column('device_name', String(255)),
                      Column('query_id', Integer),
                      Column('query_name', String(255)),
                      Column('ip', String(16)),
                      Column('protocol', String(64)),
                      Column('port', Integer),
                      Column('uname_type', String(64)),
                      Column('uname', String(255)),
                      Column('path', String(255)),
                      Column('status', String(64)),
                      Column('message', Text())
                      )
                # Implement the creation
                metadata.create_all()
                if self.debug: deb.cm_debug.show( marker='debL', message = 'Log table created')
            else:
                if self.debug: deb.cm_debug.show( marker='debL', message = 'Log table exist')
            # inspector = inspect(self.db)
            # columns = inspector.get_columns('cm_log')
            # if sorted([c['name'] for c in columns]) != sorted([c['name'] for c in self.schema]):
            #     missing_ = list( set([c['name'] for c in self.schema]) - set([c['name'] for c in columns]) )
            #     if self.debug: deb.cm_debug.show( marker='debL', message = 'Some column missing: ' + ', '.join(missing_))
        except Exception as e:
            if self.debug: deb.cm_debug.show( marker='debL', message = 'Error: {}'.format(e))
            return False
        Session = sessionmaker(bind=self.db)
        self.session = Session()

    def add(self, **parms):
        first = CM_Log(**parms)
        self.session.add( first )
        self.session.commit()
    schema = [
        { 'name':'status', 'type': 'string'},
        { 'name':'date', 'type': 'integer'},
        { 'name':'d_id', 'type': 'integer'},
        { 'name':'ip', 'type': 'string'},
        { 'name':'message', 'type': 'text'}
    ]
