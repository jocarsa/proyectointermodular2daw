Instalar el conector de PHP->MySQL

sudo apt install php-mysqli

Creamos un tercer proyecto

Cambiamos directorio a la carpeta de publicación
cd /var/www/html

Creamos un nuevo directorio
sudo mkdir proyecto3

Entramos en el directorio
cd proyecto3

Creamos un nuevo archivo
sudo nano index.php

Introducimos este código:

<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  
  $conexion = new mysqli("localhost", "prueba", "Prueba123$", "prueba");

  $peticion = "SELECT * FROM clientes";
  $resultado = $conexion->query($peticion);
     
  while($fila = $resultado->fetch_assoc()) {
     echo $fila['nombre']." - ".$fila['email']." - ".$fila['direccion'];
  }
          
  $conexion->close();
?>
