#!/bin/bash
DIR=`pwd`
TOOLS_DIR=$DIR/vendor/phpcl/lfc_tools
LFC_DIR=$DIR/vendor/linuxforphp/linuxforcomposer/bin
LFC_PID=$DIR/vendor/composer
export URL="php8cloudtech.net"
export CONTAINER="php8_cloud_tech"
export USAGE="Usage: lfc.sh up|down|start|stop|deploy|init|shell|swap|creds"
export INIT=0
export SWAP=0
if [[ -f "$LFC_PID/linuxforcomposer.pid" ]]; then
    export CONTAINER=`cat $LFC_PID/linuxforcomposer.pid`
fi
if [[ -z "$1" ]]; then
    echo $USAGE
    exit 1
fi
if [[ "$1" = "start" || "$1" = "stop" || "$1" = "deploy" ]]; then
    php $LFC_DIR/linuxforcomposer.phar docker:run $1
elif [[ "$1" = "creds" ]]; then
    php $TOOLS_DIR/generate_creds.php $2 $3 $4 $5 $6
elif [[ "$1" = "up" ]]; then
    docker-compose up -d --build
    SWAP=1
    INIT=1
elif [[ "$1" = "down" ]]; then
    docker exec $CONTAINER /bin/bash -c "rm /srv/repo/src/config/config.php"
    docker exec $CONTAINER /bin/bash -c "mv /srv/repo/src/config/config.php.bak /srv/repo/src/config/config.php"
    docker-compose down
    sudo chown -R $USER:$USER *
elif [[ "$1" = "build" ]]; then
    docker-compose build
elif [[ "$1" = "init" ]]; then
    INIT=1
elif [[ "$1" = "shell" ]]; then
    if [[ -z ${CONTAINER} ]]; then
        echo "Unable to locate running container: $CONTAINER"
    else
        docker exec -it $CONTAINER /bin/bash
    fi
elif [[ "$1" = "swap" ]]; then
    SWAP=1
else
    echo $USAGE
    exit 1
fi
if [[ "$SWAP" = "1" ]]; then
    if [[ -z ${CONTAINER} ]]; then
        echo "Unable to locate running container"
    else
        docker exec $CONTAINER /bin/bash -c "mv /srv/repo/src/config/config.php /srv/repo/src/config/config.php.bak"
        docker exec $CONTAINER /bin/bash -c "ln -s /srv/tempo/$URL/src/config/config.php /srv/repo/src/config/config.php"
        docker exec $CONTAINER /bin/bash -c "cd /srv/repo && php composer.phar update"
        docker exec $CONTAINER /bin/bash -c "mv -f /srv/www /srv/www.OLD"
        docker exec $CONTAINER /bin/bash -c "ln -s /srv/repo/public /srv/www"
        docker exec $CONTAINER /bin/bash -c "chgrp apache /srv/www"
        docker exec $CONTAINER /bin/bash -c "chgrp -R apache /srv/repo"
        docker exec $CONTAINER /bin/bash -c "chmod -R 775 /srv/repo"
    fi
fi
if [[ "$INIT" = "1" ]]; then
    if [[ -z ${CONTAINER} ]]; then
        echo "Unable to locate running container"
    else
        docker exec $CONTAINER /bin/bash -c "/etc/init.d/mysql start"
        docker exec $CONTAINER /bin/bash -c "/etc/init.d/php-fpm start"
        docker exec $CONTAINER /bin/bash -c "/etc/init.d/httpd start"
    fi
fi
