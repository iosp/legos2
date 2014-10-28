#!/bin/sh
#
# Setzt die Datenbank neu auf

DB=legos2
USER=root
PASS=admin123
MYSQL=/usr/bin/mysql
PHP=/usr/bin/php

echo "Leere DB..."
echo "DROP database IF EXISTS $DB;" | $MYSQL --user="$USER" -p"$PASS" $DB
#echo "CREATE database $DB;" | $MYSQL --user=root -p"$PASS"
echo "CREATE database $DB CHARACTER SET utf8 COLLATE utf8_general_ci;" | mysql --user=root -p"$PASS"

echo "Lösche Cache..."
symfony cache:clear >/dev/null
echo "Erstelle Datenbank und lade Fixtures..."
symfony --no-confirmation propel:build-all-load > /dev/null

