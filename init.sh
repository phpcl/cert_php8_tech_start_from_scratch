#!/bin/bash
DIR=`pwd`
TOOLS_DIR=$DIR/vendor/phpcl/lfc_tools
LFC_DIR=$DIR/vendor/linuxforphp/linuxforcomposer/bin
LFC_PID=$DIR/vendor/composer
export USAGE="Usage: init.sh up|down|init|build|restore_db|shell|deploy"
export CONTAINER="cert_php8_tech"
export INIT=0
if [[ -z "$1" ]]; then
    echo $USAGE
    exit 1
elif [[ "$1" = "up" ]]; then
    docker-compose up -d $2
    INIT=1
    RESTORE_DB=1
elif [[ "$1" = "down" ]]; then
    docker-compose down
elif [[ "$1" = "build" ]]; then
    docker-compose build $2
elif [[ "$1" = "restore_db" ]]; then
    RESTORE_DB=1
elif [[ "$1" = "init" ]]; then
    INIT=1
elif [[ "$1" = "shell" ]]; then
    docker exec -it $CONTAINER /bin/bash
else
    echo $USAGE
    exit 1
fi
if [[ "$INIT" = 1 ]]; then
    echo "Initializing the Container ..."
    docker exec $CONTAINER /bin/bash -c "mv -f /srv/www /srv/www.OLD"
    docker exec $CONTAINER /bin/bash -c "ln -sfv /repo /srv/www"
    docker exec $CONTAINER /bin/bash -c "chgrp apache /srv/www"
    docker exec $CONTAINER /bin/bash -c "chgrp -R apache /repo"
    docker exec $CONTAINER /bin/bash -c "chmod -R 775 /repo"
    docker exec $CONTAINER /bin/bash -c "/etc/init.d/mysql start"
    docker exec $CONTAINER /bin/bash -c "/etc/init.d/php-fpm start"
    docker exec $CONTAINER /bin/bash -c "/etc/init.d/httpd start"
fi
if [[ "$RESTORE_DB" = 1 ]]; then
    echo "Restoring sample database ..."
    docker exec $CONTAINER /bin/bash -c 'mysql -uroot -e "SOURCE /repo/sample_data/cert_php8_tech.sql;" cert_php8_tech'
    docker exec $CONTAINER /bin/bash -c 'cp /repo/sample_data/sqlite.db /tmp/sqlite.db'
fi
exit 0
