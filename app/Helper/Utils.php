<?php

namespace App\Helper;

use Image;

class Utils
{
    const BOOL_FALSE = 0;
    const BOOL_TRUE = 1;

    public static $BOOLS = [
        self::BOOL_FALSE => "No",
        self::BOOL_TRUE  => "Yes",
    ];
    public static $BOOLS_CSS = [
        self::BOOL_FALSE => "danger",
        self::BOOL_TRUE  => "success",
    ];
    public static $BOOLS_BG_CSS = [
        self::BOOL_FALSE => "red",
        self::BOOL_TRUE  => "green",
    ];

    /**
     * @param $mediaFile
     * @param string $folder
     * @return array
     */
    public static function handlePicture($mediaFile, $folder = "media_files")
    {
        $rand = microtime(true);
        $filename = (int)$rand . '.png';

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

    /**
     * @param $value
     * @return mixed
     */
    public static function getBoolText($value)
    {
        return self::$BOOLS[$value];
    }

    /**
     * @param $value
     * @param bool $bg
     * @return mixed
     */
    public static function getBoolCss($value, $bg = false)
    {
        return $bg ? self::$BOOLS_BG_CSS[$value] : self::$BOOLS_CSS[$value];
    }
}