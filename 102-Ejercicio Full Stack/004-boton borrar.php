<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="estilo2.css">
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
    <form action="003-procesar.php" method="POST">
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
                  <td><a href='borrar.php?id=".$row['id']."'>✖</a></td>
                </tr>";                                     // Pinta una nueva fila de tabla
            }
          ?>
        </tbody>
      </table>
    </section>
  </body>
</html>

