<?php
  /*
      id PK
      titulo
      isbn
      autor
      editorial FK
      categoria FK
      num_paginas
   */
  $titulo = $_POST['titulo'];
  $isbn = $_POST['isbn'];
  $autor = $_POST['autor'];
  $editorial = $_POST['editorial'];
  $categoria = $_POST['categoria'];
  $num_paginas = $_POST['num_paginas'];
?>
<?php
  $db = new SQLite3("biblioteca.db");                     // Abrimos una base de datos
  $db->exec("CREATE TABLE IF NOT EXISTS libros(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    titulo TEXT, isbn TEXT, autor TEXT,
    editorial TEXT, categoria TEXT, num_paginas INTEGER
  )");                                                    // Si no existe la tabla libros, la creamos
  $db->exec("INSERT INTO libros(titulo,isbn,autor,editorial,categoria,num_paginas)
  VALUES ('$_POST[titulo]','$_POST[isbn]','$_POST[autor]','$_POST[editorial]','$_POST[categoria]',$_POST[num_paginas])");                                   // Insertamos un libro
  echo "✅ Libro insertado";                             // Hacemos un echo
?>
<meta http-equiv="refresh" content="5; url=003-biblioteca.php">






