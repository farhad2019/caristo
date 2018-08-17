<?php
/**
 * Created by PhpStorm.
 * User: rehmanali
 * Date: 8/17/2018
 * Time: 3:07
 */

namespace App\Helper;

use Image;

class Utils
{
    public static function handlePicture($mediaFile, $folder = "media_files")
    {
        $rand = time();
        $filename = $rand . '.jpg';

        $path = implode(DIRECTORY_SEPARATOR, ['storage', 'app', $folder]);
        $basePath = base_path() . DIRECTORY_SEPARATOR . $path;

        $filePath = $path . DIRECTORY_SEPARATOR . $filename;
        $baseFilePath = base_path() . DIRECTORY_SEPARATOR . $filePath;

        $mediaFile->move($basePath, $mediaFile->getClientOriginalName());

        $image = Image::make($basePath . DIRECTORY_SEPARATOR . $mediaFile->getClientOriginalName());
        $image->save($baseFilePath, 100);
        unset($image);
        $image = null;
        unlink($basePath . DIRECTORY_SEPARATOR . $mediaFile->getClientOriginalName());
        return [
            'title'    => $mediaFile->getClientOriginalName(),
            'filename' => $folder . '/' . $filename
        ];
    }
}