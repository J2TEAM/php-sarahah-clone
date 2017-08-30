<?php defined('ROOT') or die('Access denied.'); ?>
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php" title="Sarahah">Sarahah</a>
    </div>
    <div class="collapse navbar-collapse" id="navbar-collapse">
      <ul class="nav navbar-nav navbar-right">
        <?php if (isset($_SESSION['logged_in'])): ?>
        <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
        <li><a href="login.php">Login</a></li>
        <?php endif; ?>
        <li><a href="about.php">About</a></li>
        <li><a href="https://m.me/manhtuan1412" target="_blank">Contact</a></li>
      </ul>
    </div>
  </div>
</nav>
