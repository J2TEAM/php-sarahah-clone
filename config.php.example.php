<?php
/* Developed by Juno_okyo */
defined('ROOT') or die('Access denied.');

/* Database */
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', '');

/* Authentication */
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD', '$2y$10$3/diQl2HDIinCtvijnVeP.sdz6flPXFfiTdx.NEq3/MppR.9tuXg2');

/* reCaptcha */
define('RECAPTCHA_SECRET', 'YOUR_SECRET');

/* OTHER */
define('YOUR_NAME', 'Juno_okyo');

/**
 * Use this function to generate a new hash for your password
 * NOTE: Please delete it after you have the hash!
 **/
// echo password_hash('admin', PASSWORD_DEFAULT);
