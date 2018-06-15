#!/bin/sh
cd /var/www/html/
sudo git pull origin master
sudo service apache2 restart
