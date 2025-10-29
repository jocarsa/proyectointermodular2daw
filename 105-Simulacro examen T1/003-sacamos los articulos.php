<!doctype html>
<html lang="es">
  <head>
    <title>JOCARSAblog</title>
    <meta charset="utf-8">
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
  </body>
</html>
