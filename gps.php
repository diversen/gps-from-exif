<?php

namespace diversen;

/**
 * Class with single method for getting GPS from exif data
 * Found on stackoverflow and sligtly modified 
 * @see http://stackoverflow.com/a/4178862/464549
 * @param array $exif
 * @param boolean $assoc
 * @return array|string $ret json string or assoc array 
 */
class gps {

    /**
     * Read exif data from file
     * @param string $file
     * @return array|false array if exif datawas found else false
     */
    private function getExifData($file) {
        
        $exif = @exif_read_data($file, 'EXIF', false);
        if (!$exif) {
            return false;
        }
        return $exif;
    }

    /**
     * Returns an array with exif data from an image
     * False if no exif data exists in the image
     * @param string $file path to image
     * @return array|false $array array with GPS info, e.g. <code>Array
(
    [latitude] => 56.382169444444
    [longitude] => 9.8963
)</code>

     */
    public function getGpsPosition($file) {

        $exif = $this->getExifData($file);
        if (!$exif) {
            return false;
        }

        $LatM = 1;
        $LongM = 1;
        if ($exif["GPSLatitudeRef"] == 'S') {
            $LatM = -1;
        }
        if ($exif["GPSLongitudeRef"] == 'W') {
            $LongM = -1;
        }

        // Get the GPS data
        $gps['LatDegree'] = $exif["GPSLatitude"][0];
        $gps['LatMinute'] = $exif["GPSLatitude"][1];
        $gps['LatgSeconds'] = $exif["GPSLatitude"][2];
        $gps['LongDegree'] = $exif["GPSLongitude"][0];
        $gps['LongMinute'] = $exif["GPSLongitude"][1];
        $gps['LongSeconds'] = $exif["GPSLongitude"][2];

        //convert strings to numbers
        foreach ($gps as $key => $value) {
            $pos = strpos($value, '/');
            if ($pos !== false) {
                $temp = explode('/', $value);
                $gps[$key] = $temp[0] / $temp[1];
            }
        }

        //calculate the decimal degree
        $result['latitude'] = $LatM * ($gps['LatDegree'] + ($gps['LatMinute'] / 60) + ($gps['LatgSeconds'] / 3600));
        $result['longitude'] = $LongM * ($gps['LongDegree'] + ($gps['LongMinute'] / 60) + ($gps['LongSeconds'] / 3600));

        return $result;

    }

    /**
     * Exampe of getting a google map from 
     * @param float $lat latitude
     * @param float $long longitude
     * @return type
     */
    public function getGmap($lat, $long) {
        $width = conf::getModuleIni('gallery_image_size');
        $gmap = <<<EOF
<div class ="google_map">
<iframe 
width="$width" 
height="350" 
frameborder="0" 
scrolling="no" 
marginheight="0" 
marginwidth="0" 
src="http://maps.google.com/?ie=UTF8&amp;hq=&amp;t=h&amp;ll=$lat,$long&amp;spn=0.016643,0.036478&amp;z=14&amp;output=embed"></iframe>
</div>
EOF;
        return $gmap;
    }
}