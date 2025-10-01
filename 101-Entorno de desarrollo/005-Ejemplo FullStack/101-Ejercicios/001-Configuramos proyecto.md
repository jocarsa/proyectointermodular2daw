cd /var/www/html

sudo mkdir proyecto4

cd proyecto4

sudo nano index.html

<!doctype html>
<html>
  <head>
  </head>
  <body>
    <div id="contenedor"></div>
    <script>
      fetch("api.php")
      .then(function(respuesta){ return respuesta.json()})
      .then(function(datos){
      console.log(datos)
        document.querySelector("#contenedor").textContent = datos[0].cliente.nombre
      })
    </script>
  </body>
</html>

sudo nano api.php

<?php
  header('Content-Type: application/json; charset=utf-8');

  $conexion = new mysqli("localhost", "prueba", "Prueba123$", "prueba");

  $peticion = "SELECT * FROM clientes";
  $resultado = $conexion->query($peticion);
  $clientes = [];

  while($fila = $resultado->fetch_assoc()) {
      $clientes[] = [
          "cliente" => [
              "nombre"    => $fila['nombre'],
              "email"     => $fila['email'],
              "direccion" => $fila['direccion']
          ]
      ];
  }
  echo json_encode($clientes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

  $conexion->close();
?>
