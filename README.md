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

Create your own database on phpmyadmin for example. The SQL script is in **BdeChallenge/bdechallenge.sql**
Create a file named `config/db.ini` and fill it with following informations (a template is available [`config/db.ini-template`](config/db.ini-template)) :

```ini
DB_HOST="127.0.0.1"
DB_PORT=3306
DB_NAME="dbname"
DB_CHARSET="utf8mb4"
DB_USER="user"
DB_PASSWORD="password"
```

### Codespace

- Routes, pdo set up are in **public/index.php**
- Controllers are in **src/Controller/...Controller.php**
- Objects are in **src/Model/Entity.php**
- Views are in **src/View/Topic/view.php**