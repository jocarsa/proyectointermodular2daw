<?php
  $db = new SQLite3('blog.db');
    $resultado = $db->query("
      UPDATE articulos
      SET ".$_GET['columna']." = '".$_GET['contenido']."'
      WHERE id = ".$_GET['identificador']."
      ");
    $db->close();
?>
