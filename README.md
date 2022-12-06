
## Jeremy Figured Test

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
