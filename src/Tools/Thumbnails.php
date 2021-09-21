<?php
/**
 * Created by PhpStorm.
 * User: Ross
 * Date: 10/9/2018
 * Time: 11:15 PM
 */

namespace App\Tools;


class Thumbnails
{
    public function __construct()
    {
        //
    }

    public static function createThumbnail($destination, $filePath, $targetWith){
        $type = pathinfo($filePath)['extension'];
        $dimension = getimagesize($filePath);
        $largeWidth = $dimension[0]; // obtenir la largeur de la tof
        $largeHeight = $dimension[1]; // la hauteur
        $ratio = $largeWidth / $largeHeight;
        $targetHeight = $targetWith / $ratio;

        if( $filePath != '' && isset($filePath) ){
            $pic = ($type == 'jpg' || $type == 'jpeg') ? imagecreatefromjpeg($filePath) : imagecreatefrompng($filePath) ;
            $small = imagecreatetruecolor($targetWith, $targetHeight);
            imagecopyresampled($small, $pic, 0, 0, 0, 0, $targetWith, $targetHeight, $largeWidth, $largeHeight);

            return ($type == 'jpg' || $type == 'jpeg') ? imagejpeg($small, $destination) : imagepng($small, $destination);
        }
        return false;
    }

}