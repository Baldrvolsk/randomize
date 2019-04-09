<?php

namespace Baldr\Randomize\Member\AdminInterface;

use Bitrix\Main\Localization\Loc;
use DigitalWand\AdminHelper\Helper\AdminInterface;
use DigitalWand\AdminHelper\Widget\CheckboxWidget;
use DigitalWand\AdminHelper\Widget\NumberWidget;
use DigitalWand\AdminHelper\Widget\OrmElementWidget;
use DigitalWand\AdminHelper\Widget\StringWidget;

Loc::loadMessages(__FILE__);

/**
 * Описание интерфейса (табок и полей) админки новостей.
 *
 * {@inheritdoc}
 */
class MemberAdminInterface extends AdminInterface
{
    /**
     * @inheritdoc
     */
    public function dependencies()
    {
        return array('\Baldr\Randomize\Member\AdminInterface\CompanyAdminInterface',
            /*'\Baldr\Randomize\Member\AdminInterface\MemberLotteryAdminInterface'*/);
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return array(
            'MAIN' => array(
                'NAME' => Loc::getMessage('DEMO_AH_NEWS_TAB_TITLE'),
                'FIELDS' => array(
                    'ID' => array(
                        'WIDGET' => new NumberWidget(),
                        'READONLY' => true,
                        'FILTER' => true,
                        'HIDE_WHEN_CREATE' => true,
                        'TITLE' => Loc::getMessage('DEMO_AH_NEWS_ID_TITLE')
                    ),
                    'COMPANY_ID' => array(
                        'WIDGET' => new OrmElementWidget(),
                        'FILTER' => true,
                        'HELPER' => '\Baldr\Randomize\Member\AdminInterface\CompanyListHelper',
                        'REQUIRED' => true
                    ),
                    'ACTIVE_MEMBER' => array(
                        'WIDGET' => new CheckboxWidget(),
                        'FIELD_TYPE' => 'integer'
                    ),
                    'FULL_NAME' => array(
                        'WIDGET' => new StringWidget(),
                        'SIZE' => 80,
                        'FILTER' => '%',
                        'REQUIRED' => true
                    ),
                    'PHONE' => array(
                        'WIDGET' => new StringWidget(),
                        'SIZE' => 15,
                        'FILTER' => '%',
                        'REQUIRED' => true
                    ),
                    'EMAIL' => array(
                        'WIDGET' => new StringWidget(),
                        'SIZE' => 80,
                        'FILTER' => '%',
                        'REQUIRED' => true
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
            '\Baldr\Randomize\Member\AdminInterface\MemberListHelper',
            '\Baldr\Randomize\Member\AdminInterface\MemberEditHelper'
        );
    }
}