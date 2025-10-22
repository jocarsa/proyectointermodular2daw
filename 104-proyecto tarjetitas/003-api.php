<?php
// 002-api.php — CORS + guardar POST en SQLite + autocreate + respuestas claras

// CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, Accept');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Content-Type: application/json; charset=utf-8');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$dbPath = __DIR__ . '/tarjetitas.db';

  $pdo = new PDO('sqlite:' . $dbPath, null, null, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  ]);

  $raw = file_get_contents('php://input');
  if ($raw === false || $raw === '') {
    http_response_code(400);
    echo json_encode(['ok'=>false,'error'=>'Body vacío']);
    exit;
  }

  $stmt = $pdo->prepare('INSERT INTO tarjetitas(usuario, tarjetas) VALUES(:usuario, :tarjetas)');
  $stmt->execute([
    ':usuario'  => 'jocarsa',
    ':tarjetas' => $raw,
  ]);

  echo json_encode(['ok'=>true,'id'=>$pdo->lastInsertId()]);


