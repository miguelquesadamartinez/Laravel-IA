# Laravel IA

Proyecto Laravel con gestión completa de usuarios (CRUD) y autenticación, más entorno Docker con MySQL y phpMyAdmin.

## ¿Qué incluye?

- Laravel 12 con autenticación (Laravel Breeze).
- Gestión de usuarios con vistas, controlador y rutas.
- Docker Compose con:
    - PHP 8.3 + Apache.
    - MySQL 8.0.
    - phpMyAdmin.
- Configuración de base de datos en .env y .env.example.

## Requisitos

- Docker y Docker Compose.
- (Opcional, local sin Docker) PHP 8.3+, Composer y Node.js.

## Inicio rápido con Docker

1. Levanta los contenedores:

- docker compose up -d --build

2. Instala dependencias y ejecuta migraciones dentro del contenedor:

- docker compose exec app composer install
- docker compose exec app php artisan key:generate
- docker compose exec app php artisan migrate

3. Accede:

- Aplicación: http://localhost:8092
- phpMyAdmin: http://localhost:8093

Credenciales de MySQL:

- Host: mysql
- Usuario: laravel
- Contraseña: secret
- Base de datos: laravel
- Puerto en host: 3307

## Inicio rápido sin Docker (opcional)

1. Instala dependencias:

- composer install
- npm install

2. Genera la clave y migra:

- php artisan key:generate
- php artisan migrate

3. Compila assets:

- npm run build

4. Levanta el servidor:

- php artisan serve

## Gestión de usuarios

Ruta principal: /users

Funciones:

- Listar usuarios
- Crear usuario
- Editar usuario
- Eliminar usuario

Solo usuarios autenticados pueden acceder.

## Búsqueda en ChatGPT

Nuevo menú: ChatGPT

Ruta principal: /chatgpt

Configura en tu .env:

- OPENAI_API_KEY
- OPENAI_MODEL (opcional, por defecto gpt-4o-mini)

## Estructura relevante

- Controlador: app/Http/Controllers/UserController.php
- Vistas: resources/views/users
- Rutas: routes/web.php
- Docker: Dockerfile y docker-compose.yml

## Instalar Laravel AI SDK

Instalación con Composer:

- composer require laravel/ai

Si trabajas con Docker:

- docker compose exec app composer require laravel/ai

Después, configura las claves del proveedor de IA en tu .env según el proveedor que vayas a usar.

Publicar configuración (opcional):

- php artisan vendor:publish --tag=laravel-ai

## Notas

Si cambias credenciales de base de datos, actualiza .env y reinicia los contenedores.
