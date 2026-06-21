# Eventum

**[English](README.md)**

Платформа для публикации статей о мероприятиях. Позволяет организаторам вести каталог событий и привязывать к ним материалы, а читателям — знакомиться с публикациями без регистрации.

## Возможности

- Просмотр статей на публичной странице — без авторизации
- Детальная страница каждой статьи с привязкой к мероприятию
- Регистрация и вход для пользователей
- Панель администратора для полного управления мероприятиями и статьями
- Пагинация списков
- Валидация форм с отображением ошибок

## Стек

| Слой | Технология |
|------|-----------|
| Backend | PHP 8.0+, Laravel 9 |
| База данных | MySQL |
| Frontend | Bootstrap 5, Blade |
| Аутентификация | Laravel UI + Session |

## Требования

- PHP >= 8.0
- Composer
- MySQL >= 5.7
- Node.js >= 16 + npm

## Установка

```bash
git clone <repository-url>
cd eventum

composer install
npm install && npm run dev

cp .env.example .env
php artisan key:generate
```

Настройте `.env`:

```dotenv
DB_DATABASE=eventum
DB_USERNAME=root
DB_PASSWORD=
```

Запустите миграции:

```bash
php artisan migrate --seed
```

## Запуск

```bash
php artisan serve
```

Приложение доступно на `http://localhost:8000`.

## Демо-данные

После `migrate --seed` в базе появляется:

| Роль | Email | Пароль |
|------|-------|--------|
| Администратор | `admin@example.com` | `password` |

Также создаются 5 мероприятий и 15 статей для наполнения.

## Тесты

```bash
php artisan test
```

Покрытие включает: публичные страницы, CRUD панели администратора, контроль доступа, аутентификацию, модели.

## Структура

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── EventsController.php    # Публичные страницы (список, детали)
│   │   └── HomeController.php      # Панель администратора (CRUD)
│   └── Middleware/
│       └── EnsureUserIsAdmin.php   # Проверка прав администратора
└── Models/
    ├── Event.php                   # Мероприятие → hasMany Article
    ├── Article.php                 # Статья → belongsTo Event
    └── User.php

database/
├── factories/          # EventFactory, ArticleFactory, UserFactory
├── migrations/
└── seeders/

tests/
├── Feature/
│   ├── ExampleTest.php         # Публичные страницы
│   ├── HomeControllerTest.php  # Панель администратора
│   └── AuthTest.php            # Аутентификация
└── Unit/
    └── ExampleTest.php         # Модели
```

## Лицензия

MIT
