# Clockify

Clockify is a laravel web application with API endpoints and data in the MySQL
database for workers in the service industry to track worker clock-ins and clock-outs from a mobile deviceto enable accurate live data for decision makers.
- A worker can clock-in using a mobile app to signal their arrival at the work location (e.g.:
restaurant branch) and starting work for the day.

- Clock-in rejected if longitude and latitude are not within 2km of the selected location.

- A worker can view their clock-ins. 

## specifications
- All functions documented.
- All API endpoints documented using Swagger.
- All functions unit tested.

## How to use
Alternative installation is possible without local dependencies relying on [Docker](#Docker). 

Clone the repository

    git clone git@github.com:FatmaSaad/Clockify.git

Switch to the repo folder

    cd Clockify
Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate


Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

**TL;DR command list**

    git clone git@github.com:gothinkster/laravel-realworld-example-app.git
    cd laravel-realworld-example-app
    composer install
    cp .env.example .env
    php artisan key:generate
    php artisan jwt:generate 
    
**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate
    php artisan serve

## Database seeding

**Populate the database with seed data with relationships which includes users, articles, comments, tags, favorites and follows. This can help you to quickly start testing the api or couple a frontend and start using it with ready content.**

Open the DummyDataSeeder and set the property values as per your requirement

    database/seeds/DummyDataSeeder.php

Run the database seeder and you're done

    php artisan db:seed

***Note*** : It's recommended to have a clean database before seeding. You can refresh your migrations at any point to clean the database by running the following command

    php artisan migrate:refresh
    
## Docker
Use [sail](https://laravel.com/docs/11.x/sail#introduction) which is an interface for interacting with  [Docker](https://www.docker.com/) development environment to install clockify.

make sure your docker [installed and running](https://docs.docker.com/engine/install/).

In your terminal, use this command:

```bash
sail up
```
or

```bash
./vendor/bin/sail up
```
This command starts all the Docker containers required for Laravel development environment.

Run 

```bash
sail artisan migrate:fresh --seed
```
 This`ll create the database and insert a few fake records into it.




