# 6quests
## stub
Simple web site for making quests more simplier.

## Installing
```
git clone https://github.com/6dreams/6quests
```
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
Install dependies:
```
composer up
```
Create database and user:
```
bin/console quests:install
```