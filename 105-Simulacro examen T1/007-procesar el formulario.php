<?php
  if(isset($_POST['titulo'])){
    $db = new SQLite3('blog.db');
    $resultado = $db->query("INSERT INTO articulos VALUES (NULL,'".$_POST['titulo']."','".$_POST['autor']."','".$_POST['fecha']."','".$_POST['contenido']."')");
    $db->close();
  }
 ?>
<!doctype html>
<html lang="es">
  <head>
    <title>JOCARSAblog</title>
    <meta charset="utf-8">
    <style>
      body{display:flex;align-items:center;justify-content:center;gap:50px;padding:40px;background:aliceblue;font-family:sans-serif;font-size:10px;}
      table{padding:20px;background:white;border-radius:10px;box-shadow:0px 10px 20px rgba(0,0,0,0.3);flex:4;}
      form{flex:1;display:flex;flex-direction:column;gap:10px;padding:20px;background:white;border-radius:10px;box-shadow:0px 10px 20px rgba(0,0,0,0.3); }
    </style>
  </head>
  <body>
    <table>
      <thead>
        <th>Titulo</th><th>Autor</th><th>Fecha</th><th>Contenido</th>
      </thead>
      <tbody>
        <?php
          $db = new SQLite3('blog.db');
          $resultado = $db->query("SELECT * FROM articulos");
          while ($fila = $resultado->fetchArray(SQLITE3_ASSOC)) {
              echo "<tr>
                  <td>".$fila['titulo']."</td>
                  <td>".$fila['autor']."</td>
                  <td>".$fila['fecha']."</td>
                  <td>".$fila['contenido']."</td>
                </tr>";
          }
          $db->close();
          ?>
      </tbody>
    </table>
    <form action="?" method="POST">
      <label>Introduce un nuevo título</label>
      <input type="text" name="titulo">
      <label>Introduce un nuevo autor</label>
      <input type="text" name="autor">
      <label>Introduce una nueva fecha</label>
      <input type="text" name="fecha">
      <label>Introduce un nuevo contenido</label>
      <input type="text" name="contenido">
      <input type="submit">
    </form>
  </body>
</html>
