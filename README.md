# PetStore API Integration

## Api docs:
https://petstore.swagger.io/

## Installation

This guide assumes you are using Laravel Sail to run the application and a Linux distribution.

1. Clone repository 
2. Copy `.env.example` file: `cp .env.example .env`
3. Since Laravel Sail is a Composer package, you need to have Composer installed locally. To install the project, run:
```composer install```
4. Set `WWWUSER` and `WWWGROUP` variables in `.env` file to avoid file permission issues. 
You can check this value by running this commands `id -u` and `id -g`
5. Optional) Create a bash alias for Laravel Sail (the rest of the steps assume you've done this; if not, replace these commands with ./vendor/bin/sail):
`alias sail="$HOME/$PROJECT_DIR/vendor/bin/sail` (Replace $PROJECT_DIR with the path to your project directory). You might want to add this alias to the .bashrc file in your home directory so that it is automatically added at terminal startup.
6. Build containers: `sail build`
7. Run containers as daemon `sail up -d`
8. Generate application encryption key `sail artisan key:generate`
9. Access application: http://localhost 

### Useful commands
1. Run tests ```sail test```
2. Run container shell ```sail shell```

### Running tests with PHPStorm IDE
By default, Sail containers use the root user to run, which can cause permission issues when running tests, especially when tests create or modify files.
To resolve this, configure PhpStorm to use the `docker-compose` PHP interpreter to run PHP through the `/var/www/html/as-sail.sh` script (don’t forget to make this script executable).
