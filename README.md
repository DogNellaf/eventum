# Eventum

> 🇬🇧 English | [🇷🇺 Русский](README.ru.md)

A platform for publishing articles about events. Organizers can maintain a catalogue of events and attach articles to them; readers can browse publications without signing up.

## Features

- Public article feed — no login required
- Article detail page with linked event info
- User registration and authentication
- Admin panel for full CRUD management of events and articles
- Paginated lists
- Server-side form validation with inline error messages

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | PHP 8.0+, Laravel 9 |
| Database | MySQL |
| Frontend | Bootstrap 5, Blade |
| Auth | Laravel UI + Session |

## Requirements

- PHP >= 8.0
- Composer
- MySQL >= 5.7
- Node.js >= 16 + npm

## Installation

```bash
# Clone the repository
git clone <repository-url>
cd eventum

# Install dependencies
composer install
npm install && npm run dev

# Set up the environment file
cp .env.example .env
php artisan key:generate

# Configure your database in .env (see Environment Variables below),
# then run migrations and seed demo data
php artisan migrate --seed

# Run the development server
php artisan serve
```

The application will be available at `http://localhost:8000`.

## Environment Variables

Set these in `.env` before running migrations:

| Variable | Description | Default |
|---|---|---|
| `DB_DATABASE` | Database name | `eventum` |
| `DB_USERNAME` | Database username | `root` |
| `DB_PASSWORD` | Database password | _(empty)_ |

## Demo Credentials

After `migrate --seed` the following account is available:

| Role | Email | Password |
|---|---|---|
| Admin | `admin@example.com` | `password` |

The seeder also creates 5 events and 15 articles.

## Running Tests

```bash
php artisan test
```

Coverage includes: public pages, admin CRUD, access control, authentication, and models.

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── EventsController.php    # Public pages (list, detail)
│   │   └── HomeController.php      # Admin panel (CRUD)
│   └── Middleware/
│       └── EnsureUserIsAdmin.php   # Admin access guard
└── Models/
    ├── Event.php                   # Event → hasMany Article
    ├── Article.php                 # Article → belongsTo Event
    └── User.php

database/
├── factories/          # EventFactory, ArticleFactory, UserFactory
├── migrations/
└── seeders/

tests/
├── Feature/
│   ├── ExampleTest.php         # Public pages
│   ├── HomeControllerTest.php  # Admin panel
│   └── AuthTest.php            # Authentication
└── Unit/
    └── ExampleTest.php         # Models
```

## License

[MIT](LICENSE)
