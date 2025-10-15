<?php
  $db = new SQLite3("biblioteca.db");                     // Abrimos una base de datos
  $db->exec("DELETE FROM libros WHERE id = ".$_GET['id']);        
?>
<meta http-equiv="refresh" content="5; url=003-biblioteca.php">
