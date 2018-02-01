# 6quests
## Description
Simple web site for making offline quests managment more simplier. Originally created for [nostops.ru](http://nostops.ru)

## Installing
```
git clone https://github.com/6dreams/6quests
```
Install dependies:
```
composer up
```
Create database schema and other stuff:
```
bin/console quests:install
```
### Misc
Part of nginx config.
```
 root '/var/www/6quests/public/';

 location / {
    index index.php;
    if (!-e $request_filename) {
       rewrite ^/(.*)$ /index.php?q=$1 last;
    }
 }
```