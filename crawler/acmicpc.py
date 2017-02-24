import mysqlbuilder
import urllib
import json

url = 'http://contests.acmicpc.info/contests.json';

if __name__ == '__main__':
     db = mysqlbuilder.database(debug = True)
     html = urllib.urlopen(url).read()
     j = json.loads(html)
     for contest in j:
         contest.pop('week')
         contest.pop('access')
         db.insert_or_update(contest, 'info_contests', 'id')
