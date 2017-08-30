<?php
/* Developed by Juno_okyo */
define('ROOT', __DIR__ . DIRECTORY_SEPARATOR);
require_once ROOT . 'config.php';
require_once ROOT . 'vendor/autoload.php';

function get_client_ip() {
  $ipaddress = '';
  if (getenv('HTTP_CLIENT_IP'))
    $ipaddress = getenv('HTTP_CLIENT_IP');
  else if(getenv('HTTP_X_FORWARDED_FOR'))
    $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
  else if(getenv('HTTP_X_FORWARDED'))
    $ipaddress = getenv('HTTP_X_FORWARDED');
  else if(getenv('HTTP_FORWARDED_FOR'))
    $ipaddress = getenv('HTTP_FORWARDED_FOR');
  else if(getenv('HTTP_FORWARDED'))
    $ipaddress = getenv('HTTP_FORWARDED');
  else if(getenv('REMOTE_ADDR'))
    $ipaddress = getenv('REMOTE_ADDR');
  else
    $ipaddress = 'UNKNOWN';
  return $ipaddress;
}

$recaptcha = new \ReCaptcha\ReCaptcha(RECAPTCHA_SECRET);
$error = FALSE;

if (isset($_POST['message'], $_POST['g-recaptcha-response']) && ! empty($_POST['message']) && ! empty($_POST['g-recaptcha-response'])) {
  $resp = $recaptcha->verify($_POST['g-recaptcha-response'], get_client_ip());
  
  if ($resp->isSuccess()) {
    $db = new MysqliDb(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($db->insert('messages', ['content' => $_POST['message']])) {
      header('Location: thank-you.php', FALSE, 302);
      exit;
    } else {
      $error = TRUE;
    }
  } else {
    $error = TRUE;
  }
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
    <link rel="stylesheet" href="css/main.css">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <?php include(ROOT . '_templates/navbar.php'); ?>
    <div class="container" style="width: 800px;">
      <div class="row">
        <div class="col-xs-12">
          <div class="panel panel-default">
            <div class="panel-body">
              <form action="new-message.php" method="POST" role="form" id="form">
                <legend>Send a new message to <strong><?php echo YOUR_NAME; ?></strong></legend>
              
                <div class="form-group">
                  <label for="">Leave a constructive message</label>
                  <textarea name="message" class="form-control" rows="5" maxlength="700" placeholder="Your message..." required autofocus></textarea>
                </div>
              
                <button type="submit" class="btn btn-primary btn-block g-recaptcha" data-sitekey="6LfXvC4UAAAAAKkSguZdwX9E3_lrrMP3bZcD_Isf" data-callback="recaptchaCallback"><span class="glyphicon glyphicon-send" aria-hidden="true"></span> Send</button>
              </form>
            </div>
          </div>

          <?php if ($error): ?>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Error!</strong> Cannot save your message. Please try again!
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script>
      function recaptchaCallback() {
        if (document.getElementById('g-recaptcha-response').value.length > 0) {
          document.getElementById('form').submit();
        } else {
          return false;
        }
      }
    </script>
  </body>
</html>