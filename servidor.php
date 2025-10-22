<?php
declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');

$dir = __DIR__ . '/data';
@mkdir($dir, 0775, true);

$reg = json_decode(file_get_contents('php://input'), true) ?: [];
$reg += [
  'timestamp' => date('c'),
  'ip' => $_SERVER['REMOTE_ADDR'] ?? null,
  'ua' => $_SERVER['HTTP_USER_AGENT'] ?? null,
];

file_put_contents($dir . '/registros.jsonl', json_encode($reg, JSON_UNESCAPED_UNICODE) . PHP_EOL, FILE_APPEND | LOCK_EX);

echo json_encode(['success' => true, 'file' => 'data/registros.jsonl']);

