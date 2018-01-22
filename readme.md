Requirements php 7.1, mysql, npm, node js

-----------------installation-----------------------------

1. Prepare .env like .env.dist and change database section

2. Install dependencies
composer install
npm install

3. Generate database
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

4. Generate assets
./node_modules/.bin/encore dev

5. Run server
php bin/console server:run
open http://localhost:8000 in browser

---------------development---------------------------------

1. use watcher to edit and reloading scss files in real time
./node_modules/.bin/encore dev --watch
  
2. use migration to saving every database structure or init-data changes
php bin/console doctrine:migrations:diff   