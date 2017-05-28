<?php
include_once 'system/BaseController.php';

class GalleryController extends BaseController
{
    public function index()
    {
        return $this->albums_list();
    }

    public function albums_list()
    {
        return $this->render("gallery/album_all",[
                "title"         => Gallery::$list_page_title,
                "albums"        => Album::all(),
                "not_main_page" => true,
                "apply_css"     => "css/gallery.css",
                "gallery" => true

            ]
        );
    }

    public function view()
    {
        $album = SanitizeHelper::GET_value("album");
        $images = $album ?  AlbumImages::all([["albumId" => $album]]): [];

        return $this->render("gallery/list",[
                "title"         => Gallery::$list_page_title,
                "images"        => $images,
                "apply_css"     => "css/gallery.css",
                "apply_js"      => "js/gallery.js",
                "not_main_page" => true,
                "gallery" => true
            ]
        );
    }

    public function album()
    {
        return $this->render("gallery/list",[
                "title"         => Gallery::$list_page_title,
                "apply_css"     => "css/gallery.css",
                "apply_js"      => "js/gallery.js",
                "images"        => Gallery::all(),
                "not_main_page" => true
            ]
        );
    }
}