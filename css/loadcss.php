<?php
/**
 * On-the-fly CSS Compression
 * Copyright (c) 2009 and onwards, Manas Tungare.
 * Creative Commons Attribution, Share-Alike.
 *
 * In order to minimize the number and size of HTTP requests for CSS content,
 * this script combines multiple CSS files into a single file and compresses
 * it on-the-fly.
 *
 * To use this in your HTML, link to it in the usual way:
 * <link rel="stylesheet" type="text/css" media="screen, print, projection" href="/css/compressed.css.php" />
 */
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/core.php');
CORE_compress();
header('Cache-control: max-age=360000');
$cssFiles = array(
  "bootstrap.css",
  "dashboard.css",
  "signin.css"
);
header("Content-type: text/css");
$buffer = "";
foreach ($cssFiles as $cssFile) {
  $buffer .= file_get_contents($cssFile);
}
$buffer .= file_get_contents( $_SERVER['DOCUMENT_ROOT'] . '/lib/switchery/switchery.min.css');


$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
$buffer = str_replace(': ', ':', $buffer);
$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
echo($buffer);
?>