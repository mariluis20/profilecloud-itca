# ProfileCloud ITCA

Sistema web de perfiles profesionales y proyectos de estudiantes, desplegado sobre un servidor web Linux.

**Autor:** Mario Luis Medina Arias · Carné 100720 · Grupo IDS421
**Módulo:** Gestión de Servidores Web · ITCA-FEPADE · 2026

## Funcionalidades

- Página de inicio con estadísticas y perfiles destacados.
- Directorio público de perfiles con búsqueda y filtros (carrera, sede, disponibilidad).
- Perfil público por estudiante: biografía, habilidades con nivel, proyectos y enlaces.
- Registro e inicio de sesión con roles **administrador** y **estudiante**.
- Panel del estudiante: edición de perfil, foto, habilidades y CRUD de proyectos.
- Panel del administrador: estadísticas, gestión de usuarios (activar/desactivar, cambiar rol) y bitácora de actividad.

## Seguridad implementada

- Límite de 5 intentos de inicio de sesión por minuto.
- Contraseñas con mínimo 8 caracteres, mayúsculas, minúsculas y números (almacenadas con hash bcrypt).
- Protección CSRF en todos los formularios.
- Control de acceso por rol mediante middleware.
- Validación de archivos subidos (solo imágenes, máximo 2 MB).
- Bitácora de accesos, accesos fallidos y cambios administrativos.
- Usuario de base de datos con privilegios solo sobre su propia base.

## Pila tecnológica

| Componente | Versión |
|---|---|
| Sistema operativo | Debian 13 «Trixie» |
| Servidor web | Apache 2.4 |
| PHP | 8.4 con PHP-FPM |
| Framework | Laravel 13 |
| Base de datos | MariaDB 11.8 |
| Interfaz | Blade, Bootstrap 5.3 |

## Instalación

Requisitos: servidor con Apache, PHP 8.4 (extensiones mysql, mbstring, xml, curl, zip, gd, intl, bcmath), Composer y MariaDB.

```bash
# 1. Copiar el proyecto
sudo mkdir -p /var/www/profilecloud
sudo chown $USER:www-data /var/www/profilecloud
unzip ProfileCloud_MarioMedina.zip -d /var/www/
cd /var/www/profilecloud

# 2. Dependencias y entorno
composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate

# 3. Editar .env con los datos de la base de datos
#    DB_CONNECTION=mariadb
#    DB_DATABASE=profilecloud
#    DB_USERNAME=profilecloud_user
#    DB_PASSWORD=********

# 4. Base de datos (opción A: datos de prueba)
php artisan migrate --seed

#    (opción B: restaurar el respaldo incluido)
#    mariadb -u profilecloud_user -p profilecloud < database/profilecloud.sql

# 5. Archivos públicos y permisos
php artisan storage:link
sudo chown -R $USER:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

VirtualHost de Apache (`/etc/apache2/sites-available/profilecloud.conf`):

```apache
<VirtualHost *:80>
    ServerName profilecloud.local
    DocumentRoot /var/www/profilecloud/public

    <Directory /var/www/profilecloud/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    <FilesMatch \.php$>
        SetHandler "proxy:unix:/run/php/php8.4-fpm.sock|fcgi://localhost"
    </FilesMatch>
</VirtualHost>
```

```bash
sudo a2enmod rewrite proxy_fcgi setenvif
sudo a2ensite profilecloud.conf
sudo systemctl reload apache2
```

## Usuarios de prueba

| Rol | Correo | Contraseña |
|---|---|---|
| Administrador | admin@profilecloud.local | Admin.Profile2026 |
| Estudiante | andrea.hernandez@profilecloud.local | Estudiante2026 |

Los demás estudiantes de prueba usan la contraseña `Estudiante2026`.
