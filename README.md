# gps-from-exif

Get GPS from exif

Example: 

~~~.php
<?php

include_once "vendor/autoload.php";

use \diversen\gps;

// Example file
$file = "vendor/diversen/gps-from-exif/exmple.jpg";

$g = new gps();

// Get GPS position
$gps = $g->getGpsPosition($file);

print_r($gps);

// Get a goole map
echo $gmap = $g->getGmap($gps['latitude'], $gps['longitude']);

~~~
 