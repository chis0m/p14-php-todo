# Laravel Quickstart - Basic

## Quick Installation

    git clone https://github.com/laravel/quickstart-basic quickstart

    cd quickstart

    composer install

    php artisan migrate

    php artisan serve

[Complete Tutorial](https://laravel.com/docs/9.x)


### Updates 
- change `.env.sample` to `.env.example`
- don't forget to install `php-curl` in JenkinsServer

### Important to Note
I am using the same database for real data and test. So all data will be missing after runnning php test. This is because the setup clears the database in order to run each test instance
