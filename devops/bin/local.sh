#!/bin/bash
#combined docker compose file
COMPOSE_FILES="-f devops/deploy/local/docker-compose.yml"
NAME_PREFIX=app

#ensure that old containers are removed
docker-compose -p $NAME_PREFIX $COMPOSE_FILES rm -f

#start application localy for development with shared folders
docker-compose -p $NAME_PREFIX $COMPOSE_FILES build --pull
docker-compose -p $NAME_PREFIX $COMPOSE_FILES up -d --force-recreate

#install deps
docker-compose -p $NAME_PREFIX $COMPOSE_FILES exec app php composer.phar install --no-interaction

#run migrations
docker-compose -p $NAME_PREFIX $COMPOSE_FILES exec app php bin/console do:mi:mi --no-interaction

docker-compose -p $NAME_PREFIX $COMPOSE_FILES exec app sh
