<?php

class Gallery
{
    public static $list_page_title = "Галерея. Аквацентр «Элми».Бассейн для детей в Ростове-на-Дону";

    public static function all()
    {
        //var_dump(gd_info());
        $full_dir_images = $_SERVER['DOCUMENT_ROOT'].ltrim( self::IMAGE_DIR, DIRECTORY_SEPARATOR);
        $files = System::get_dir_content( $full_dir_images);
        foreach ($files as $value) {
            $thumbnail_file = $_SERVER['DOCUMENT_ROOT']. self::THUMBS_DIR.DIRECTORY_SEPARATOR. $value;
            if (!file_exists($thumbnail_file )) {
                //var_dump($full_dir_images.DIRECTORY_SEPARATOR.$value ); echo "<br/>";
                self::img_resize($full_dir_images.DIRECTORY_SEPARATOR.$value, $thumbnail_file, self::THUMB_X, self::THUMB_Y);
            }
        }

        return System::get_dir_content( $_SERVER['DOCUMENT_ROOT'].self::THUMBS_DIR);
    }
}