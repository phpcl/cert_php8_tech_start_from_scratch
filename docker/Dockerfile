FROM asclinux/linuxforphp-8.2-ultimate:src
MAINTAINER doug.bierer@etista.com
RUN \
    echo "Compiling PHP 8 ..." && \
    cp /bin/lfphp-compile /bin/lfphp-compile-php8 && \
    sed -i 's/phpverscheckout=master/phpverscheckout=PHP-8.0/g' /bin/lfphp-compile-php8 && \
    sed -i 's/--prefix=\/usr/--prefix=\/usr --with-ffi --with-zip/g' /bin/lfphp-compile-php8 && \
    /bin/lfphp-compile-php8 && \
    ln -sfv /usr/bin/php /usr/bin/php8
RUN \
    echo "Enable display errors and configure php.ini for modifications later ..." && \
    sed -i 's/display_errors = Off/display_errors = On/g' /etc/php.ini && \
    sed -i 's/display_startup_errors = Off/display_startup_errors = On/g' /etc/php.ini && \
    sed -i 's/error_reporting =/;error_reporting =/g' /etc/php.ini && \
    echo "error_reporting = E_ALL" >>/etc/php.ini && \
    cp /etc/php.ini /tmp/php.ini && \
    chown apache:apache /etc/php.ini &&  \
    chmod 664 /etc/php.ini
RUN \
    echo "Creating sample database and assigning permissions ..." && \
    /etc/init.d/mysql start && \
    sleep 5 && \
    mysql -uroot -v -e "CREATE DATABASE cert_php8_tech;" && \
    mysql -uroot -v -e "CREATE USER 'php8_tech'@'localhost' IDENTIFIED BY 'password';" && \
    mysql -uroot -v -e "GRANT ALL PRIVILEGES ON *.* TO 'php8_tech'@'localhost';" && \
    mysql -uroot -v -e "FLUSH PRIVILEGES;"
RUN \
    echo "Installing phpMyAdmin ..." && \
    lfphp-get phpmyadmin && \
    chgrp -R apache /srv/phpmyadmin && \
    chmod -R 775 /srv/phpmyadmin && \
    export SECRET=`php -r 'echo base64_encode(random_bytes(24));'` && \
    echo "\$cfg['blowfish_secret'] = '$SECRET';" >> /srv/phpmyadmin/config.inc.php && \
    sed -i 's/global/error_reporting(E_ERROR)\;  global/g' /srv/phpmyadmin/index.php
RUN \
    echo "Setting up Apache ..." && \
    echo "ServerName cert_php8_tech" >> /etc/httpd/httpd.conf
CMD lfphp --mysql --phpfpm --apache
