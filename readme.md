# Red Panda Blog
==============

Description
===========
This is just a stupid simple blog written with the Laravel framework.
The purpose of this is just self educational work with Laravel.

Installation
============

Point your webserver at the public folder.

* run `php artisan migrate:install`
* run `php artisan migrate`
* goto http://hostname/install to create a new admin user


Issues
======

During installation line 179: '$settings->loadSettings($settings->all());' in application/start.php has to be commented out.
Hopefully this little bug will be fixed soon.
