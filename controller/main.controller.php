<?php
include_once 'system/BaseController.php';

class MainController extends BaseController
{
    public function index()
    {
        return $this->render("waterpool/main",[
                "title" => Main::$main_page_title,
                "apply_js"      => "js/man.js"
            ]
        );
    }

    public function cave()
    {
        return $this->render("waterpool/cave",[
                "title"   => Main::$cave_page_title,
                "service_subpage" => true,
                "not_main_page" => true
            ]
        );
    }

    public function waterpool()
    {
        return $this->render("waterpool/waterpool",[
                "title"   => Main::$pool_page_title,
                "service_subpage" => true,
                "not_main_page" => true
            ]
        );
    }
}