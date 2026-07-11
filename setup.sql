CREATE DATABASE IF NOT EXISTS sistema_mantenciones;
CREATE USER IF NOT EXISTS 'mantenciones_user'@'localhost' IDENTIFIED BY 'Mantenciones2026!';
GRANT ALL PRIVILEGES ON sistema_mantenciones.* TO 'mantenciones_user'@'localhost';
FLUSH PRIVILEGES;
