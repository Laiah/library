# Biblio Bordeaux

You need to have **PHP >= 7.1 with the pdo_sqlite extension** installed on your device.   
[Composer](https://getcomposer.org/download/) is also required.

## Install
Install dependencies with command line:
```
composer install
```

Create the SQLite schema from migration files
```
php bin/console doctrine:migrations:migrate
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

Administration area is protected by Basic-Auth.

To add a admin account, you can edit the "memory" section in security.yml file:

```
security:
    providers:
        in_memory:
            memory:
                users:
                    admin:
                        password: $2y$12$k/wk6qOOPwv5fqmm/G9cme.y4cXyAkbNgC.H22Q.Bu0yLvSdT9.Ry
                        roles: 'ROLE_ADMIN'
                    my-new-admin-account:
                        password: my-encoded-password
                        roles: 'ROLE_ADMIN'
```

To encode the password with the provided encoder, use this CLI:

```
php bin/console security:encode-password
```

and copy/paste the value of "Encoded password" key to your new account.

The encoding actually used is Bcrypt with a cost of 12.

## Import initial data

Import base users (team Bordeaux) and base categories

```
php bin/console doctrine:database:import ./var/init-data-users.sql
php bin/console doctrine:database:import ./var/init-data-categories.sql
```

## Send reminder email

You can send reminder email to the borrower of a book with this command line :
```
php bin/console app:send-reminder-email $numberDays
```
You need to replace $numberDays with the number of days before the due date.
(e.g. if we are on the 23rd, `php bin/console app:send-reminder-email 4` will send email
for the books that need to be returned on the 27th)
