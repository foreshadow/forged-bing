import mysqlbuilder
import urllib
import json
import time

url = 'http://contests.acmicpc.info/contests.json';

if __name__ == '__main__':
    db = mysqlbuilder.database(debug = True)
    html = urllib.urlopen(url).read()
    j = json.loads(html)
    for contest in j:
        contest.pop('week')
        contest.pop('access')
        #  db.insert_or_update(contest, 'info_contests', 'id')
        if contest['oj'] in ['AtCoder', 'Leetcode', 'BestCoder', 'Topcoder']:
            if contest['oj'] in ['BestCoder', 'Topcoder']:
                contest['class'] = 'bg-info'
            contest['uuid'] = '{}{}'.format(contest.pop('oj'), contest.pop('id'))
            contest['begin_at'] = int(time.mktime(time.strptime(contest.pop('start_time'), "%Y-%m-%d %H:%M:%S")))
            contest['end_at'] = contest['begin_at']
            contest['title'] = contest.pop('name')
            url = contest.pop('link')
            contest['description'] = '<a href="{}">{}</a>'.format(url, url)
            db.insert_or_update(contest, 'agendas', 'uuid')
