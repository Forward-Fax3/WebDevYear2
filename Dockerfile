FROM php:8.5.2-apache
RUN docker-php-ext-install mysqli
RUN a2enmod headers
RUN a2enmod rewrite
RUN /etc/init.d/apache2 restart
