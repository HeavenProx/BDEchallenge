# BDE Challenge Project - Science U
***Authors : Mathis Enrici - Morgan Kpassi - Hugo Duperthuy***

## Configuration

1. Get the project on you device
2. Run
```bash
composer install
```
and 
```bash
composer start
```

### Base de données

Create your own database on phpmyadmin for example
Create a file named `config/db.ini` and fill it with following informations (a template is available [`config/db.ini-template`](config/db.ini-template)) :

```ini
DB_HOST="127.0.0.1"
DB_PORT=3306
DB_NAME="dbname"
DB_CHARSET="utf8mb4"
DB_USER="user"
DB_PASSWORD="password"
```
