<?php

namespace Baldr\Randomize\Lottery;

use Baldr\Randomize\Member\CompanyLotteryTable;
use Baldr\Randomize\Prize\PrizeLotteryTable;
use Bitrix\Main\Entity;
use Bitrix\Main\ORM\Fields\Relations\OneToMany;
use Bitrix\Main\Type\DateTime;

/**
 * Class LotteryTable
 * Модель розыгрыша
 * @package Baldr\Randomize\Lottery
 */
class LotteryTable extends Entity\DataManager
{
    /**
     * @inheritdoc
     */
    public static function getTableName()
    {
        return 'randomize_lottery';
    }

    /**
     * @inheritdoc
     */
    public static function getMap()
    {
        return array(
            //ID
            new Entity\IntegerField('ID', array(
                'primary' => true,
                'autocomplete' => true
            )),
            //Название розыгрыша
            new Entity\StringField('TITLE', array(
                'required' => true,
            )),
            //Описание розыгрыша
            new Entity\TextField('DESCRIPTION'),
            new Entity\StringField('DESCRIPTION_TEXT_TYPE'),
            //Дата и время начала регистрации участников
            new Entity\DatetimeField('TIME_REG_START', array(
                'required' => true
            )),
            //Дата и время конца регистрации участников
            new Entity\DatetimeField('TIME_REG_END', array(
                'required' => true
            )),
            //Дата и время старта розыгрыша
            new Entity\DatetimeField('TIME_DRAW_START', array(
                'required' => true
            )),
            //Дата и время конца розыгрыша
            new Entity\DatetimeField('TIME_DRAW_END', array(
                'required' => true
            )),
            //Статус розыгрыша
            new Entity\BooleanField('STATUS', array(
                'default_value' => false
            )),
            //Ссылка на видео
            new Entity\StringField('VIDEO_LINK'),
            //Дата и время создания розыгрыша
            new Entity\DatetimeField('DATE_CREATE', array(
                'required' => true,
                'default_value' => new DateTime()
            )),
            //Пользователь создавший розыгрыша
            new Entity\IntegerField('CREATED_BY', array(
                'required' => true,
                'default_value' => static::getUserId()
            )),
            (new OneToMany('PRIZE_ITEMS', PrizeLotteryTable::class, 'LOTTERY')),
            (new OneToMany('MEMBERS_ITEMS', CompanyLotteryTable::class, 'LOTTERY'))
        );
    }

    /**
     * Возвращает идентификатор пользователя.
     *
     * @return int|null
     */
    public static function getUserId()
    {
        global $USER;

        return $USER->GetID();
    }

    public static function getFilePath()
    {
        return __FILE__;
    }
}