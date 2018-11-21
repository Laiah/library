# Biblio Bordeaux

You need to have **PHP >= 7.1 with the pdo_sqlite extension** installed on your device.   
[Composer](https://getcomposer.org/download/) is also required.

## Install
Install dependencies with command line:
```
composer install
```

Create the SQLite schema
```
php bin/console doctrine:schema:create
```

The Sqlite database is created under `var/data.db`

You can use a tool such as "DB Browser for SQLite" to manage data.
https://sqlitebrowser.org/


## Run the project
```
php bin/console server:run
```

You can now open your browser and navigate to: [http://127.0.0.1:8000](http://127.0.0.1:8000)    
The port can changed if port 8000 is not available.


## Administration

The admin part is located under /admin:
[http://127.0.0.1:8000/admin](http://127.0.0.1:8000/admin)
