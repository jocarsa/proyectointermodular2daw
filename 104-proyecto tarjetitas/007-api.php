<?php
// 004-api.php
//
// Tablas esperadas:
//   CREATE TABLE "tarjetitas" (
//     "Identificador" INTEGER PRIMARY KEY AUTOINCREMENT,
//     "usuario"       TEXT,
//     "tarjetas"      TEXT
//   );
//
//   CREATE TABLE IF NOT EXISTS "users" (
//     "id"         INTEGER PRIMARY KEY AUTOINCREMENT,
//     "usuario"    TEXT UNIQUE,
//     "passhash"   TEXT,
//     "created_at" TEXT DEFAULT (datetime('now'))
//   );
//
// Acciones (POST JSON):
//   - signin: {accion:"signin", usuario, password}
//   - login:  {accion:"login",  usuario, password}
//   - load:   {accion:"load",   usuario, password}
//   - save:   {accion:"save",   usuario, password, tarjetas: Array|Object}
//
// Nota: "tarjetas" acepta el formato antiguo (Array de tarjetas) o el nuevo
//       (Object con { boards:[{id,name,cards:[]}...], activeBoardId }).

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

  // Asegurar tabla de usuarios (tarjetitas ya existe en tu esquema)
  $pdo->exec('
    CREATE TABLE IF NOT EXISTS "users" (
      "id"         INTEGER PRIMARY KEY AUTOINCREMENT,
      "usuario"    TEXT UNIQUE,
      "passhash"   TEXT,
      "created_at" TEXT DEFAULT (datetime(' . "'now'" . '))
    );
    CREATE INDEX IF NOT EXISTS "idx_users_usuario" ON "users"("usuario");
    CREATE INDEX IF NOT EXISTS "idx_tarjetitas_usuario" ON "tarjetitas"("usuario");
  ');

  $raw = file_get_contents('php://input');
  if ($raw === false || $raw === '') { http_response_code(400); echo json_encode(['ok'=>false,'error'=>'Body vacío']); exit; }
  $data = json_decode($raw, true);
  if (json_last_error() !== JSON_ERROR_NONE) { http_response_code(400); echo json_encode(['ok'=>false,'error'=>'JSON inválido']); exit; }

  $accion   = $data['accion']   ?? null;
  $usuario  = trim($data['usuario'] ?? '');
  $password = (string)($data['password'] ?? '');

  if (!$accion)  { http_response_code(400); echo json_encode(['ok'=>false,'error'=>'Falta accion']); exit; }
  if (!$usuario) { http_response_code(400); echo json_encode(['ok'=>false,'error'=>'Falta usuario']); exit; }

  // Helper
  $getUser = function($u) use ($pdo) {
    $s = $pdo->prepare('SELECT * FROM "users" WHERE "usuario" = :u LIMIT 1');
    $s->execute([':u'=>$u]);
    return $s->fetch();
  };

  // --- SIGNIN ---
  if ($accion === 'signin') {
    if (!$password) { http_response_code(400); echo json_encode(['ok'=>false,'error'=>'Falta password']); exit; }
    $existing = $getUser($usuario);
    if ($existing) { http_response_code(409); echo json_encode(['ok'=>false,'error'=>'Usuario ya existe']); exit; }
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $ins  = $pdo->prepare('INSERT INTO "users" ("usuario","passhash") VALUES (:u,:p)');
    $ins->execute([':u'=>$usuario, ':p'=>$hash]);
    echo json_encode(['ok'=>true, 'msg'=>'Usuario creado']);
    exit;
  }

  // --- LOGIN ---
  if ($accion === 'login') {
    if (!$password) { http_response_code(400); echo json_encode(['ok'=>false,'error'=>'Falta password']); exit; }
    $u = $getUser($usuario);
    if (!$u || !password_verify($password, $u['passhash'])) {
      http_response_code(401); echo json_encode(['ok'=>false,'error'=>'Credenciales inválidas']); exit;
    }
    echo json_encode(['ok'=>true, 'msg'=>'Login correcto']);
    exit;
  }

  // A partir de aquí, requiere credenciales válidas
  if (!$password) { http_response_code(400); echo json_encode(['ok'=>false,'error'=>'Falta password']); exit; }
  $u = $getUser($usuario);
  if (!$u || !password_verify($password, $u['passhash'])) {
    http_response_code(401); echo json_encode(['ok'=>false,'error'=>'Credenciales inválidas']); exit;
  }

  // --- LOAD: devuelve la última versión del usuario ---
  if ($accion === 'load') {
    $stmt = $pdo->prepare('
      SELECT "Identificador","tarjetas"
      FROM "tarjetitas"
      WHERE "usuario" = :u
      ORDER BY "Identificador" DESC
      LIMIT 1
    ');
    $stmt->execute([':u'=>$usuario]);
    $row = $stmt->fetch();

    if ($row) {
      $tarjetas = json_decode($row['tarjetas'], true);
      if (json_last_error() !== JSON_ERROR_NONE) { $tarjetas = []; }
      echo json_encode(['ok'=>true,'existe'=>true,'id'=>(int)$row['Identificador'],'tarjetas'=>$tarjetas]);
    } else {
      echo json_encode(['ok'=>true,'existe'=>false,'id'=>null,'tarjetas'=>[]]);
    }
    exit;
  }

  // --- SAVE: inserta nueva versión (acepta array legacy u objeto con boards) ---
  if ($accion === 'save') {
    if (!isset($data['tarjetas'])) {
      http_response_code(400); echo json_encode(['ok'=>false,'error'=>'Faltan tarjetas']); exit;
    }
    $tarjetas = $data['tarjetas'];
    if (!is_array($tarjetas) && !is_object($tarjetas)) {
      http_response_code(400); echo json_encode(['ok'=>false,'error'=>'Formato inválido de tarjetas']); exit;
    }
    $json = json_encode($tarjetas, JSON_UNESCAPED_UNICODE);
    if ($json === false) { http_response_code(400); echo json_encode(['ok'=>false,'error'=>'No serializa tarjetas']); exit; }

    $ins = $pdo->prepare('INSERT INTO "tarjetitas" ("usuario","tarjetas") VALUES (:u,:t)');
    $ins->execute([':u'=>$usuario, ':t'=>$json]);
    echo json_encode(['ok'=>true, 'id'=>(int)$pdo->lastInsertId()]);
    exit;
  }

  http_response_code(400);
  echo json_encode(['ok'=>false,'error'=>'Accion desconocida']);
} catch (Throwable $e) {
  http_response_code(500);
  echo json_encode(['ok'=>false,'error'=>'Excepción','detalle'=>$e->getMessage()]);
}

