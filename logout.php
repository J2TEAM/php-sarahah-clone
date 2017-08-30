<?php
/* Developed by Juno_okyo */
session_start();

// Check login status
if (isset($_SESSION['logged_in'])) {
  session_destroy();
}

// Redirect to the login page
header('Location: login.php', TRUE, 302);
exit;
