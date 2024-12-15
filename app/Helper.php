<?php

namespace App;
 

class Helper
{
    public static function getFileExtension(string $decodedB64)
    {
        $fileInfo = finfo_buffer($finfo = finfo_open(), $decodedB64, FILEINFO_MIME_TYPE);
        finfo_close($finfo);
        return substr($fileInfo, strpos($fileInfo, '/') + 1);
    }

    public static function generateResizedImage($image)
    {
        // Generate small, medium, large
        $image = \Intervention\Image\ImageManagerStatic::make($image);
        $image->backup(); // backup status

        // Small
        $image->fit(150, 150);
        $imageSmall = (string) $image->encode();
        $image->reset();

        // Medium
        $image->fit(300, 300); // Medium
        $imageMedium = (string) $image->encode();
        $image->reset();

        $result = [
            'small' => $imageSmall,
            'medium' => $imageMedium,
            'normal' => $image,
        ];

        return $result;
    }

    public static function fresh_aprice($price)
    {
        return strtolower(preg_replace("/[^0-9]/", "", $price));
    }
 
}
