## About Backend Scopic test

Summary of main features:
1. Home Page – Item’s listing (preferably in gallery view)
2. Item Detail Page with Item bidding history
3. Bid Now functionality
4. Auto-bidding functionality

---
To run this project you have two options:

### Using Docker

Clone this repository and run command:

`cp .env.example .env`

Install composer dependencies running this command:

`docker run --rm -u "$(id -u):$(id -g)" -v $(pwd):/opt -w /opt laravelsail/php74-composer:latest composer install --ignore-platform-reqs`

[Laravel Sail] is installed on project, and you can start using:

`./vendor/bin/sail up -d`

After that, run the migrations to use the database:

`./vendor/bin/sail migrate --seed --force`

[Laravel Sail]: https://laravel.com/docs/8.x/sail

### Using local environment

- Copy and paste .env.example
- Configure database credentials, can be (mysql, postgres, sqlserver)
- Run command to install dependencies: `composer install`
- Create an app key: `php artisan key:generate`
- Feed database with necessary tables and datas: `php artisan migrate --seed`
