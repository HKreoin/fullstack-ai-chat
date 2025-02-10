# AI чат с поддержкой голосового набора


### Установка и запуск
Скопируйте и переименуйте файл backend/.env.example в backend/.env

В файл .env добавьте AI_TOKEN (Open AI)

Выполните команду чтобы запустить приложение
```
cd fullstack-ai-chat
docker compose up --build
```

Затем выполните команды (только 1 раз)
```
docker compose exec backend php artisan key:generate
```

Приложение доступно по адресу localhost