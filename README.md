# Forged Bing
Infinity's forged bing with calendar and links.

## Requirements
- bash
- mysql
- php
  - mbstring
  - fileinfo
  - openssl
- composer
- node.js

- python 2.7 if you want to crawl online algorithm contests

## Install
```
$ git clone git@github.com:foreshadow/forged-bing.git
$ cd forged-bing
$ composer install
$ npm update
$ gulp
```
Then configure mysql in `.env`

## Run
```
$ php artisan serve
```
or
```
$ cd public
$ php -S localhost:80
```
or configure your Apache / NginX / IIS server.

## Configure auto run
1. Update `cd` path in `serve.sh`  
2. Add `serve.sh` to scheduled task / cron / start folder

## Craw contests
- Add `crawler/contest.py` and `crawler/acmicpc.py` to your auto-run task manager.

## Modify links
- Editing `resources/views/index.blade.php` manually.

## How to recover deleted agendas
- Edit database manually
  - set column `deleted_at` (of the rows you want to recover) to `NULL`
