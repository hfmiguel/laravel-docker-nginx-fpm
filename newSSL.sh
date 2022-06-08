#!/bin/sh
if [ ! -f .env ]
then
  export $(cat .env | xargs)
fi

docker compose run --rm  certbot certonly --webroot --webroot-path /etc/certbot/ -d ${PROJECT_DOMAIN} --register-unsafely-without-email