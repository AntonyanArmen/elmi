<?php
include_once 'system/BaseController.php';

class GalleryController extends BaseController
{
    public function index()
    {
        //Gallery::all();

        return $this->render("gallery/list",[
                "title" => Gallery::$list_page_title,
                "images" => Gallery::all(),
                "not_main_page" => true
            ]
        );

    }
}