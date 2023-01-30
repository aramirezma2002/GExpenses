#!/bin/bash

sudo apt update

sudo apt install -y mysql-server

sudo apt install -y apache2

sudo add-apt-repository ppa:ondrej/php -y

sudo apt install php8.1 -y

sudo apt install php8.1-mysql
 
sudo mysql -u root << EOF

CREATE USER 'admin'@'%' IDENTIFIED BY 'Aa123456?';

GRANT ALL PRIVILEGES ON * . * TO 'admin'@'%';

EOF

sudo mysql -u root < /vagrant/database.sql

sudo cp -rf /vagrant/mysqld.cnf /etc/mysql/mysql.conf.d/

sudo cp -a /vagrant/code/. /var/www/html/

sudo rm /var/www/html/index.html

sudo systemctl restart mysql.service

sudo systemctl restart apache2.service