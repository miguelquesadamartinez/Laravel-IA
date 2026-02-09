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
- (Opcional, local sin Docker) PHP 8.4+, Composer y Node.js.

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

## Multi Búsqueda 🚀

Esta es la funcionalidad estrella del proyecto. Permite realizar una única consulta que se envía **simultáneamente** a múltiples inteligencias artificiales configuradas para contrastar información.

### Características:

1.  **Consulta Unificada**: Escribe tu pregunta una sola vez.
2.  **Ejecución Paralela**: El sistema consulta a todos los proveedores disponibles (OpenAI, Anthropic, Gemini, Groq, etc.) al mismo tiempo.
3.  **Análisis Interligente**:
    - Si las IAs responden correctamente, se recopilan todas las respuestas.
    - **Gemini** actúa como "Juez/Analista": Recibe todas las respuestas y genera una **conclusión final verificada**.
    - Detecta automáticamente **contradicciones factuales** entre las diferentes IAs.
    - El análisis se centra en la veracidad y consistencia de los datos, no en el estilo.
4.  **Gestión de Errores**: Si una IA no está configurada o falla, el sistema lo notifica pero muestra los resultados de las que sí funcionaron.

### Ruta:

- `/multi-search`

## Búsqueda Individual IA

Nuevo menú: IA

Rutas principales:

- /ai/openai
- /ai/anthropic
- /ai/gemini
- /ai/groq
- /ai/xai
- /ai/deepseek
- /ai/mistral
- /ai/ollama

Configura en tu .env las llaves del proveedor que vayas a usar:

- OPENAI_API_KEY
- ANTHROPIC_API_KEY
- GEMINI_API_KEY
- GROQ_API_KEY
- XAI_API_KEY
- DEEPSEEK_API_KEY
- MISTRAL_API_KEY
- OLLAMA_API_KEY (opcional)
- OLLAMA_BASE_URL (opcional)

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

Publicar configuración y migraciones:

- php artisan vendor:publish --provider="Laravel\\Ai\\AiServiceProvider"
- php artisan migrate

## Notas

Si cambias credenciales de base de datos, actualiza .env y reinicia los contenedores.
