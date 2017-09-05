<?php
/* Developed by Juno_okyo */
define('ROOT', __DIR__ . DIRECTORY_SEPARATOR);
require_once ROOT . 'config.php';
require_once ROOT . 'vendor/autoload.php';

session_start();

// Check login status
if (isset($_SESSION['logged_in'])) {
  header('Location: messages.php', TRUE, 302);
  exit;
}

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

if (isset($_POST['username'], $_POST['password'], $_POST['g-recaptcha-response']) && ! empty($_POST['username']) && ! empty($_POST['password']) && ! empty($_POST['g-recaptcha-response'])) {
  $resp = $recaptcha->verify($_POST['g-recaptcha-response'], get_client_ip());

  if ($resp->isSuccess() && $_POST['username'] === ADMIN_USERNAME && password_verify($_POST['password'], ADMIN_PASSWORD)) {
    $_SESSION['logged_in'] = TRUE;

    // Redirect to the messages page
    header('Location: messages.php', TRUE, 302);
    exit;
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
    <div class="container" style="width: 600px;">
      <div class="row">
        <div class="col-xs-12">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">User Login</h3>
            </div>
            <div class="panel-body">
              <form action="login.php" method="POST" role="form" id="form">
                <div class="form-group">
                  <label for="username"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Username</label>
                  <input type="text" class="form-control" name="username" id="username" placeholder="Your username..." autofocus required>
                </div>

                <div class="form-group">
                  <label for="password"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span> Password</label>
                  <input type="password" class="form-control" name="password" id="password" placeholder="Your password..." required>
                </div>
              
                <button type="submit" class="btn btn-primary g-recaptcha" data-sitekey="<?php echo RECAPTCHA_SITEKEY; ?>" data-callback="recaptchaCallback"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Login</button>
                <button type="reset" class="btn btn-danger"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Reset</button>
              </form>
            </div>
          </div>

          <?php if ($error): ?>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Error!</strong> Your username or password is incorrect.
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