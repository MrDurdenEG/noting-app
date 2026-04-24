# pull php image
FROM php:8.2-apache
# install mysqli extension
RUN docker-php-ext-install mysqli
# copy source code to container
COPY . /var/www/html/
# expose port 80
EXPOSE 80
