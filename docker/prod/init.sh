#!/bin/sh
composer install
sed -i -r 's,(DATABASE_URL=).*,\1'"$DATABASE_URL"',' ./.env
sed -i -r 's,(.*)(driver: ).*,\1\2'"$DRIVER"',' ./config/packages/doctrine.yaml
sed -i -r 's,(.*)( charset: ).*,\1\2'"$CHARSET"',' ./config/packages/doctrine.yaml
sed -i -r 's,(.*)(collate: ).*,\1\2'"$COLLATE"',' ./config/packages/doctrine.yaml
./bin/console server:run 0.0.0.0:80