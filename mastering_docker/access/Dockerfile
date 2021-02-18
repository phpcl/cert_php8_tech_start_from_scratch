FROM asclinux/linuxforphp-8.2-ultimate:8.0-nts
COPY cert_php8_tech.sql /tmp/db.sql
COPY phpmyadmin_LfPHP_setup.sh /tmp/setup.sh
RUN \
    echo "Creating sample database and assigning permissions ..." && \
    /etc/init.d/mysql start && \
    sleep 5 && \
    mysql -uroot -v -e "CREATE DATABASE IF NOT EXISTS php8cloudtech;" && \
    mysql -uroot -v -e "CREATE USER IF NOT EXISTS 'php8cloudtech'@'localhost' IDENTIFIED BY 'php8!zGr8';" && \
    mysql -uroot -v -e "GRANT ALL PRIVILEGES ON *.* TO 'php8cloudtech'@'localhost';" && \
    mysql -uroot -v -e "FLUSH PRIVILEGES;" && \
    echo "Restoring sample database ..." && \
    mysql -uroot -e "SOURCE /tmp/db.sql;" php8cloudtech
RUN \
    echo "Setting up phpMyAdmin ..." && \
    chmod +x /tmp/*.sh && \
    /tmp/setup.sh
CMD lfphp --mysql --phpfpm --apache
