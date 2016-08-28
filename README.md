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
