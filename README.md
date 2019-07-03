# Test APP

Test APP is Football Club Management. Within a platform user can create, edit, update and delete clubs, users, teams, player groups and player information.
There are two different role Super admin and Club admin.
Super Admin : can create/edit/delete new club and users and also create new super admin
Club Admin : can create/edit/delete Team, Player Group and Players

## Userd Libraries
 - laravel-medialibrary - v7 :
       You'll find the documentation on [https://docs.spatie.be/laravel-medialibrary/v7](https://docs.spatie.be/laravel-medialibrary/v7).

 - laravel-activitylog - v3 :
       You'll find the documentation on [https://docs.spatie.be/laravel-activitylog/v3](https://docs.spatie.be/laravel-activitylog/v3).

 - laravel-impersonate :
        Laravel Impersonate makes it easy to authenticate as your users. Add a simple trait to your user model and impersonate as one of your users in one click.

 ## Requirements

- Laravel >= 5.8
- PHP >= 7.1

## Installation

##Mac Os, Ubuntu and windows users continue here:

      Download repository follow below steps :
      Setup .env file with your MySQL connection details

- Create a database locally named `test` utf8_general_ci 
- Download composer https://getcomposer.org/download/
- Pull Laravel/php project from git provider.
- Rename `.env.example` file to `.env`inside your project root and fill the database information.
  (windows wont let you do it, so you have to open your console cd your project root directory and run `mv .env.example .env` )
- Open the console and cd your project root directory
- Run `composer install` or ```php composer.phar install```
- Run `php artisan key:generate` 
- Run `php artisan migrate`
      It will create tablei in your database which you mentioned in .env file with default admin user
      admin@admin.com and password : 123456
- Run `php artisan serve`
      This return project URL : http://localhost:8000
      Open in your browser


#####You can now access your project at localhost:8000 :)

## If for some reason your project stop working do these:
- `composer install`
- `php artisan migrate`