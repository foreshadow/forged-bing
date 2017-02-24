import env
import mysql.connector
import string

class database:
    '''Mysql wrapper by Infinity'''
    def __init__(self, debug = False):
        self.debug = debug
        self.connection = mysql.connector.connect(
            user = env.user,
            password = env.password,
            database = env.database
        )
        self.cursor = self.connection.cursor()

    def __del__(self):
        self.cursor.close()
        self.connection.close()

    def execute(self, statement, array = []):
        self.cursor.execute(statement, array)
        self.connection.commit()

    def query(self, statement, array = []):
        return self.cursor.execute(statement, array)

    def insert_or_update(self, array, table, primarykey):
        '''Typically useful for decoded json'''
        try:
            self.auto_insert(array, table)
        except Exception, e:
            print e
            self.__err('Insert failed, row exist?')
            self.auto_update(array, table, primarykey)

    def auto_insert(self, array, table):
        statement = 'insert into {} ({}) values ({})'.format(
            table,
            string.join([self.__escape_key(column) for column in array], ', '),
            string.join([self.__escape_value(array[column]) for column in array], ', ')
        )
        self.__err(statement)
        self.execute(statement)

    def auto_update(self, array, table, primarykey):
        statement = 'update {} set {} where {} = {}'.format(
            table,
            string.join([
                '{} = {}'.format(self.__escape_key(column), self.__escape_value(array[column]))
                for column in array
            ], ', '),
            self.__escape_key(primarykey),
            self.__escape_value(array[primarykey])
        )
        self.__err(statement)
        self.execute(statement)

    def __err(self, message):
        if self.debug:
            print message

    @staticmethod
    def __escape_key(key):
        return "`{}`".format(key)

    @staticmethod
    def __escape_value(value):
        if type(value) == type(0):
            return str(value)
        else:
            return "'{}'".format(str(value).replace("'", "''"))
