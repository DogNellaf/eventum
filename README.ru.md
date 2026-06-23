# Eventum

> [🇬🇧 English](README.md) | 🇷🇺 Русский

Платформа для публикации статей о мероприятиях. Позволяет организаторам вести каталог событий и привязывать к ним материалы, а читателям — знакомиться с публикациями без регистрации.

## Возможности

- Публичная лента статей — без авторизации
- Детальная страница статьи с привязкой к мероприятию
- Регистрация и вход для пользователей
- Панель администратора для полного CRUD-управления мероприятиями и статьями
- Пагинация списков
- Серверная валидация форм с отображением ошибок

## Стек технологий

| Слой | Технология |
|---|---|
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
# Клонируйте репозиторий
git clone <repository-url>
cd eventum

# Установите зависимости
composer install
npm install && npm run dev

# Настройте файл окружения
cp .env.example .env
php artisan key:generate

# Настройте базу данных в .env (см. раздел «Переменные окружения» ниже),
# затем выполните миграции и заполните БД демо-данными
php artisan migrate --seed

# Запустите сервер для разработки
php artisan serve
```

Приложение будет доступно по адресу `http://localhost:8000`.

## Переменные окружения

Укажите их в `.env` перед запуском миграций:

| Переменная | Описание | По умолчанию |
|---|---|---|
| `DB_DATABASE` | Имя базы данных | `eventum` |
| `DB_USERNAME` | Пользователь БД | `root` |
| `DB_PASSWORD` | Пароль БД | _(пусто)_ |

## Демо-данные

После `migrate --seed` в базе появляется следующая учётная запись:

| Роль | Email | Пароль |
|---|---|---|
| Администратор | `admin@example.com` | `password` |

Также создаются 5 мероприятий и 15 статей для наполнения.

## Запуск тестов

```bash
php artisan test
```

Покрытие включает: публичные страницы, CRUD панели администратора, контроль доступа, аутентификацию, модели.

## Структура проекта

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

[MIT](LICENSE)
