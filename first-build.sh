#!/bin/bash


export UID=$(id -u)
export GID=$(id -g)

docker compose down -v

cp .env.example .env

docker compose up -d --build