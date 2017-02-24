import mysqlbuilder
import urllib
import json

url = 'http://codeforces.com/api/user.info?handles={}';

if __name__ == '__main__':
    db = mysqlbuilder.database(debug = True)
    db.query('select handle from users', [])
    for row in db.cursor.fetchall():
        handle = row[0]
        if handle:
            html = urllib.urlopen(url.format(handle)).read()
            j = json.loads(html)
            if j['status'] == 'OK':
                db.insert_or_update(j['result'][0], 'codeforces_users', 'handle')
