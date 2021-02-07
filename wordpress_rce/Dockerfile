FROM wordpress:4.9.8-php7.1

RUN docker-php-ext-install mbstring bcmath

RUN pecl install xdebug-2.9.2 && docker-php-ext-enable xdebug

ENV PHP_IDE_CONFIG 'serverName=DockerApp'

ADD config/xdebug.ini /usr/local/etc/php/conf.d
ADD config/000-default.conf /etc/apache2/sites-available
ADD config/ports.conf /etc/apache2
RUN service apache2 restart
RUN echo "define( 'WP_AUTO_UPDATE_CORE', false );" >> /var/www/html/wp-config.php