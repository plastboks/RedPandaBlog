Red Panda Blog
==============
Red panda blog got its name from the 'Code happy' book for Laravel 3 (http://codehappy.daylerees.com/). Although the project has evolved since then, it is where it all began. Red panda blog is now a Laravel 4 only.


Laravel
=======
This blog is based on the [Laravel PHP Framework](https://github.com/laravel/laravel)


Description
===========
This is just a simple blog written with the Laravel framework, with features like:
  * Admin area for administration of the blog.
  * Site settings.
  * Users and roles.
  * Permissions and capabilities.
  * Categories

The purpose of this is just self educational work with Laravel. 


Installation
============
Point your webserver at the /public folder.

* Run `composer install`
* Setup database in app/config/database.php
* If using sqlite touch a file in app/database (eg: `touch app/database/production.sqlite`)
* Generate app key via `php artisan key:generate` 
* Run `php artisan migrate`
* Goto http://hostname/install to create a new admin user
* Login via http://hostname/login
* Success :-)


Branches
========
There will mainly be two branches in this repo (@github) at all times. The master and develop branch.
The master branch will be kept back featurewise of the develop branch. This is to ensure the stability of the master branch.


Todos
=====
Most of the plans for this blog is kept as issues and milestones on Github. A small feature list follows:

* Images
* Tags alongside categories
* OpenID login
* Gravatar
* Comments
* User registration
* Captcha
* Document...

License
=======
The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
All the Red panda blog code is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
