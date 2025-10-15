<?php
  if(isset($_POST['titulo'])){
    $basededatos = new SQLite3('jocarsapress.db');
    $peticion = '
      INSERT INTO post VALUES (
        NULL,
        "'.$_POST['titulo'].'",
        "'.$_POST['fecha'].'",
        "'.$_POST['autor'].'",
        "'.$_POST['texto'].'"
      )
    ';
    $resultado = $basededatos->query($peticion);
  }
?>
<!doctype html>
<html lang="es">
  <head>
    <title>JOCARSApress</title>
    <meta charset="utf-8">
    <style>
      html,body{width:100%;height:100%;overflow:hidden;padding:0px;margin:0px;}
      body{display:flex;flex-direction:column;font-family:sans-serif;}
      header{flex:1;background:SteelBlue;}
      main{flex:9;display:flex;flex-direction:row;}
      nav{background:SteelBlue;flex:1;display:flex;flex-direction:column;padding:10px;gap:10px;}
      section{flex:6;padding:10px;}
      nav a{background:white;color:SteelBlue;padding:10px;border-radius:5px;text-decoration:none;}
      button{background:steelblue;color:white;padding:10px 20px;border:none;border-radius:5px;margin:5px;}
      table{width:100%;border-collapse: collapse;}
      table thead tr{background:steelblue;color:white;}
    </style>
  </head>
  <body>
    <header>
    </header>
    <main>
      <nav>
        <a href="">Entradas</a>
        <a href="">Páginas</a>
        <a href="">...</a>
      </nav>
      <section>
        <table>
          <thead>
            <tr><th>Fecha</th><th>Titulo</th><th>Autor</th><th>Acciones</th></tr>
          </thead>
          <tbody>
            <?php
              $basededatos = new SQLite3('jocarsapress.db');
              $resultado = $basededatos->query('SELECT * FROM post');
              while ($fila = $resultado->fetchArray()){
                echo '
                <tr>
                  <td>'.$fila['fecha'].'</td>
                  <td>'.$fila['titulo'].'</td>
                  <td>'.$fila['autor'].'</td>
                  <td>🖋❌</td>
                </tr>
                ';
              }
              ?> 
          </tbody>
        </table>
        <style>
          section{display:flex;gap:20px;}
          section table{flex:4;}
          section form{flex:4;display:flex;flex-direction:column;gap:10px;}
          section form input{padding:5px;border:1px solid steelblue;}
        </style>
        <form method="POST" action="?">
          <?php
              $basededatos = new SQLite3('jocarsapress.db');
              $resultado = $basededatos->query('PRAGMA table_info(post)');
              while ($fila = $resultado->fetchArray()){
                if($fila['name'] != "Identificador"){
                  echo '
                  <input type="text" name="'.$fila['name'].'" placeholder="'.$fila['name'].'">
                  ';
                }
              }
              ?>
            <input type="submit">
        </form>
      </section>
    </main>
  </body>
</html> 
