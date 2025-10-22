<?php
  if(isset($_GET['operacion']) && $_GET['operacion'] == "insertar"){     // Solo ejecuto este código si la operacion es insertar
    $titulo = $_POST['titulo'];
    $isbn = $_POST['isbn'];
    $autor = $_POST['autor'];
    $editorial = $_POST['editorial'];
    $categoria = $_POST['categoria'];
    $num_paginas = $_POST['num_paginas'];
    $db = new SQLite3("biblioteca.db");                     // Abrimos una base de datos
    $db->exec("CREATE TABLE IF NOT EXISTS libros(
      id INTEGER PRIMARY KEY AUTOINCREMENT,
      titulo TEXT, isbn TEXT, autor TEXT,
      editorial TEXT, categoria TEXT, num_paginas INTEGER
    )");                                                    // Si no existe la tabla libros, la creamos
    $db->exec("INSERT INTO libros(titulo,isbn,autor,editorial,categoria,num_paginas)
    VALUES ('$_POST[titulo]','$_POST[isbn]','$_POST[autor]','$_POST[editorial]','$_POST[categoria]',$_POST[num_paginas])");                                   // Insertamos un libro
   
  }
?>
<?php
  if(isset($_GET['operacion']) && $_GET['operacion'] == "borrar"){       // Solo ejecuto este codigo si la operacion es borrar
    $db = new SQLite3("biblioteca.db");                     // Abrimos una base de datos
    $db->exec("DELETE FROM libros WHERE id = ".$_GET['id']);     
  }   
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <style>
      body{
        background:LightSkyBlue;
        font-family:sans-serif;
        display:flex;     /* NUEVO */
      }
      form,table{         /* NUEVO */
        background:white;
        margin:auto;
        padding:20px;
                          /* He quitado del width */
        display:flex;
        flex-direction:column;
        gap:2px;
      }
      input{
        padding:5px;
        border:1px solid LightSkyBlue;
      }
      input[type="submit"]{
        background:LightSkyBlue;
        color:white;
        border:none;
      }
    </style>
  </head>
  <body>
    <!--
      id PK
      titulo
      isbn
      autor
      editorial FK
      categoria FK
      num_paginas
    -->
    <!-- CREATE -->
    <form action="?operacion=insertar" method="POST"> <!-- El action es yo mismo con la operación de insertar -->
      <label for="titulo">Titulo</label>
      <input type="text" name="titulo" id="titulo">
      <label for="isbn">ISBN</label>
      <input type="text" name="isbn" id="isbn">
      <label for="autor">Autor</label>
      <input type="text" name="autor" id="autor">
      <label for="editorial">Editorial</label>
      <input type="text" name="editorial" id="editorial">
      <label for="categoria">Categoria</label>
      <input type="text" name="categoria" id="categoria">
      <label for="num_paginas">Número de páginas</label>
      <input type="text" name="num_paginas" id="num_paginas">
      <input type="submit">
    </form>
    <section>
      <table>
        <thead>
          <tr>
            <th>Titulo</th>
            <th>ISBN</th>
            <th>Autor</th>
            <th>Editorial</th>
            <th>Categoria</th>
            <th>Número de páginas</th>
            <th>Borrar</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $db = new SQLite3("biblioteca.db");             // Conectate a la base de datos
            $result = $db->query("SELECT * FROM libros");   // Dame un listado de todos los libros

            while ($row = $result->fetchArray(SQLITE3_ASSOC)) { // Y para cada uno de los resultados
                echo "<tr>
                  <td>".$row['titulo']."</td>
                  <td>".$row['isbn']."</td>
                  <td>".$row['autor']."</td>
                  <td>".$row['editorial']."</td>
                  <td>".$row['categoria']."</td>
                  <td>".$row['num_paginas']."</td>
                  <td><a href='?id=".$row['id']."&operacion=borrar'>✖</a></td>
                </tr>";                                     // Pinta una nueva fila de tabla
                // El hipervinculo es yo mismo ? con la operacion de borrar
            }
          ?>
        </tbody>
      </table>
    </section>
  </body>
</html>

