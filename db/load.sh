#!/bin/sh

BASE_DIR=$(dirname "$(readlink -f "$0")")
if [ "$1" != "test" ]; then
    psql -h localhost -U sharecode -d sharecode < $BASE_DIR/sharecode.sql
    if [ -f "$BASE_DIR/sharecode_test.sql" ]; then
        psql -h localhost -U sharecode -d sharecode < $BASE_DIR/sharecode_test.sql
    fi
    echo "DROP TABLE IF EXISTS migration CASCADE;" | psql -h localhost -U sharecode -d sharecode
fi
psql -h localhost -U sharecode -d sharecode_test < $BASE_DIR/sharecode.sql
echo "DROP TABLE IF EXISTS migration CASCADE;" | psql -h localhost -U sharecode -d sharecode_test
