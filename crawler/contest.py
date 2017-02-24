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
            contest['title'] = contest.pop('name')
            url = 'codeforces.com/contest/{}'.format(contest['id'])
            contest['description'] = '<a href="{}">{}</a>'.format(url, url)
            contest['uuid'] = '{}{}'.format(contest.pop('type'), contest.pop('id'))
            contest['begin_at'] = contest['startTimeSeconds']
            contest['end_at'] = contest.pop('startTimeSeconds') + contest.pop('durationSeconds')
            contest['class'] = 'bg-info'
            contest.pop('phase')
            contest.pop('frozen')
            contest.pop('relativeTimeSeconds')
            db.insert_or_update(contest, 'agendas', 'uuid')
