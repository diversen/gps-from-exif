# gps-from-exif

Get GPS from exif

Install: 

    composer require diversen/gps-from-exif

Usage example: 

~~~.php
include_once "vendor/autoload.php";

use \diversen\gps;

// Example file
// $file = "vendor/diversen/gps-from-exif/failure.jpg";
$file = "vendor/diversen/gps-from-exif/example.jpg";

$g = new gps();

// Get GPS position
$gps = $g->getGpsPosition($file);
if (empty($gps)) {
    die('Could not get GPS position' . PHP_EOL);
}

print_r($gps);

// Get a google map
echo $gmap = $g->getGmap($gps['latitude'], $gps['longitude'], 600, 350);

~~~
 
