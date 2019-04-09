<?php


namespace Baldr\Randomize\Prize;

use \Bitrix\Main\Entity;
use \Bitrix\Main\Type;

class PrizeTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'randomize_prize';
    }

    public static function getMap()
    {
        return array(
            //ID
            new Entity\IntegerField('ID', array(
                'primary' => true,
                'autocomplete' => true
            )),
            //Название приза
            new Entity\StringField('NAME', array(
                'required' => true,
            )),
            //Описание приза
            new Entity\TextField('DESCRIPTION', array(
                'required' => true,
            )),
            new Entity\StringField('DESCRIPTION_TEXT_TYPE'),
            //Изображение приза
            new Entity\IntegerField('IMG', array(
                'required' => true,
            ))
        );
    }
}