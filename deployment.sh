#!/bin/sh
cd /var/www/html/googlemaps/
sudo git pull origin master
sudo service apache2 restart
