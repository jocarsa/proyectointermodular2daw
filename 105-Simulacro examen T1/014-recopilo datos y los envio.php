<?php
  if(isset($_POST['titulo'])){
    $db = new SQLite3('blog.db');
    $resultado = $db->query("
      INSERT INTO articulos 
      VALUES (
        NULL,
        '".$_POST['titulo']."',
        '".$_POST['autor']."',
        '".$_POST['fecha']."',
        '".$_POST['contenido']."'
       )");
    $db->close();
  }
  if(isset($_GET['operacion']) && $_GET['operacion'] == "eliminar"){
    $db = new SQLite3('blog.db');
    $resultado = $db->query("DELETE FROM articulos WHERE id = ".$_GET['id']."");
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
        <th>Titulo</th><th>Autor</th><th>Fecha</th><th>Contenido</th><th>El</th>
      </thead>
      <tbody>
        <?php
          $db = new SQLite3('blog.db');
          $resultado = $db->query("SELECT * FROM articulos");
          while ($fila = $resultado->fetchArray(SQLITE3_ASSOC)) {
              echo "<tr>
                  <td identificador='".$fila['id']."' columna='titulo'>".$fila['titulo']."</td>
                  <td identificador='".$fila['id']."' columna='autor'>".$fila['autor']."</td>
                  <td identificador='".$fila['id']."' columna='fecha'>".$fila['fecha']."</td>
                  <td identificador='".$fila['id']."' columna='contenido'>".$fila['contenido']."</td>
                  <td><a href='?operacion=eliminar&id=".$fila['id']."'>❌</a></td>
                </tr>";
          }
          $db->close();
          ?>
      </tbody>
    </table>
    <form action="?" method="POST">
      <input type="hidden" value="tuformulario">
      <label>Introduce un nuevo título</label>
      <input type="text" name="titulo">
      <label>Introduce un nuevo autor</label>
      <input type="text" name="autor">
      <label>Introduce una nueva fecha</label>
      <input type="text" name="fecha">
      <label>Introduce un nuevo contenido</label>
      <input type="text" name="contenido">
      <input type="submit">
      <script>
        let celdas = document.querySelectorAll("td")
        celdas.forEach(function(celda){
          celda.ondblclick = function(){
            this.setAttribute("contenteditable",true)
          }
          celda.onblur = function(){
            this.setAttribute("contenteditable",false)
            // Avanzado: Cuando salgo de la celda, envío a la base de datos el nuevo dato
            let contenido = this.textContent
            let columna = this.getAttribute("columna")
            let identificador = this.getAttribute("identificador")
            fetch("actualiza.php?identificador="+identificador+"&columna="+columna+"&contenido="+encodeURI(contenido))
          }
        })
      </script>
    </form>
  </body>
</html>
