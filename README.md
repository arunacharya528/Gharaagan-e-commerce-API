# Gharaagan e-commerce API

This is a [laravel](http://laravel.com) based ecommerce API

Prerequisites:
- PHP (^7.4.8)
- Composer (^2.0.13)

To run this api follow these steps:
1. Download this repository to your local machine
1. Run command `composer install` to install composer dependencies
1. Copy `.env.example` to `.env` file
1. Set name of mysql database to in `.env` to `gharagan_ecommerce_api`
1. Run command `php artisan migrate` to migrate tables into your database
1. Run command `php artisan db:seed` to fill newly migrated tables with data
1. Run command `php artisan key:generate` to generate an application key
1. Run command `php artisan serve` to start the server

## Database Schema
![Database Schema of this API](https://fabric.inc/wp-content/uploads/hubspot/ecommerce-platform-data-1.png)
