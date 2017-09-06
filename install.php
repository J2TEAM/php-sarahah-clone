<?php
/* Developed by Juno_okyo */
define('ROOT', __DIR__ . DIRECTORY_SEPARATOR);
require_once ROOT . 'vendor/autoload.php';

$error = FALSE;

if (file_exists(ROOT . 'config.php.example')) {
  if (isset($_POST['db_host'], $_POST['db_user'], $_POST['db_pass'], $_POST['db_pass'])) {
    // Check Database connection
    try {
      $db = new MysqliDb($_POST['db_host'], $_POST['db_user'], $_POST['db_pass'], $_POST['db_name']);
      // $db->ping();

      if ( ! $db->tableExists('messages')) {
        $sql = "CREATE TABLE `messages` (
                  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                  `content` VARCHAR(800) NOT NULL,
                  `favorited` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
                  `timestamp` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
                  PRIMARY KEY (`id`)
                )
                COLLATE='utf8mb4_general_ci'
                ENGINE=InnoDB
                AUTO_INCREMENT=1;";
        $db->rawQuery($sql);
      }

      /* Generate hash for your password */
      $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
      
      /* Render template for config.php */
      $keys = array(
        'db_host',
        'db_user',
        'db_pass',
        'db_name',
        'username',
        'password',
        'sitekey',
        'secret',
        'access_token',
        'your_name'
      );
      $template = file_get_contents(ROOT . 'config.php.example');
      
      foreach ($keys as $i => $key) {
        $template = str_replace('{' . ($i + 1) . '}', addslashes($_POST[$key]), $template);
      }

      unset($keys);

      /* Create config.php */
      file_put_contents(ROOT . 'config.php', $template, LOCK_EX);

      /* Self remove */
      unlink(ROOT . 'config.php.example');
      unlink(ROOT . 'install.php');

      header('Location: index.php', TRUE, 302);
      exit;
    } catch(Exception $e) {
      $error = $e->getMessage();
    }
  }
} else {
  die('Error: The template file does not exist!');
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
          <?php if ($error !== FALSE): ?>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Error!</strong> <?php echo $error; ?>
          </div>
          <?php endif; ?>

          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Config</h3>
            </div>
            <div class="panel-body">
              <form action="install.php" method="POST" role="form">
                <legend>Database</legend>
              
                <div class="form-group">
                  <label for="db_host">Host</label>
                  <input type="text" class="form-control" name="db_host" id="db_host" placeholder="localhost" value="localhost" autofocus required>
                </div>

                <div class="form-group">
                  <label for="db_user">Username</label>
                  <input type="text" class="form-control" name="db_user" id="db_user" placeholder="root" required>
                </div>

                <div class="form-group">
                  <label for="db_pass">Password</label>
                  <input type="password" class="form-control" name="db_pass" id="db_pass" placeholder="password" required>
                </div>

                <div class="form-group">
                  <label for="db_name">DB Name</label>
                  <input type="text" class="form-control" name="db_name" id="db_name" placeholder="sarahah" required>
                </div>

                <legend>Authentication</legend>

                <div class="form-group">
                  <label for="username">Username</label>
                  <input type="text" class="form-control" name="username" id="username" placeholder="admin" value="admin" required>
                </div>

                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" name="password" id="password" placeholder="password" required>
                </div>

                <legend>reCaptcha</legend>

                <div class="form-group">
                  <label for="sitekey">Sitekey</label>
                  <input type="text" class="form-control" name="sitekey" id="sitekey" placeholder="sitekey" required>
                </div>

                <div class="form-group">
                  <label for="secret">Secret</label>
                  <input type="text" class="form-control" name="secret" id="secret" placeholder="secret" required>
                </div>

                <legend>Facebook</legend>

                <div class="form-group">
                  <label for="access_token">Access Token</label>
                  <input type="text" class="form-control" name="access_token" id="access_token" placeholder="access_token" required>
                </div>

                <legend>Other</legend>

                <div class="form-group">
                  <label for="your_name">Your name</label>
                  <input type="text" class="form-control" name="your_name" id="your_name" placeholder="Example: Manh Tuan" required>
                </div>
              
                <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Install</button>
                <button type="reset" class="btn btn-danger"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Reset</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </body>
</html>