<?php
/* Developed by Juno_okyo */
define('ROOT', __DIR__ . DIRECTORY_SEPARATOR);
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
          <div class="panel panel-default">
            <div class="panel-body">
              Developed by <strong><a href="https://junookyo.blogspot.com/?utm_source=sarahah" target="_blank">Juno_okyo</a></strong>.
              Copyright &copy; <?php echo date('Y'); ?> <strong><a href="https://www.facebook.com/J2TeaM.pro/" target="_blank">J2TEAM</a></strong>.
              All rights reserved.
              <br>
              The source code is available on <a href="https://github.com/J2TeaM" target="_blank">GitHub</a>.
            </div>
          </div>

          <a href="index.php" class="btn btn-default"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Go Home</a>
          <a href="new-message.php" class="btn btn-default"><span class="glyphicon glyphicon-send" aria-hidden="true"></span> Send a new message</a>
        </div>
      </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </body>
</html>