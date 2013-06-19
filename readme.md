Red Panda Blog
==============
Red panda blog got its name from the 'Code happy' book for Laravel 3 (http://codehappy.daylerees.com/). Although the project has evolved since then, it is where it all began.

Description
===========
This is just a simple blog written with the Laravel framework, with features like:
  * Admin area for administration of the blog.
  * Site settings.
  * Users and roles.
  * Permissions and capabilities.
  * Categories and tags.
  * Images.

The purpose of this is just self educational work with Laravel. 

Installation
============
Point your webserver at the /public folder.

* Run `composer install`
* Setup database in app/config/database.php
* If using sqlite touch a file in app/database (eg: `touch app/database/production.sqlite`)
* Generate app key via `php artisan key:generate` 
* Run `php artisan migrate`
* Run `php artisan db:seed`
* Goto http://hostname/install to create a new admin user
* Login via http://hostname/login
* Success :)


Upgrading
=========
Be careful using `php artisan db:seed` when upgrading. This routine is programmed to delete existing records in the database.
* Run `php artisan migrate`
* Run `php artisan db:seed`


Issues
======
No known issues.
