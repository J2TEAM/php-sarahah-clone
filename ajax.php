<?php
/* Developed by Juno_okyo */
define('ROOT', __DIR__ . DIRECTORY_SEPARATOR);
require_once ROOT . 'config.php';
require_once ROOT . 'vendor/autoload.php';

session_start();

// Check login status
if ( ! isset($_SESSION['logged_in']) OR (empty($_SERVER['HTTP_X_REQUESTED_WITH']) OR strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest')) {
  $data = ['error' => TRUE];
}

if (isset($_GET['action']) && ! empty($_GET['action'])) {
  $action = strtolower($_GET['action']);
  $db = new MysqliDb(DB_HOST, DB_USER, DB_PASS, DB_NAME);

  switch ($action) {
    case 'delete':
      if (isset($_POST['id']) && ! empty($_POST['id'])) {
        $db->where('id', intval($_POST['id']));
        $data = ['success' => $db->delete('messages')];
      } else {
        $data = ['error' => TRUE];
      }
      break;
    
    default:
      $data = ['error' => TRUE];
      break;
  }
} else {
  $data = ['error' => TRUE];
}

header('Content-Type: application/json');
echo json_encode($data);
exit;
