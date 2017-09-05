<?php
/* Developed by Juno_okyo */
define('ROOT', __DIR__ . DIRECTORY_SEPARATOR);
require_once ROOT . 'config.php';
require_once ROOT . 'vendor/autoload.php';

function request($url)
{
  if ( ! filter_var($url, FILTER_VALIDATE_URL)) {
    return FALSE;
  }
  
  $options = array(
    CURLOPT_URL            => $url,
    CURLOPT_RETURNTRANSFER => TRUE,
    CURLOPT_HEADER         => FALSE,
    CURLOPT_FOLLOWLOCATION => TRUE,
    CURLOPT_ENCODING       => '',
    CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.87 Safari/537.36',
    CURLOPT_AUTOREFERER    => TRUE,
    CURLOPT_CONNECTTIMEOUT => 15,
    CURLOPT_TIMEOUT        => 15,
    CURLOPT_MAXREDIRS      => 5,
    CURLOPT_SSL_VERIFYHOST => 2,
    CURLOPT_SSL_VERIFYPEER => 0
  );

  $ch = curl_init();
  curl_setopt_array($ch, $options);
  $response = curl_exec($ch);
  $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);
  unset($options);
  return $http_code === 200 ? json_decode($response) : FALSE;
}

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

    case 'share':
      if (isset($_POST['id'], $_POST['caption'], $_POST['path']) && ! empty($_POST['id']) && ! empty($_POST['caption']) && ! empty($_POST['path'])) {
        $db->where('id', intval($_POST['id']));
        $message = $db->getOne('messages');
        if ($db->count === 1) {
          $url = $_POST['path'] . 'share.php?txt=' . base64_encode($message['content']);
          $caption = $_POST['caption'];
          $json = request('https://graph.facebook.com/v2.10/me/photos?method=post&url=' . urlencode($url) . '&caption=' . urlencode($caption) . '&access_token=' . urlencode(ACCESS_TOKEN));

          if ($json !== FALSE && isset($json->post_id)) {
            $data = ['success' => TRUE, 'id' => $json->post_id];
          } else {
            $data = ['error' => TRUE];
          }
        } else {
          $data = ['error' => TRUE];
        }
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
