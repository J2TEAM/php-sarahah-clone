<?php
/* Developed by Juno_okyo */
define('ROOT', __DIR__ . DIRECTORY_SEPARATOR);

session_start();

// Check login status
if (isset($_SESSION['logged_in'])) {
  header('Location: messages.php', TRUE, 302);
  exit;
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
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <div class="alert alert-info">
            <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Get honest feedback from your coworkers and friends
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <h4>At work</h4>
          <ul>
            <li>Enhance your areas of strength</li>
            <li>Strengthen Areas for Improvement</li>
          </ul>
        </div>
        <div class="col-md-6">
          <h4>With Your Friends</h4>
          <ul>
            <li>Improve your friendship by discovering your strengths and areas for improvement</li>
            <li>Let your friends be honest with you</li>
          </ul>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-xs-12">
          <a href="login.php">Login to your account</a> or <a href="new-message.php">Send a anonymous message</a>
        </div>
      </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </body>
</html>