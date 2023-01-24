FROM 271217/felix-php-fpm:8.1

LABEL organization="FX DEV"
LABEL maintainer="Henrique Felix"
LABEL version="1.0"

ARG USER_UID=www-data
ARG USER_GID=www-data
ARG USER_NAME=www-data

ENV USER_UID $USER_UID
ENV USER_GID $USER_GID
ENV USER_NAME $USER_NAME

RUN apt-get update && apt-get install -y git

RUN groupadd -g $USER_GID $USER_NAME
RUN useradd -u $USER_UID -g $USER_GID -m $USER_NAME -s /bin/bash

# Create the user
RUN chown -R $USER_UID:$USER_GID /var/www/
RUN chown -R $USER_UID:$USER_GID /usr/local/
RUN chown -R $USER_UID:$USER_GID /var/log/

USER $USER_UID