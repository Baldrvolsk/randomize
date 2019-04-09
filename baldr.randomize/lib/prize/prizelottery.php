<?php


namespace Baldr\Randomize\Prize;

use \Bitrix\Main\Entity;
use \Bitrix\Main\Type;

class PrizeLotteryTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'randomize_prize_lottery';
    }

    public static function getMap()
    {
        return array(
            //ID
            new Entity\IntegerField('ID', array(
                'primary' => true,
                'autocomplete' => true
            )),
            new Entity\IntegerField('LOTTERY_ID'),
            new Entity\ReferenceField(
                'LOTTERY',
                '\Baldr\Randomize\Lottery\LotteryTable',
                array('=this.LOTTERY_ID' => 'ref.ID')
            ),
            new Entity\BooleanField('PUBLISH_IN_RESULTS', array(
                'default' => 1
            )),
            new Entity\IntegerField('PRIZE_ID'),
            new Entity\ReferenceField(
                'PRIZE',
                '\Baldr\Randomize\Prize\PrizeTable',
                array('=this.PRIZE_ID' => 'ref.ID')
            ),
            new Entity\IntegerField('WINNER_ID'),
            new Entity\ReferenceField(
                'WINNER',
                '\Baldr\Randomize\Member\CompanyLotteryTable',
                array('=this.WINNER_ID' => 'ref.ID')
            ),
            new Entity\IntegerField('SORT', array(
                'default' => 1
            )),

        );
    }
}