
## Jeremy Figured Test

### Dev Environment

This project uses Laravel Sail to manage the local dev environment. You will need Docker installed.

To start execute `./vendor/bin/sail up`

Get a list of all container running by `docker ps`

Get a shell on the container running PHP by executing `docker exec -it --user root jeremy-test-laravel.test-1 bash`

### Execute Test

Obtain a shell and then execute `php artion test`
