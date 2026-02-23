# Interno Prosecretaría

Sistema de gestión interna para la prosecretaría de la Honorable Cámara de Diputados. Esta aplicación Laravel permite administrar áreas, edificios, oficinas y gestionar pedidos internos entre diferentes dependencias.

## Características

- Gestión de áreas y dependencias
- Administración de edificios y oficinas
- Sistema de pedidos internos
- Panel de administración con AdminLTE
- Autenticación de usuarios
- Base de datos MySQL con Redis para caché

## Requisitos

- PHP 8.2+
- MySQL 8.0+
- Redis
- Node.js & NPM
- Composer

## Instalación y Ejecución

### Sin Docker

1. **Clonar el repositorio**
   ```bash
   git clone <repository-url>
   cd interno-prosecretaria
   ```

2. **Instalar dependencias**
   ```bash
   composer install
   npm install
   ```

3. **Configurar entorno**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configurar base de datos**
   - Editar el archivo `.env` con los datos de conexión a MySQL y Redis
   - Ejecutar las migraciones: `php artisan migrate`
   - Ejecutar los seeders: `php artisan db:seed`

5. **Compilar assets**
   ```bash
   npm run build
   ```

6. **Iniciar servidor de desarrollo**
   ```bash
   php artisan serve
   ```

   O usar el script de desarrollo:
   ```bash
   composer run dev
   ```

### Con Docker

1. **Clonar el repositorio**
   ```bash
   git clone <repository-url>
   cd interno-prosecretaria
   ```

2. **Configurar entorno**
   ```bash
   cp .env.example .env
   ```

3. **Levantar contenedores**
   ```bash
   docker compose up -d --build
   ```

4. **Ejecutar migraciones y seeders**
   ```bash
   docker compose exec app php artisan migrate
   docker compose exec app php artisan db:seed
   ```

5. **Acceder a la aplicación**
   - La aplicación estará disponible en: `http://localhost:85`
   - MySQL: `localhost:3306`
   - Redis: `localhost:6379`

## Scripts Útiles

- `composer run setup` - Instalación completa del proyecto
- `composer run dev` - Inicia servidor de desarrollo con watchers
- `composer run test` - Ejecuta tests

## Estructura del Proyecto

- `app/Models/` - Modelos de datos (Area, Edificio, Oficina, Pedido)
- `app/Http/Controllers/` - Controladores de la aplicación
- `database/migrations/` - Migraciones de base de datos
- `database/seeders/` - Datos iniciales
- `resources/views/` - Vistas Blade
- `docker/` - Configuración de Docker

## Licencia

Este proyecto es software de código abierto licenciado bajo la licencia MIT.
