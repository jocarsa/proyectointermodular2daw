Instalamos el servidor

sudo apt install mysql-server

Asegurar la instalación de MySQL:

sudo mysql_secure_installation

sudo mysql -u root -p

Mostramos bases de datos

SHOW DATABASES;

Quiero crear una base de datos de prueba

CREATE DATABASE prueba;

Entramos en la base de datos

USE prueba;

Creamos una tabla de clientes

CREATE TABLE clientes (
  Identificador INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(255),
  email VARCHAR(255),
  direccion VARCHAR(255)
);

Inserto un cliente

INSERT INTO clientes VALUES (
  NULL,
  'Jose Vicente',
  'info@jocarsa.com',
  'La calle de Jose Vicente'
);

Comprobamos la inserción

SELECT * FROM clientes;

Creamos un usuario con privilegios:

CREATE USER 'prueba'@'localhost' IDENTIFIED BY 'Prueba123$';

-- Grant all privileges on the database "prueba"
GRANT ALL PRIVILEGES ON prueba.* TO 'prueba'@'localhost';

-- Apply changes
FLUSH PRIVILEGES;

Salimos de MySQL

exit




