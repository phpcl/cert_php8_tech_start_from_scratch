#!/usr/bin/env bash
export VER=5.0.4
cd /tmp
wget -O phpMyAdmin-$VER-all-languages.tar.gz https://files.phpmyadmin.net/phpMyAdmin/$VER/phpMyAdmin-$VER-all-languages.tar.gz
tar -xvf phpMyAdmin-$VER-all-languages.tar.gz
cp -rf phpMyAdmin-$VER-all-languages /srv/phpmyadmin
rm -rf phpMyAdmin-$VER-all-languages
cat >/etc/httpd/extra/httpd-phpmyadmin.conf << 'EOF'
Alias /phpmyadmin /srv/phpmyadmin
<Directory "/srv/phpmyadmin">
    #
    # Possible values for the Options directive are "None", "All",
    # or any combination of:
    #   Indexes Includes FollowSymLinks SymLinksifOwnerMatch ExecCGI
    #   MultiViews
    #
    # Note that "MultiViews" must be named *explicitly* --- "Options
    # All"
    # doesn't give it to you.
    #
    # The Options directive is both complicated and important.  Please
    # see
    # http://httpd.apache.org/docs/2.4/mod/core.html#options
    # for more information.
    #
    Options Indexes FollowSymLinks
    #
    # AllowOverride controls what directives may be placed in .htaccess
    # files.
    # It can be "All", "None", or any combination of the keywords:
    #   AllowOverride FileInfo AuthConfig Limit
    #
    AllowOverride All
    #
    # Controls who can get stuff from this server.
    #
    Require all granted
</Directory>
EOF
echo 'Include /etc/httpd/extra/httpd-phpmyadmin.conf' >> /etc/httpd/httpd.conf
cp /srv/phpmyadmin/config.sample.inc.php /srv/phpmyadmin/config.inc.php
sed -i "s/AllowNoPassword'] = false;/AllowNoPassword'] = true;/" /srv/phpmyadmin/config.inc.php
echo "Setting apache as owner ..."
chown -R apache:apache /srv/phpmyadmin
echo "Configuring blowfish secret in /srv/phpmyadmin/config.inc.php ... "
export SECRET=`php -r "echo md5(date('Y-m-d-H-i-s') . rand(1000,9999));"`
echo "\$cfg['blowfish_secret'] = '$SECRET';" >> /srv/phpmyadmin/config.inc.php
if [[ $? -gt 0 ]]; then
echo -e "\nphpMyAdmin Installation ERROR!  Aborting!\n"
exit 1
fi
/etc/init.d/mysql restart
/etc/init.d/php-fpm restart
/etc/init.d/httpd restart
echo -e "\nphpMyAdmin installed into /srv/phpmyadmin\n"
cd
