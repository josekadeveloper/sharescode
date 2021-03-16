#!/bin/sh

if [ "$1" = "travis" ]; then
    psql -U postgres -c "CREATE DATABASE sharecode_test;"
    psql -U postgres -c "CREATE USER sharecode PASSWORD 'sharecode' SUPERUSER;"
else
    [ "$1" = "test" ] || sudo -u postgres dropdb --if-exists sharecode
    sudo -u postgres dropdb --if-exists sharecode_test
    [ "$1" = "test" ] || sudo -u postgres dropuser --if-exists sharecode
    [ "$1" = "test" ] || sudo -u postgres psql -c "CREATE USER sharecode PASSWORD 'sharecode' SUPERUSER;"
    [ "$1" = "test" ] || sudo -u postgres createdb -O sharecode sharecode
    [ "$1" = "test" ] || sudo -u postgres psql -d sharecode -c "CREATE EXTENSION pgcrypto;" 2>/dev/null
    sudo -u postgres createdb -O sharecode sharecode_test
    sudo -u postgres psql -d sharecode_test -c "CREATE EXTENSION pgcrypto;" 2>/dev/null
    [ "$1" = "test" ] && exit
    LINE="localhost:5432:*:sharecode:sharecode"
    FILE=~/.pgpass
    if [ ! -f $FILE ]; then
        touch $FILE
        chmod 600 $FILE
    fi
    if ! grep -qsF "$LINE" $FILE; then
        echo "$LINE" >> $FILE
    fi
fi
