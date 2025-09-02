<?php
require_once __DIR__.'/common/config.php';

// Restrict docs direct access via this proxy
$type = $_GET['type'] ?? '';
$id = (int)($_GET['id'] ?? 0);

if (!$mysqli || $mysqli->connect_errno) { http_response_code(404); exit('Not available'); }

switch ($type) {
  case 'notice':
    $st = $mysqli->prepare("SELECT file FROM notices WHERE id = ?");
    $st->bind_param('i', $id); $st->execute(); $st->bind_result($file);
    if ($st->fetch() && $file) {
      $path = __DIR__.'/uploads/notices/'.basename($file);
      if (is_file($path)) {
        $mime = mime_content_type($path) ?: 'application/octet-stream';
        header('Content-Type: '.$mime);
        header('Content-Disposition: attachment; filename="'.basename($path).'"');
        readfile($path); exit;
      }
    }
    $st->close();
    break;

  default:
    http_response_code(403); exit('Forbidden');
}

http_response_code(404); echo 'File not found';
