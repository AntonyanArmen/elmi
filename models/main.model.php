<?php

class Main extends Model
{
    public static $main_page_title = "Аквацентр «Элми».Бассейн для детей в Ростове-на-Дону";
    public static $cave_page_title = "Соляная пещера в Ростове-на-Дону в аквацентре «Элми»";
    public static $pool_page_title = "Детский бассейн в Ростове-на-Дону. Занятия грудничковым плаванием";

    protected static $behaviours = [];
    protected static $fields = [];
    protected static $field_types = [];

    public static function className()
    {
        return 'Main';
    }

    public static function tableName()
    {
        return 'lst_Main';
    }

    public static function field_labels()
    {
        return [
            'id' => 'Идентификатор',
            'name' => 'Наименование',
        ];
    }
}