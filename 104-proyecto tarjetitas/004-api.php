<?php
// 002-api.php — guarda payload.usuario -> usuario, payload.tarjetas -> tarjetas

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, Accept');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }

$dbPath = __DIR__ . '/tarjetitas.db';


  $pdo = new PDO('sqlite:' . $dbPath, null, null, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  ]);

 

  // Lee y parsea
  $raw = file_get_contents('php://input');
  if (!$raw) { http_response_code(400); echo json_encode(['ok'=>false,'error'=>'Body vacío']); exit; }

  $data = json_decode($raw, true);
  if (json_last_error() !== JSON_ERROR_NONE) { http_response_code(400); echo json_encode(['ok'=>false,'error'=>'JSON inválido']); exit; }

  // ---- EXACTO: asigna payload a columnas ----
  $usuario  = $data['usuario']  ?? null;
  $tarjetas = $data['tarjetas'] ?? null;

  if ($usuario === null || $tarjetas === null) {
    http_response_code(400);
    echo json_encode(['ok'=>false,'error'=>'Faltan usuario o tarjetas']);
    exit;
  }

  // Guarda tarjetas como JSON texto
  $tarjetasJson = json_encode($tarjetas, JSON_UNESCAPED_UNICODE);
  if ($tarjetasJson === false) { http_response_code(400); echo json_encode(['ok'=>false,'error'=>'No serializa tarjetas']); exit; }

  $stmt = $pdo->prepare('INSERT INTO tarjetitas (usuario, tarjetas) VALUES (:usuario, :tarjetas)');
  $stmt->execute([
    ':usuario'  => $usuario,
    ':tarjetas' => $tarjetasJson,
  ]);

  echo json_encode(['ok'=>true,'id'=>$pdo->lastInsertId()]);

