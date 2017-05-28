<?php

class Album extends Model
{
    protected static $behaviours = [];
    protected static $fields = [];
    protected static $field_types = [];

    public static function className()
    {
        return 'Album';
    }

    public static function tableName()
    {
        return 'lst_album';
    }

    public static function  all($condition = '1', $field = null)
    {
        $albums = parent::all($condition, $field);
        $full_dir_images = $_SERVER['DOCUMENT_ROOT'].ltrim( AlbumImages::IMAGE_DIR, DIRECTORY_SEPARATOR);

        // check covers and make thumbnails
        foreach ($albums as $album){
            $thumbnail_file = $_SERVER['DOCUMENT_ROOT']. AlbumImages::THUMBS_DIR.DIRECTORY_SEPARATOR. $album->cover;
            if ($album->cover){

                if (!file_exists($thumbnail_file )) {
                    AlbumImages::img_resize($full_dir_images.DIRECTORY_SEPARATOR.$album->cover, $thumbnail_file, AlbumImages::THUMB_X, AlbumImages::THUMB_Y);
                }
            }
        }
        return  $albums;
    }
}