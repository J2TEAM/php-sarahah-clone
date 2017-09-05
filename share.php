<?php
define('ROOT', __DIR__ . DIRECTORY_SEPARATOR);
require_once ROOT . 'vendor/autoload.php';

use GDText\Box;
use GDText\Color;

if (isset($_GET['txt']) && ! empty($_GET['txt'])) {
  $text = base64_decode($_GET['txt']);
  $im = imagecreatefrompng(ROOT . 'images/bubble-background.png');

  $box = new Box($im);
  $box->setFontFace(ROOT . 'fonts/arial.ttf');
  $box->setFontColor(new Color(255, 75, 140));
  $box->setFontSize(30);
  $box->setLineHeight(1.5);
  $box->setBox(50, 50, 410, 340);
  $box->setTextAlign('center', 'center');
  $box->draw($text);

  header('Content-type: image/png');
  imagepng($im, null, 9, PNG_ALL_FILTERS);
  imagedestroy($im);
}
