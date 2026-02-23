# Docker Setup for Interno Prosecretaria

## Configuración para Producción

Este proyecto está configurado para ejecutarse en Docker y ser accesible desde la IP `138.117.79.254:85`.

## Arquitectura

- **Nginx**: Servidor web en el puerto 85
- **PHP-FPM**: Procesamiento de PHP
- **MySQL**: Base de datos MySQL 8.0
- **Redis**: Cache y sesiones
- **Laravel**: Aplicación principal

## Configuración de Variables de Entorno

**IMPORTANTE**: Las variables de entorno están externalizadas en el archivo `.env.docker` por seguridad.

1. **Copiar el archivo de ejemplo:**
```bash
cp .env.docker.example .env.docker
```

2. **Editar las credenciales en `.env.docker`:**
```bash
nano .env.docker
```

3. **Actualizar las contraseñas por defecto:**
   - `DB_PASSWORD`: Contraseña para la base de datos
   - `MYSQL_PASSWORD`: Contraseña del usuario MySQL
   - `MYSQL_ROOT_PASSWORD`: Contraseña del root MySQL

## Inicio Rápido

1. **Configurar las variables de entorno:**
```bash
cp .env.docker.example .env.docker
# Editar .env.docker con tus credenciales
```

2. **Construir y levantar los contenedores:**
```bash
docker-compose up -d --build
```

3. **Verificar el estado:**
```bash
docker-compose ps
```

4. **Ver logs:**
```bash
docker-compose logs -f
```

## Acceso a la Aplicación

- **URL Principal**: http://138.117.79.254:85
- **Base de Datos**: localhost:3306 (usuario: laravel, password: el que configures en .env.docker)
- **Redis**: localhost:6379

## Comandos Útiles

### Ver logs de un servicio específico
```bash
docker-compose logs -f app
docker-compose logs -f nginx
docker-compose logs -f mysql
```

### Ejecutar comandos en el contenedor de la aplicación
```bash
docker-compose exec app bash
docker-compose exec app php artisan migrate
docker-compose exec app php artisan tinker
```

### Reiniciar servicios
```bash
docker-compose restart nginx
docker-compose restart app
```

### Detener y eliminar contenedores
```bash
docker-compose down
```

### Reconstruir imágenes
```bash
docker-compose build --no-cache
```

## Seguridad

- **Variables de entorno**: Externalizadas en `.env.docker` (no versionado)
- **Headers de seguridad**: Configurados en Nginx
- **Modo producción**: `APP_DEBUG=false`
- **Contraseñas**: Cambiar las contraseñas por defecto en `.env.docker`

## Archivos de Configuración

- `.env.docker`: Variables de entorno (NO versionar)
- `.env.docker.example`: Plantilla de variables de entorno
- `docker-compose.yml`: Orquestación de servicios
- `Dockerfile`: Configuración de la imagen PHP
- `docker/`: Configuraciones de Nginx y Supervisor

## Persistencia de Datos

- **Base de datos**: Se usa un volumen Docker para persistir datos de MySQL
- **Archivos de la app**: Los archivos locales se montan en el contenedor

## Troubleshooting

### Si la aplicación no responde:
1. Verificar que los contenedores estén corriendo: `docker-compose ps`
2. Revisar los logs: `docker-compose logs`
3. Verificar que el puerto 85 esté disponible en el servidor
4. Asegurarse que `.env.docker` exista y tenga las variables correctas

### Si hay errores de base de datos:
1. Esperar a que MySQL esté completamente iniciado
2. Revisar logs del contenedor MySQL: `docker-compose logs mysql`
3. Verificar credenciales en `.env.docker`

### Si hay problemas de permisos:
1. Ejecutar: `docker-compose exec app chown -R www-data:www-data storage bootstrap/cache`
2. Ejecutar: `docker-compose exec app chmod -R 775 storage bootstrap/cache`
