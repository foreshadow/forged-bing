import mysqlbuilder
import urllib
import json

recent = 10
url = 'http://codeforces.com/api/contest.list';

if __name__ == '__main__':
    db = mysqlbuilder.database(debug = True)
    html = urllib.urlopen(url).read()
    j = json.loads(html)
    if j['status'] == 'OK':
        for contest in j['result'][: recent]:
            db.insert_or_update(contest, 'codeforces_contests', 'id')
