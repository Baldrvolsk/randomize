<?php

namespace Baldr\Randomize\Prize\AdminInterface;

use Bitrix\Main\Localization\Loc;
use DigitalWand\AdminHelper\Helper\AdminInterface;
use DigitalWand\AdminHelper\Widget\CheckboxWidget;
use DigitalWand\AdminHelper\Widget\NumberWidget;
use DigitalWand\AdminHelper\Widget\OrmElementWidget;

Loc::loadMessages(__FILE__);

/**
 * Описание интерфейса (табок и полей) админки категорий новостей.
 *
 * {@inheritdoc}
 */
class PrizeLotteryAdminInterface extends AdminInterface
{
    /**
     * @inheritdoc
     */
    /*public function dependencies()
    {
        return array('\Baldr\Randomize\Lottery\AdminInterface\LotteryAdminInterface',
            '\Baldr\Randomize\Prize\AdminInterface\PrizeAdminInterface',
            '\Baldr\Randomize\Member\AdminInterface\MemberLotteryAdminInterface');
    }*/

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return array(
            'MAIN' => array(
                'NAME' => Loc::getMessage('DEMO_AH_NEWS_CATEGORIES_TAB_TITLE'),
                'FIELDS' => array(
                    'ID' => array(
                        'WIDGET' => new NumberWidget(),
                        'READONLY' => true,
                        'HIDE_WHEN_CREATE' => true,
                        'HEADER' => false,
                        'TITLE' => Loc::getMessage("BALDR_RANDOMIZE_LOTTERY_ID_TITLE")
                    ),
                    'LOTTERY_ID' => array(
                        'WIDGET' => new OrmElementWidget(),
                        'FILTER' => true,
                        'HELPER' => '\Baldr\Randomize\Lottery\AdminInterface\LotteryListHelper',
                        'REQUIRED' => true
                    ),
                    'PUBLISH_IN_RESULTS' => array(
                        'WIDGET' => new CheckboxWidget(),
                        'FIELD_TYPE' => 'boolean'
                    ),
                    'PRIZE_ID' => array(
                        'WIDGET' => new OrmElementWidget(),
                        'FILTER' => true,
                        'HELPER' => '\Baldr\Randomize\Prize\AdminInterface\PrizeListHelper',
                        'REQUIRED' => true
                    ),
                    'WINNER_ID' => array(
                        'WIDGET' => new OrmElementWidget(),
                        'FILTER' => true,
                        'HELPER' => '\Baldr\Randomize\Member\AdminInterface\CompanyLotteryListHelper',
                    ),
                    'SORT' => array(
                        'WIDGET' => new NumberWidget(),
                        'FILTER' => true,
                    ),
                )
            )
        );
    }

    /**
     * @inheritdoc
     */
    public function helpers()
    {
        return array(
            '\Baldr\Randomize\Prize\AdminInterface\PrizeLotteryEditHelper',
            '\Baldr\Randomize\Prize\AdminInterface\PrizeLotteryListHelper'
        );
    }
}