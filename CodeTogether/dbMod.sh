#!/bin/bash

set -a
source .env
set +a

CONTAINER_NAME="mariadb"

echo "Connecting to database '$MYSQL_DATABASE' as user '$MYSQL_USER'..."

docker exec -it $CONTAINER_NAME mariadb -u"$MYSQL_USER" -p"$MYSQL_PASSWORD" "$MYSQL_DATABASE"
