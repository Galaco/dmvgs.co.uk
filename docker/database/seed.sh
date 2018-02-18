#!/bin/bash
echo "Seeding database..."
mysql -u root -ppassword dmvgs_forum < /tmp/dump.sql

echo "Database seeded!"