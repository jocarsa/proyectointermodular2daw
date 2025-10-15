<!doctype html>
<html lang="es">
  <head>
    <title>JOCARSApress</title>
    <meta charset="utf-8">
    <style>
      html,body{width:100%;padding:0px;margin:0px;font-family:sans-serif;background:steelblue;}
      header,footer,main{background:white;padding:20px;width:600px;margin:auto;}
      article{border-bottom:1px solid steelblue;padding:20px;}
      article *{padding:5px;margin:0px;}
    </style>
  </head>
  <body>
    <header>
      <h1>El blog de José Vicente</h1>
    </header>
    <main>
    <?php
      $basededatos = new SQLite3('jocarsapress.db');
      $resultado = $basededatos->query('SELECT * FROM post');
      while ($fila = $resultado->fetchArray()){
        echo '
        <article> 
          <h3>'.$fila['titulo'].'</h3>
          <time>'.$fila['fecha'].'</time>
          <p>'.$fila['autor'].'</p>
          <p>'.$fila['texto'].'</p>
        </article>
        ';
      }
      ?>
    </main>
    <footer>
    </footer>
  </body>
</html>
