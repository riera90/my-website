#!/bin/sh
composer install
sed -i -r 's,(DATABASE_URL=).*,\1'"$DATABASE_URL"',' ./.env
./bin/console server:run 0.0.0.0:80