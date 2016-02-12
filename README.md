# gps-from-exif

Get GPS from exif

Example: 

~~~.php
<?php

include_once "vendor/autoload.php";

use \diversen\gps;

$file = "vendor/diversen/gps-from-exif/exmple.jpg";

$g = new gps();
$ary = $g->get($file);

print_r($ary);

echo $g->getGmap($ary['latitude'], $ary['longitude']);

~~~
 