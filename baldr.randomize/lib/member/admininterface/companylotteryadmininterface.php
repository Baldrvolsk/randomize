<?php

namespace Baldr\Randomize\Member\AdminInterface;

use Bitrix\Main\Localization\Loc;
use DigitalWand\AdminHelper\Helper\AdminInterface;
use DigitalWand\AdminHelper\Widget\ComboBoxWidget;
use DigitalWand\AdminHelper\Widget\NumberWidget;
use DigitalWand\AdminHelper\Widget\OrmElementWidget;
use DigitalWand\AdminHelper\Widget\StringWidget;


Loc::loadMessages(__FILE__);

/**
 * Описание интерфейса (табок и полей) админки категорий новостей.
 *
 * {@inheritdoc}
 */
class CompanyLotteryAdminInterface extends AdminInterface
{
    /**
     * @inheritdoc
     */
    /*public function dependencies()
    {
        return array('\Baldr\Randomize\Lottery\AdminInterface\LotteryAdminInterface',
            '\Baldr\Randomize\Member\AdminInterface\CompanyAdminInterface');
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
                        'READONLY' => false,
                        'HIDE_WHEN_CREATE' => true,
                        'HEADER' => true,
                        'TITLE' => Loc::getMessage("BALDR_RANDOMIZE_LOTTERY_ID_TITLE")
                    ),
                    'LOTTERY_ID' => array(
                        'WIDGET' => new OrmElementWidget(),
                        'HELPER' => '\Baldr\Randomize\Lottery\AdminInterface\LotteryListHelper',
                        'EDIT_IN_LIST' => true,
                        'READONLY' => false,
                        'TITLE' => "Розыгрыш"

                    ),
                    'COMPANY_ID' => array(
                        'WIDGET' => new OrmElementWidget(),
                        'HELPER' => '\Baldr\Randomize\Member\AdminInterface\CompanyListHelper',
                        'EDIT_IN_LIST' => true,
                        'READONLY' => false,
                        'TITLE' => "Компания"
                    ),
                    'DRAW_ALLOWED' => array(
                        'WIDGET' => new ComboBoxWidget(),
                        'VARIANTS' => array(
                            0 => "[0] Заявка подана",
                            1 => '[1] Заявка одобрена',
                            2 => '[2] Зявка отклонена'
                        ),
                        'EDIT_IN_LIST' => true,
                        'READONLY' => false,
                        'TITLE' => "Статус участника"
                    ),
                    'REASON' => array(
                        'WIDGET' => new StringWidget(),
                        'SIZE' => 80,
                        'EDIT_IN_LIST' => true,
                        'READONLY' => false,
                        'TITLE' => "Причина отклонения заявки"
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
            '\Baldr\Randomize\Member\AdminInterface\CompanyLotteryEditHelper',
            '\Baldr\Randomize\Member\AdminInterface\CompanyLotteryListHelper'
        );
    }
}