import mysqlbuilder
import urllib
import json

count = 25
url = 'http://codeforces.com/api/user.status?handle={}&from=1&count={}';

if __name__ == '__main__':
    db = mysqlbuilder.database(debug = True)
    db.query('select handle from users', [])
    for row in db.cursor.fetchall():
         handle = row[0]
         print handle
         html = urllib.urlopen(url.format(handle, count)).read()
         j = json.loads(html)
         for row in j['result']:
             author = row.pop('author')
             problem = row.pop('problem')
             row['handle'] = handle
             row['index'] = problem['index']
             row['name'] = problem['name']
             db.insert_or_update(row, 'codeforces_statuses', 'id')
