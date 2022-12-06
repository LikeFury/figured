
## Jeremy Figured Test

### TLDR:

1. Start containers by executing `./vendor/bin/sail up`
2. Get a shell on the PHP container by executing `docker exec -it --user root jeremy-test-laravel.test-1 bash`
3. Migrate by executing `php artisan migrate`
4. Seed test data by executing `php artisan db:seed --class=TestDataSeeder`
5. Go to `localhost` in your browser

### Dev Environment

This project uses Laravel Sail to manage the local dev environment. You will need Docker installed.

To start execute `./vendor/bin/sail up`

Get a list of all containers running by `docker ps`. Find the PHP container and get its name

Get a shell on the container running PHP by executing `docker exec -it --user root jeremy-test-laravel.test-1 bash`

A PHPMyAdmin is available on port `8080` for ease of DB administration

### Seed the test data

In the containers shell, execute the following:

`php artisan migrate` to create the database schema

`php artisan db:seed --class=TestDataSeeder` to seed the test data

### Execute Test

Obtain a shell and then execute `php artion test`

### Front End

A compiled FE build was included for your convenience

Install the front end assets by executing `npm i`

To run near time building for development execute `npm run dev`

To build assets for production execute `npm run build`
