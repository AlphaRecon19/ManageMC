<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/core/file.php');
// Get a file into an array.  In this example we'll go through HTTP to get
// the HTML source of a URL.
$file = Get_Path("MGM4YmVkZmNmZDFkNTA1M2RjMjhiNGQwZTBhYzVkZjk=","/home/minecraft/minecraft/server.properties");
$lines = file($file);

// Loop through our array, show HTML source as HTML source; and line numbers too.
foreach ($lines as $line_num => $line) {
    echo "" . htmlspecialchars($line) . "<br />\n";
}

// Another example, let's get a web page into a string.  See also file_get_contents().
$html = implode('', file($file));

// Using the optional flags parameter since PHP 5
$trimmed = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
?>