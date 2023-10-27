FROM alpine:3.18

# for laravel lumen run smoothly
RUN apk --no-cache --repository https://dl-cdn.alpinelinux.org/alpine/edge/main add \
php81 \
php81-fpm \
php81-pdo \
php81-mbstring \
php81-openssl

# for our code run smoothly
RUN apk --no-cache --repository https://dl-cdn.alpinelinux.org/alpine/edge/main add \
php81-json \
php81-dom  \
php81-mysqli \
php81-pdo_mysql

# for swagger run smoothly
RUN apk --no-cache --repository https://dl-cdn.alpinelinux.org/alpine/edge/main add \
php81-tokenizer

# for composer & our project depency run smoothly
RUN apk --no-cache --repository https://dl-cdn.alpinelinux.org/alpine/edge/main add \
php81-phar \
php81-xml \
php81-xmlwriter \
php81-session

# if need composer to update plugin / vendor used
RUN php81 -r "copy('http://getcomposer.org/installer', 'composer-setup.php');" && \
php81 composer-setup.php --install-dir=/usr/bin --filename=composer && \
php81 -r "unlink('composer-setup.php');"

# copy all of the file in folder to /src
COPY . /src
WORKDIR /src

# install composer dependencies
RUN composer install --no-dev

# run the php server service
# move this command to -> docker-compose.yml
# CMD php -S 0.0.0.0:8080 public/index.php