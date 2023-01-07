<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* Function  to resize image */
function resizeImage($image,$width,$height,$scale, $ext) {
	$newImageWidth = ceil($width * $scale);
	$newImageHeight = ceil($height * $scale);
	$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
	switch ($ext) {
        case 'jpg':
        case 'jpeg':
            $source = imagecreatefromjpeg($image);
            break;
        case 'gif':
            $source = imagecreatefromgif($image);
            break;
        case 'png':
            $source = imagecreatefrompng($image);
            break;
        default:
            $source = false;
            break;
    }	
	imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);
	imagejpeg($newImage,$image,90);
	chmod($image, 0777);
	return $image;
}
/*  Function to get image height. */
function getHeight($image) {
    $sizes = getimagesize($image);
    $height = $sizes[1];
    return $height;
}
/* Function to get image width */
function getWidth($image) {
    $sizes = getimagesize($image);
    $width = $sizes[0];
    return $width;
}