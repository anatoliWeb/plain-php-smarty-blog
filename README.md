# Plain PHP Smarty Blog

Simple blog application for a PHP backend developer test task.

The project is built without a framework. It uses plain PHP, MySQL, PDO and Smarty templates.

## Tech stack

- PHP 8.1+
- MySQL 8
- PDO
- Smarty
- SCSS
- Nginx
- Docker / Docker Compose

## Features

- Categories
- Articles
- Article can belong to one or more categories
- Home page with categories and latest articles
- Category page with article list, sorting and pagination
- Article page with full content and related articles
- SQL schema and seed data

## Project structure

```text
.
|-- app/
|   |-- Controllers/
|   |-- Core/
|   `-- Models/
|-- config/
|-- database/
|   |-- schema.sql
|   `-- seed.sql
|-- docker/
|   |-- nginx/
|   `-- php/
|-- public/
|   |-- index.php
|   `-- assets/
|       `-- css/
|-- resources/
|   `-- scss/
|-- templates/
|-- var/
|-- composer.json
|-- docker-compose.yml
`-- TODO.md
```

## Setup

Clone the repository:

```bash
git clone https://github.com/anatoliWeb/plain-php-smarty-blog.git
cd plain-php-smarty-blog
```

Build and start containers:

Create `.env` before running Docker Compose (recommended because Docker Compose reads `.env` before containers start):

Linux/macOS:
```bash
cp .env.example .env
```

Windows PowerShell:
```powershell
Copy-Item .env.example .env
```

Then build and start containers:

```bash
docker compose up -d --build
```

Open the application:

```text
http://localhost:8081
```
The PHP container entrypoint can still create `.env` automatically if it is missing, and it also runs Composer install if `vendor` is missing.

## Database

Database is created automatically by the MySQL container.

Schema and seed files are loaded from:

```text
database/schema.sql
database/seed.sql
```

To recreate the database from scratch:

```bash
docker compose down -v
docker compose up -d --build
```

## Local services

| Service | URL / Port |
|---|---|
| Application | http://localhost:8081 |
| MySQL inside Docker | mysql:3306 |
| MySQL from host | localhost:3308 |

Default database credentials are stored in `.env.example`.

## Styles

SCSS source files are stored in:

```text
resources/scss/
```

The main SCSS file is:

```text
resources/scss/app.scss
```

Compiled CSS is stored in:

```text
public/assets/css/app.css
```

The compiled CSS file is committed to the repository, so Node.js or npm is not required to run the project.

If SCSS files are changed, CSS can be rebuilt with:

```bash
npx --yes sass resources/scss/app.scss public/assets/css/app.css --no-source-map
```

For development, watch mode can be used:

```bash
npx --yes sass --watch resources/scss/app.scss:public/assets/css/app.css --no-source-map
```

## Notes

The project intentionally keeps the architecture simple.

There is no framework, ORM or dependency injection container. SQL queries are written manually and executed through PDO.

Composer is used only to install Smarty and configure class autoloading.

The implementation plan is described in `TODO.md`.
