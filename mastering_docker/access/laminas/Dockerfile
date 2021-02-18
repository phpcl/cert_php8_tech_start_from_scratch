FROM asclinux/linuxforphp-8.2-ultimate:7.4-nts
COPY composer.phar /srv
RUN \
    echo "Installing the Laminas skeleton app ..." && \
    cd /srv && \
    php composer.phar create-project --no-scripts --remove-vcs -s dev laminas/laminas-mvc-skeleton laminas && \
    mv -f /srv/www /srv/www.OLD && \
    ln -s /srv/laminas/public /srv/www && \
    chown apache:apache /srv/www && \
    chown -R apache:apache /srv/laminas
CMD lfphp --mysql --phpfpm --apache
