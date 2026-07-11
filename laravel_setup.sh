#!/bin/bash
cd /var/www/sistema-mantenciones
cp .env.example .env

# Configure .env for production
sed -i 's/APP_ENV=local/APP_ENV=production/' .env
sed -i 's/APP_DEBUG=true/APP_DEBUG=false/' .env
sed -i 's/APP_URL=http:\/\/localhost/APP_URL=http:\/\/179.197.69.129/' .env
sed -i 's/DB_DATABASE=laravel/DB_DATABASE=sistema_mantenciones/' .env
sed -i 's/DB_USERNAME=root/DB_USERNAME=mantenciones_user/' .env
sed -i 's/DB_PASSWORD=/DB_PASSWORD=Mantenciones2026!/' .env

# Install dependencies
export COMPOSER_ALLOW_SUPERUSER=1
composer install --optimize-autoloader --no-dev

# Generate key
php artisan key:generate --force

# Storage link
php artisan storage:link

# Migrate and seed
php artisan migrate --force
php artisan db:seed --force

# Build frontend assets
npm install
npm run build

# Fix permissions
chown -R www-data:www-data /var/www/sistema-mantenciones
find /var/www/sistema-mantenciones -type f -exec chmod 644 {} \;
find /var/www/sistema-mantenciones -type d -exec chmod 755 {} \;
chmod -R 775 /var/www/sistema-mantenciones/storage
chmod -R 775 /var/www/sistema-mantenciones/bootstrap/cache

echo "Laravel setup completed."
