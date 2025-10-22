<?php
// 004-api.php — carga/guarda tarjetas por usuario usando la tabla:
// CREATE TABLE "tarjetitas" (
//   "Identificador" INTEGER PRIMARY KEY AUTOINCREMENT,
//   "usuario"       TEXT,
//   "tarjetas"      TEXT
// );

// POST JSON:
//  - Cargar últimas tarjetas de un usuario: { "usuario":"pepe", "accion":"load" }
//  - Guardar (nueva versión):               { "usuario":"pepe", "accion":"save", "tarjetas":[ ... ] }

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, Accept');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); echo json_encode(['ok'=>false,'error'=>'Solo POST']); exit; }

$dbPath = __DIR__ . '/tarjetitas.db';

try {
  $pdo = new PDO('sqlite:' . $dbPath, null, null, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  ]);

  // Asegura la tabla con TU esquema exacto (si ya existe, no la toca)
  $pdo->exec('
    CREATE TABLE IF NOT EXISTS "tarjetitas" (
      "Identificador" INTEGER PRIMARY KEY AUTOINCREMENT,
      "usuario"       TEXT,
      "tarjetas"      TEXT
    );
    CREATE INDEX IF NOT EXISTS "idx_tarjetitas_usuario" ON "tarjetitas"("usuario");
  ');

  // Leer body
  $raw = file_get_contents('php://input');
  if ($raw === false || $raw === '') { http_response_code(400); echo json_encode(['ok'=>false,'error'=>'Body vacío']); exit; }

  $data = json_decode($raw, true);
  if (json_last_error() !== JSON_ERROR_NONE) { http_response_code(400); echo json_encode(['ok'=>false,'error'=>'JSON inválido']); exit; }

  $usuario = $data['usuario'] ?? null;
  $accion  = $data['accion']  ?? null;
  if (!$usuario) { http_response_code(400); echo json_encode(['ok'=>false,'error'=>'Falta usuario']); exit; }
  if (!$accion)  { http_response_code(400); echo json_encode(['ok'=>false,'error'=>'Falta accion (load/save)']); exit; }

  if ($accion === 'load') {
    // Busca la última versión (mayor Identificador) para ese usuario
    $stmt = $pdo->prepare('
      SELECT "Identificador", "tarjetas"
      FROM "tarjetitas"
      WHERE "usuario" = :u
      ORDER BY "Identificador" DESC
      LIMIT 1
    ');
    $stmt->execute([':u' => $usuario]);
    $row = $stmt->fetch();

    if ($row) {
      $tarjetas = json_decode($row['tarjetas'], true);
      if (json_last_error() !== JSON_ERROR_NONE) { $tarjetas = []; }
      echo json_encode([
        'ok'       => true,
        'existe'   => true,
        'id'       => (int)$row['Identificador'],
        'tarjetas' => $tarjetas
      ]);
    } else {
      echo json_encode([
        'ok'       => true,
        'existe'   => false,
        'id'       => null,
        'tarjetas' => []
      ]);
    }
    exit;
  }

  if ($accion === 'save') {
    if (!isset($data['tarjetas'])) {
      http_response_code(400); echo json_encode(['ok'=>false,'error'=>'Faltan tarjetas para guardar']); exit;
    }
    $tarjetas = $data['tarjetas'];
    $tarjetasJson = json_encode($tarjetas, JSON_UNESCAPED_UNICODE);
    if ($tarjetasJson === false) { http_response_code(400); echo json_encode(['ok'=>false,'error'=>'No serializa tarjetas']); exit; }

    $stmt = $pdo->prepare('
      INSERT INTO "tarjetitas" ("usuario","tarjetas")
      VALUES (:usuario, :tarjetas)
    ');
    $stmt->execute([
      ':usuario'  => $usuario,
      ':tarjetas' => $tarjetasJson
    ]);

    echo json_encode(['ok'=>true, 'id' => (int)$pdo->lastInsertId()]);
    exit;
  }

  http_response_code(400);
  echo json_encode(['ok'=>false,'error'=>'Accion desconocida']);
} catch (Throwable $e) {
  http_response_code(500);
  echo json_encode(['ok'=>false,'error'=>'Excepción','detalle'=>$e->getMessage()]);
}

