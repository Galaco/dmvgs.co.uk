#!/bin/bash
echo "Creating database..."
mysql -u root -ppassword -e "DROP DATABASE IF EXISTS dmvgs_forum"
mysql -u root -ppassword -e "CREATE DATABASE dmvgs_forum"
# mysql -u root -ppassword dmvgs_forum < /tmp/dump.sql

echo "Database created!"