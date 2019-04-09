<?php

namespace Baldr\Randomize\Lottery\AdminInterface;

use Bitrix\Main\Localization\Loc;
use DigitalWand\AdminHelper\Helper\AdminInterface;
use DigitalWand\AdminHelper\Widget\CheckboxWidget;
use DigitalWand\AdminHelper\Widget\ComboBoxWidget;
use DigitalWand\AdminHelper\Widget\DateTimeWidget;
use DigitalWand\AdminHelper\Widget\NumberWidget;
use DigitalWand\AdminHelper\Widget\StringWidget;
use DigitalWand\AdminHelper\Widget\UserWidget;
use DigitalWand\AdminHelper\Widget\VisualEditorWidget;

Loc::loadMessages(__FILE__);

/**
 * Описание интерфейса (табок и полей) админки категорий новостей.
 *
 * {@inheritdoc}
 */
class LotteryAdminInterface extends AdminInterface
{
    /**
     * @inheritdoc
     */
    public function dependencies()
    {
        return array('\Baldr\Randomize\Prize\AdminInterface\PrizeLotteryAdminInterface',
            '\Baldr\Randomize\Member\AdminInterface\CompanyLotteryAdminInterface');
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return array(
            'MAIN' => array(
                'NAME' => Loc::getMessage('BALDR_RANDOMIZE_LOTTERY_TAB_TITLE'),
                'FIELDS' => array(
                    'ID' => array(
                        'WIDGET' => new NumberWidget(),
                        'READONLY' => true,
                        'FILTER' => true,
                        'HIDE_WHEN_CREATE' => true,
                        'TITLE' => Loc::getMessage("BALDR_RANDOMIZE_LOTTERY_ID_TITLE")
                    ),
                    //Статус розыгрыша
                    'STATUS' => array(
                        'WIDGET' => new CheckboxWidget(),
                        'FIELD_TYPE' => 'boolean',
                        'TITLE' => Loc::getMessage("BALDR_RANDOMIZE_LOTTERY_STATUS_TITLE")
                    ),
                    'TITLE' => array(
                        'WIDGET' => new StringWidget(),
                        'SIZE' => '80',
                        'FILTER' => '%',
                        'REQUIRED' => true,
                        'TITLE' => Loc::getMessage("BALDR_RANDOMIZE_LOTTERY_NAME_TITLE")
                    ),
                    'DESCRIPTION' => array(
                        'WIDGET' => new VisualEditorWidget(),
                        'TITLE' => Loc::getMessage('BALDR_RANDOMIZE_AI_PRIZE_DESCR_TITLE')
                    ),
                    'VIDEO_LINK' => array(
                        'WIDGET' => new StringWidget(),
                        'SIZE' => '80',
                        /*'SECTION_LINK' => true,*/
                        'TITLE' => Loc::getMessage("BALDR_RANDOMIZE_AI_LOTTERY_VIDEO_LINK_TITLE")
                    ),
                    //Дата и время начала регистрации участников
                    'TIME_REG_START' => array(
                        'WIDGET' => new DateTimeWidget(),
                        'REQUIRED' => true,
                        'TITLE' => Loc::getMessage("BALDR_RANDOMIZE_LOTTERY_TRS_TITLE")
                    ),
                    //Дата и время конца регистрации участников
                    'TIME_REG_END' => array(
                        'WIDGET' => new DateTimeWidget(),
                        'REQUIRED' => true,
                        'TITLE' => Loc::getMessage("BALDR_RANDOMIZE_LOTTERY_TRE_TITLE")
                    ),
                    //Дата и время старта розыгрыша
                    'TIME_DRAW_START' => array(
                        'WIDGET' => new DateTimeWidget(),
                        'REQUIRED' => true,
                        'TITLE' => Loc::getMessage("BALDR_RANDOMIZE_LOTTERY_TDS_TITLE")
                    ),
                    //Дата и время конца розыгрыша
                    'TIME_DRAW_END' => array(
                        'WIDGET' => new DateTimeWidget(),
                        'REQUIRED' => true,
                        'TITLE' => Loc::getMessage("BALDR_RANDOMIZE_LOTTERY_TDE_TITLE")
                    ),
                    'DATE_CREATE' => array(
                        'WIDGET' => new DateTimeWidget(),
                        'READONLY' => true,
                        'HIDE_WHEN_CREATE' => true,
                        'HEADER' => false,
                        'TITLE' => Loc::getMessage("BALDR_RANDOMIZE_LOTTERY_DC_TITLE")
                    ),
                    'CREATED_BY' => array(
                        'WIDGET' => new UserWidget(),
                        'READONLY' => true,
                        'HIDE_WHEN_CREATE' => true,
                        'HEADER' => false,
                        'TITLE' => Loc::getMessage("BALDR_RANDOMIZE_LOTTERY_UC_TITLE")
                    )
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
            '\Baldr\Randomize\Lottery\AdminInterface\LotteryEditHelper',
            '\Baldr\Randomize\Lottery\AdminInterface\LotteryListHelper'
        );
    }
}