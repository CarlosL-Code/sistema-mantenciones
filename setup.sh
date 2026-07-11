#!/bin/bash
export DEBIAN_FRONTEND=noninteractive

echo "Actualizando paquetes..."
apt-get update
apt-get upgrade -y

echo "Instalando Nginx, MySQL, Git, Curl, Unzip..."
apt-get install -y nginx mysql-server git curl unzip software-properties-common

echo "Instalando PHP 8.3 y extensiones..."
apt-get install -y php8.3-fpm php8.3-mysql php8.3-mbstring php8.3-xml php8.3-bcmath php8.3-curl php8.3-zip php8.3-intl php8.3-gd

echo "Instalando Composer..."
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

echo "Instalando Node.js (v20)..."
curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
apt-get install -y nodejs

echo "Configuracion base completada."
