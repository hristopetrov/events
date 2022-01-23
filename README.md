## Requirements

- PHP 8.0
- MySQL 8.0
- Composer 2.0

## Installation

```bash
composer install
cp .env.example .env
```
Create a database and run migrations
```bash
php artisan migrate
```

- All routes for managing rooms and events are behind authentication.
- For auth purposes you can use two approaches - session cookie or token.
- There is a postman collection in the `/storage/postman` directory.
- By default, the postman collection variables are set with domain `http://events.test`




