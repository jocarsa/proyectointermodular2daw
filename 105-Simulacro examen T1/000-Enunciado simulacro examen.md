🧩 Ejercicio final de unidad: Mini-Gestor de Contenidos “JOCARSAnews”
🎯 Objetivo

Desarrollar una aplicación web completa que combine frontend, backend y base de datos usando los conocimientos adquiridos durante la unidad.

El sistema permitirá:

Crear, listar y eliminar artículos de noticias.

Almacenar la información en una base de datos SQLite o MySQL.

Mostrar los artículos públicamente en una página de portada (front).

Gestionarlos desde un panel de administración (back).

⚙️ Requisitos técnicos
1. Preparación del entorno

Servidor Apache y PHP correctamente instalados y activos.

Base de datos creada (jocarsanews.db o jocarsanews si usas MySQL).

Carpeta del proyecto en /var/www/html/jocarsanews/.

2. Base de datos

Crea una tabla para los artículos:

CREATE TABLE IF NOT EXISTS articulos (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  titulo TEXT,
  autor TEXT,
  fecha TEXT,
  contenido TEXT
);

3. Backend (back.php)

Muestra una tabla con todos los artículos almacenados.

Añade un formulario con los campos: título, autor, fecha y contenido.

Al enviar el formulario, inserta el artículo en la base de datos.

Cada fila de la tabla incluirá un botón ❌ para borrar el artículo correspondiente.

Aplica estilos CSS sencillos (por ejemplo, con fondo SteelBlue y tablas blancas).

4. Frontend (front.php)

Muestra todos los artículos de la base de datos con un diseño limpio:

<article>
  <h2>Título</h2>
  <time>Fecha</time>
  <p><strong>Autor:</strong> ...</p>
  <p>Contenido...</p>
</article>


Aplica CSS similar al de JOCARSApress.

5. API opcional (api.php)

Crea una pequeña API que devuelva todos los artículos en formato JSON:

<?php
  header('Content-Type: application/json; charset=utf-8');
  $db = new SQLite3('jocarsanews.db');
  $res = $db->query('SELECT * FROM articulos');
  $articulos = [];
  while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
    $articulos[] = $row;
  }
  echo json_encode($articulos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>


Esto permitirá conectar tu web con JavaScript o con otras aplicaciones (por ejemplo, tarjetitas).

🧠 Pistas para ampliación (opcional)

Añade validación de formularios (campos obligatorios).

Implementa edición de artículos.

Guarda automáticamente la fecha actual si el campo está vacío.

Añade un sistema básico de usuarios (login “cutre” con $_SESSION).

Crea una versión que use Fetch + API REST en lugar de formularios clásicos.

📤 Entrega

Sube al servidor los archivos:

/var/www/html/jocarsanews/
  ├── back.php
  ├── front.php
  ├── api.php
  ├── estilo.css
  └── jocarsanews.db


Y verifica que puedes:

Insertar artículos desde el panel.

Verlos listados en la portada.

Consultarlos mediante http://localhost/jocarsanews/api.php.
