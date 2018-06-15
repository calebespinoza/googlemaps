#!/bin/sh
cd /var/www/html/googlemaps/
git pull origin master
sudo service apache2 restart
