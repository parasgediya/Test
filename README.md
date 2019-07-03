# Test APP

Test APP is Football Club Management. Within a platform user can create, edit, update and delete clubs, users, teams, player groups and player information.
There are two different role Super admin and Club admin.
Super Admin : can create/edit/delete new club and users and also create new super admin
Club Admin : can create/edit/delete Team, Player Group and Players

## Installation

##Mac Os, Ubuntu and windows users continue here:
- Create a database locally named `test` utf8_general_ci 
- Download composer https://getcomposer.org/download/
- Pull Laravel/php project from git provider.
- Rename `.env.example` file to `.env`inside your project root and fill the database information.
  (windows wont let you do it, so you have to open your console cd your project root directory and run `mv .env.example .env` )
- Open the console and cd your project root directory
- Run `composer install` or ```php composer.phar install```
- Run `php artisan key:generate` 
- Run `php artisan migrate`
- Run `php artisan db:seed` to run seeders, if any.
- Run `php artisan serve`

#####You can now access your project at localhost:8000 :)

## If for some reason your project stop working do these:
- `composer install`
- `php artisan migrate`