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
        <li><a data-toggle="modal" href="#modal-about">About</a></li>
        <li><a href="https://m.me/manhtuan1412" target="_blank">Contact</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="modal fade" id="modal-about">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> About</h4>
      </div>
      <div class="modal-body">
        <p>Developed by <strong><a href="https://junookyo.blogspot.com/?utm_source=sarahah_clone" target="_blank">Juno_okyo</a></strong>.
        Copyright &copy; 2017 <strong><a href="https://www.facebook.com/J2TeaM.pro/" target="_blank">J2TEAM</a></strong>.
        All rights reserved.</p>
        <p>The source code is available on <a href="https://github.com/J2TeaM/php-sarahah-clone/" target="_blank">GitHub</a>.</p>
      </div>
    </div>
  </div>
</div>
