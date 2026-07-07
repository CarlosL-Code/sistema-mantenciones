# Sistema de Mantenciones

Sistema web de gestión de mantenciones de maquinarias.

## 1. Tecnologías utilizadas
- **Lenguaje:** PHP 8.3+
- **Framework:** Laravel 11+
- **Panel administrativo:** Filament PHP
- **Base de datos:** PostgreSQL 16+
- **Roles y permisos:** Spatie Laravel Permission
- **Exportación Excel:** Laravel Excel (Maatwebsite)
- **Generación PDF:** Dompdf
- **Entorno Local:** Docker (Laravel Sail)

## 2. Requisitos previos
- **Docker Desktop** (con WSL2 habilitado en Windows).
- (Opcional pero recomendado) Git para control de versiones.

*Nota: Debido a que el proyecto se ha configurado utilizando Laravel Sail, no es estrictamente necesario tener PHP ni Composer instalados de forma nativa en tu computadora. Todo corre dentro de Docker.*

## 3. Cómo instalar dependencias
Si clonas el proyecto por primera vez y no tienes la carpeta `vendor`, instala las dependencias usando un contenedor de Composer:

```bash
docker run --rm -v ${PWD}:/var/www/html -w /var/www/html laravelsail/php83-composer:latest composer install
```

## 4. Cómo levantar PostgreSQL (y Laravel) con Docker
Para levantar los contenedores de PostgreSQL y el servidor de Laravel, usa el siguiente comando en la raíz del proyecto:

```bash
docker compose up -d
```
*(Este comando construirá la imagen de PHP si es la primera vez y levantará la base de datos PostgreSQL).*

## 5. Cómo configurar el archivo .env
El archivo `.env` ya ha sido configurado. Las credenciales de la base de datos son:

```env
DB_CONNECTION=pgsql
DB_HOST=pgsql
DB_PORT=5432
DB_DATABASE=mantenciones_db
DB_USERNAME=postgres
DB_PASSWORD=postgres
```
*Nota: `DB_HOST` está configurado como `pgsql` en lugar de `127.0.0.1` para que Laravel pueda comunicarse correctamente con el contenedor de la base de datos dentro de la red de Docker.*

## 6. Cómo ejecutar migraciones
Para crear las tablas base en PostgreSQL, ejecuta el siguiente comando:

```bash
docker compose exec laravel.test php artisan migrate
```

## 7. Cómo iniciar el servidor Laravel
El servidor se inicia automáticamente cuando ejecutas `docker compose up -d`. 
Para ver tu aplicación, simplemente abre tu navegador y ve a:
[http://localhost](http://localhost)

Para detener el servidor y los contenedores:
```bash
docker compose down
```

## 8. Cómo acceder al panel de Filament
Una vez instalados los recursos y ejecutado el servidor, el panel de administración estará disponible en:
[http://localhost/admin](http://localhost/admin)

## 9. Credenciales del administrador inicial
- **Nombre:** Administrador
- **Email:** admin@mantenciones.local
- **Password:** password

*(Nota: Este usuario se crea a través de un seeder o comando en el proceso de instalación)*

## 10. Próximos pasos del proyecto
- [ ] Crear las migraciones y modelos para: Maquinarias, Mantenciones, Observaciones y Alertas.
- [ ] Generar los recursos de Filament (`php artisan make:filament-resource`).
- [ ] Configurar roles y permisos (Spatie).
- [ ] Implementar la lógica de alertas para próximas mantenciones.
- [ ] Integrar exportación a Excel y reportes PDF.
