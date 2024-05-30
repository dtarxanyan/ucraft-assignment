#!/bin/bash
# Create the 'sail' network if it doesn't already exist
docker network inspect sail &>/dev/null || docker network create --driver bridge sail

docker pull composer:2.6.6

# shellcheck disable=SC2164
cd ./blog

docker run --rm --interactive --tty \
  --volume $PWD:/app \
  composer install --ignore-platform-req=ext-sockets

# shellcheck disable=SC2164
cd ../rabbitMQ

docker-compose up -d --build

# shellcheck disable=SC2164
cd ../blog
./vendor/bin/sail up -d --build

# shellcheck disable=SC2164
cd ../notifications

docker-compose up -d --build

# shellcheck disable=SC2164
cd ../blog

check_mysql() {
  ./vendor/bin/sail exec mysql mysqladmin ping -h"127.0.0.1" --silent
}

# Wait for MySQL to be ready
echo "Waiting for MySQL to be ready..."
until check_mysql; do
  >&2 echo "MySQL is unavailable - sleeping"
  sleep 2
done

echo "MySQL is up - running migrations"

# Run migrations
until ./vendor/bin/sail artisan migrate; do
  >&2 echo "Migration command failed - retrying"
  sleep 2
done

echo "Migrations completed successfully"
