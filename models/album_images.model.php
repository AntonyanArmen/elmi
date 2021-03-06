<?php

class AlbumImages extends Model
{
    const IMAGE_DIR = '/images/gallery';
    const THUMBS_DIR = '/images/thumbs';
    const THUMB_X   = 300;
    const THUMB_Y   = 300;


    public static function img_resize($src, $dest, $width, $height, $rgb = 0xFFFFFF, $quality = 100)
    {
        if (!file_exists($src))
        {
            return false;
        }
        $size = getimagesize($src);
        if ($size === false)
        {
            return false;
        }

        $format = strtolower(substr($size['mime'], strpos($size['mime'], '/') + 1));
        $icfunc = 'imagecreatefrom' . $format;

        if (!function_exists($icfunc))
        {
            return false;
        }

        $x_ratio = $width / $size[0];
        $y_ratio = $height / $size[1];

        if ($height == 0) {
            $y_ratio = $x_ratio;
            $height = $y_ratio * $size[1];
        } elseif ($width == 0) {
            $x_ratio = $y_ratio;
            $width = $x_ratio * $size[0];
        }

        $ratio = min($x_ratio, $y_ratio);
        $use_x_ratio = ($x_ratio == $ratio);
        $new_width = $use_x_ratio ? $width : floor($size[0] * $ratio);
        $new_height = !$use_x_ratio ? $height : floor($size[1] * $ratio);
        $isrc = $icfunc($src);
        $idest = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($idest, $isrc, 0, 0, 0, 0, $new_width, $new_height, $size[0], $size[1]);
        imagejpeg($idest, $dest, $quality);
        imagedestroy($isrc);
        imagedestroy($idest);
        return true;
    }

    protected static $behaviours = [
        'album' => [
            'key' => 'albumID',
            'class' => 'Album',
            'type' => 'one'
        ]
    ];
    protected static $fields = [];
    protected static $field_types = [];

    public static function className()
    {
        return 'AlbumImages';
    }

    public static function tableName()
    {
        return 'lst_album_images';
    }

    public static  function all($condition = '1', $field = null)
    {
        $images =  parent::all($condition, $field);

        $full_dir_images = $_SERVER['DOCUMENT_ROOT'].ltrim( self::IMAGE_DIR, DIRECTORY_SEPARATOR);
        foreach ($images as $value) {
            $thumbnail_file = $_SERVER['DOCUMENT_ROOT']. self::THUMBS_DIR.DIRECTORY_SEPARATOR. $value;
            if (!file_exists($thumbnail_file )) {
                //var_dump($full_dir_images.DIRECTORY_SEPARATOR.$value ); echo "<br/>";
                self::img_resize($full_dir_images.DIRECTORY_SEPARATOR.$value, $thumbnail_file, self::THUMB_X, self::THUMB_Y);
            }
        }

        return $images;
    }
}