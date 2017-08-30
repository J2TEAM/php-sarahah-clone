<?php
/* Developed by Juno_okyo */
define('ROOT', __DIR__ . DIRECTORY_SEPARATOR);
require_once ROOT . 'config.php';
require_once ROOT . 'vendor/autoload.php';

session_start();

// Check login status
if ( ! isset($_SESSION['logged_in'])) {
  header('Location: login.php', TRUE, 302);
  exit;
}

$db = new MysqliDb(DB_HOST, DB_USER, DB_PASS, DB_NAME);
// $count = $db->getValue('messages', 'count("id")');

// Get all messages
$db->orderBy('timestamp', 'desc');
$messages = $db->get('messages');
$count = $db->count;

function clean($str) {
  return htmlentities(strip_tags($str), ENT_QUOTES | ENT_IGNORE, 'UTF-8');
}

function formatTime($timestamp) {
  return date('d/m/Y, h:i a', strtotime($timestamp));
}
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Juno_okyo">
    <meta name="copyright" content="J2TEAM">
    <title>Sarahah clone by Juno_okyo</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <link rel="stylesheet" href="css/main.css">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <?php include(ROOT . '_templates/navbar.php'); ?>
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <div class="alert alert-info">
            <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Total: <strong id="count"><?php echo $count; ?></strong> messages received.
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-12">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title"><span class="glyphicon glyphicon-inbox" aria-hidden="true"></span> Messages</h3>
            </div>
            <div class="panel-body">
              <?php if ($count === 0): ?>
              <div class="alert alert-warning">
                <strong>Oh NO!</strong> You have not received any messages yet.
              </div>
              <?php else: ?>
              <ul class="media-list" id="messages">
                <?php foreach ($messages as $message): ?>
                <li class="media" id="message-<?php echo $message['id']; ?>">
                  <div class="media-left">
                    <img class="media-object" src="images/message.png" alt="message" width="64" height="64">
                  </div>
                  <div class="media-body">
                    <button type="button" class="close" aria-label="Delete" data-id="<?php echo $message['id']; ?>"><span aria-hidden="true">&times;</span></button>
                    <!-- <span class="message-content">...</span> -->
                    <blockquote>
                      <p class="message-content"><?php echo clean($message['content']); ?></p>
                      <footer>Anonymous at <?php echo formatTime($message['timestamp']); ?></footer>
                    </blockquote>
                  </div>
                  <hr>
                </li>
                <?php endforeach; ?>
              </ul>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>