ARG PHPVERSION=8.2.3-fpm@sha256:dabb568050643b8a1f44c87e2c18e2bf464da15529bba654c6ae6c5e677dad70

FROM php:${PHPVERSION}

LABEL organization="FX DEV"
LABEL maintainer="Henrique Felix"
LABEL version="1.0"

USER root

ARG USERUID=www-data
ARG USERGID=www-data
ARG USERNAME=www-data

ENV USERUID $USERUID
ENV USERGID $USERGID
ENV USERNAME $USERNAME

# Create the user
RUN groupadd -g $USERGID $USERNAME \
  && useradd --uid $USERUID --gid $USERGID -m $USERNAME \
  && chown -R $USERUID:$USERGID /home/$USERNAME \
  && chown -R $USERUID:$USERGID /usr/local \
  && chown -R $USERUID:$USERGID /var/log \
  && chown -R $USERUID:$USERGID /var/www/

RUN apt-get update && apt-get install -y libpng-dev \
  libwebp-dev \
  libjpeg62-turbo-dev \
  libxpm-dev \
  libfreetype6-dev \
  libbz2-dev \
  libonig-dev \
  curl \
  libxml2-dev \
  libzip-dev

RUN docker-php-ext-configure gd --with-freetype --with-webp --with-jpeg && \
  docker-php-ext-install mysqli pdo pdo_mysql gd bz2 zip mbstring exif opcache && \
  docker-php-ext-enable mysqli pdo pdo_mysql && \
  docker-php-ext-enable sodium && \
  docker-php-ext-configure opcache --enable-opcache

RUN curl https://curl.se/ca/cacert.pem --output /etc/ssl/cacert.pem

COPY ./Docker/php/php.ini /usr/local/etc/php/php.ini
COPY ./Docker/php/php-fpm.conf /usr/local/etc/php-fpm.conf
COPY ./Docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini


USER $USERNAME