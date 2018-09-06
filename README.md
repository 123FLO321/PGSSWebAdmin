# PGSSWebAdmin

PGSSWebAdmin is a Web Admin tool for [PGSS](http://github.com/mizu-github/PGSS) that allows submitting and monitoring of Pokemon- and Gym-Images, monitoring of Devices and viewing of Logs.

Run PGSSWebAdmin on the same server where the raidnearby processes are running at. (+ crop if you want the Devices feature to work proberly) 


## Getting Started

### MacOS

Apache and PHP are preinstalled on MacOS

- Go Into the Apache Directory
 ```cd /etc/apache2/```
- Copy the defailt config file (skip if there is a httpd.conf already)
``cp httpd.conf httpd.conf.sierra```
- Edit the config file
```nano httpd.conf```
  - Uncomment `LoadModule phpx_module ...`
  - Uncomment `LoadModule rewrite_module ...`
  - find `AllowOverride None` in `<Directory "/Library/WebServer/Documents">...</Directory>` and change it to: `AllowOverride All`
  - find `Require all denied` in `<Directory "/Library/WebServer/Documents">...</Directory>` and change it to: `Require all granted`

- Go into the WebRoot Directory
```cd /Library/WebServer/Documents```
- Delete every file in there if they are not needed any more 
```rm -r /Library/WebServer/Documents/*```
- Clone the repository
```git clone https://github.com/123FLO321/PGSSWebAdmin .```
- Copy the example config
```cp config.example.php config.php```
- Edit config
```nano config.php```
- (Re)Start apache
```apachectl restart```
- PGSSWebAdmin should now be runnin on that machine
(From same machine: http://localhost, From other machine: http://machine-ip)

### Linux

- Install NGINX and PHP7 debian / ubuntu:
```
sudo apt update 
sudo apt upgrade
sudo apt install php7.0 php7.0-fpm php7.0-mysql mysql-server
```

- Clone the project
```
cd /opt
git clone https://github.com/123FLO321/PGSSWebAdmin.git
cp config.example.php config.php
```
- Edit your config.php to match your pgss install dir and database with your favourite editer.
```vi config.php```
```
cp example.nginx.conf /etc/nginx/sites-available/pgsswebadmin.conf
ln -s /etc/nginx/sites-available/pgsswebadmin.conf /etc/nginx/sites-enabled/pgsswebadmin.conf
```
- Edit your pgsswebadmin.conf to match root dir of PGSSWebAdmin
```root /PATH/TO/PGSSWebAdmin;```
- Check nginx syntax with ```nginx -t```
- If it returns ```nginx: the configuration file /etc/nginx/nginx.conf syntax is ok```
- Reload nginx to activate the website ```nginx -s reload```
- PGSSWebAdmin should now be runnin on that machine
(From same machine: http://localhost, From other machine: http://machine-ip)
