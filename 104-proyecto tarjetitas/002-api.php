<?php
// 002-api.php — CORS + guardar POST en SQLite + autocreate + respuestas claras

// CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, Accept');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Content-Type: application/json; charset=utf-8');

// Preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(204);
  exit;
}

// DEBUG (puedes quitar en prod)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verifica PDO SQLite
if (!extension_loaded('pdo_sqlite')) {
  http_response_code(500);
  echo json_encode(['ok'=>false,'error'=>'pdo_sqlite no está habilitada']);
  exit;
}

// Ruta absoluta al DB (carpeta debe ser escribible por el usuario del servidor web)
$dbPath = __DIR__ . '/tarjetitas.db';

try {
  $pdo = new PDO('sqlite:' . $dbPath, null, null, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  ]);

  // Crea tabla si no existe
  $pdo->exec("
    CREATE TABLE IF NOT EXISTS tarjetitas (
      id       INTEGER PRIMARY KEY AUTOINCREMENT,
      ts       DATETIME DEFAULT CURRENT_TIMESTAMP,
      usuario  TEXT NOT NULL,
      tarjetas TEXT NOT NULL
    );
  ");

  // Lee el cuerpo
  $raw = file_get_contents('php://input');
  if ($raw === false || $raw === '') {
    http_response_code(400);
    echo json_encode(['ok'=>false,'error'=>'Body vacío']);
    exit;
  }

  // (Opcional) valida que sea JSON
  json_decode($raw);
  if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['ok'=>false,'error'=>'Body no es JSON válido']);
    exit;
  }

  // Inserta
  $stmt = $pdo->prepare('INSERT INTO tarjetitas(usuario, tarjetas) VALUES(:usuario, :tarjetas)');
  $stmt->execute([
    ':usuario'  => 'jocarsa',
    ':tarjetas' => $raw,
  ]);

  echo json_encode(['ok'=>true,'id'=>$pdo->lastInsertId()]);
} catch (Throwable $e) {
  http_response_code(500);
  echo json_encode(['ok'=>false,'error'=>$e->getMessage()]);
}

