# AI чат с поддержкой голосового набора


### Установка и запуск
Скопируйте и переименуйте файл backend/.env.example в backend/.env

В файл .env добавьте AI_TOKEN (Open AI)

Выполните команду чтобы запустить приложение
```
docker compose up --build
```

Затем выполните команды (только 1 раз)
```
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate
```

Приложение доступно по адресу localhost