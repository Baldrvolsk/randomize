<?php

namespace Baldr\Randomize\Member\AdminInterface;

use Bitrix\Main\Localization\Loc;
use DigitalWand\AdminHelper\Helper\AdminInterface;
use DigitalWand\AdminHelper\Widget\NumberWidget;
use DigitalWand\AdminHelper\Widget\OrmElementWidget;
use DigitalWand\AdminHelper\Widget\StringWidget;

Loc::loadMessages(__FILE__);

/**
 * Описание интерфейса (табок и полей) админки категорий новостей.
 *
 * {@inheritdoc}
 */
class CompanyAdminInterface extends AdminInterface
{
    /**
     * @inheritdoc
     */
    /*public function dependencies()
    {
        return array('\Baldr\Randomize\Member\AdminInterface\MemberAdminInterface');
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
                        'FILTER' => true,
                        'HIDE_WHEN_CREATE' => true
                    ),
                    //Название
                    'COMPANY_NAME' => array(
                        'WIDGET' => new StringWidget(),
                        'SIZE' => '80',
                        'FILTER' => '%',
                        'REQUIRED' => true
                    ),
                    //ID уникальной кампании
                    'UNIC_ID' => array(
                        'WIDGET' => new OrmElementWidget(),
                        'HELPER' => '\Baldr\Randomize\Member\AdminInterface\CompanyListHelper'
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
            '\Baldr\Randomize\Member\AdminInterface\CompanyEditHelper',
            '\Baldr\Randomize\Member\AdminInterface\CompanyListHelper'
        );
    }
}