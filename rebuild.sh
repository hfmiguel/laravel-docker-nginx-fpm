#!/bin/bash


printf 'Exporting UID and GID to use in the container\n'

export UID=$(id -u)
export GID=$(id -g)

USER_NAME=$(whoami)

echo -e "The UID is: $UID and the GID is: $GID The current user is: $USER_NAME"

printf 'Do you want to erase the containers volume ? [y/n]'
read answer

if [ "$answer" != "${answer#[Yy]}" ] ;then
    docker compose down -v
else
    docker compose stop
fi

docker compose up -d --build --force-recreate