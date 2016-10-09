# ETNA SCHOOL CHALLENGE

This is a project of the ETNA school. The goal was to create a part of a learning manager system using the estimote beacon technologies.

This part is the Symfony API use by the android application and react web application.

KIWI API
========

#### requirements

- composer should be installed
- have a mysql database

#### installation

```bash
composer install
php bin/console doctrine:schema:update --force --dump-sql
php bin/console doctrine:fixtures:load -y
php bin/console server:start
```

go to http://localhost:8000/api/doc 

auth route: http://localhost:8000/authenticate with params `_username` & `_password`
