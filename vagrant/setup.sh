#!/bin/bash

sudo apt update

sudo apt install -y mysql-server

sudo mysql -u root << EOF

CREATE USER 'admin'@'%' IDENTIFIED BY 'Aa123456?';

GRANT ALL PRIVILEGES ON * . * TO 'admin'@'%';

EOF

sudo mysql -u root < /vagrant/database.sql

sudo cp -rf /vagrant/mysqld.cnf /etc/mysql/mysql.conf.d/

sudo systemctl restart mysql.service