<?php

namespace Baldr\Randomize\Prize\AdminInterface;

use Bitrix\Main\Localization\Loc;
use DigitalWand\AdminHelper\Helper\AdminInterface;
use DigitalWand\AdminHelper\Widget\FileWidget;
use DigitalWand\AdminHelper\Widget\NumberWidget;
use DigitalWand\AdminHelper\Widget\StringWidget;
use DigitalWand\AdminHelper\Widget\VisualEditorWidget;

Loc::loadMessages(__FILE__);

/**
 * Описание интерфейса (табок и полей) админки категорий новостей.
 *
 * {@inheritdoc}
 */
class PrizeAdminInterface extends AdminInterface
{
    /**
     * @inheritdoc
     */
    public function dependencies()
    {
        return array('\Baldr\Randomize\Prize\AdminInterface\PrizeLotteryAdminInterface');
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return array(
            'MAIN' => array(
                'NAME' => Loc::getMessage("BALDR_RANDOMIZE_PRIZE_AI_TAB_TITLE"),
                'FIELDS' => array(
                    'ID' => array(
                        'WIDGET' => new NumberWidget(),
                        'READONLY' => true,
                        'FILTER' => true,
                        'HIDE_WHEN_CREATE' => true,
                        'TITLE' => Loc::getMessage("BALDR_RANDOMIZE_AI_PRIZE_ID_TITLE")
                    ),
                    'NAME' => array(
                        'WIDGET' => new StringWidget(),
                        'SIZE' => '80',
                        'FILTER' => '%',
                        'REQUIRED' => true,
                        'TITLE' => Loc::getMessage('BALDR_RANDOMIZE_AI_PRIZE_NAME_TITLE')
                    ),
                    'DESCRIPTION' => array(
                        'WIDGET' => new VisualEditorWidget(),
                        'TITLE' => Loc::getMessage('BALDR_RANDOMIZE_AI_PRIZE_DESCR_TITLE')
                    ),
                    'IMG' => array(
                        'WIDGET' => new FileWidget(),
                        'IMAGE' => true,
                        'TITLE' => Loc::getMessage('BALDR_RANDOMIZE_AI_PRIZE_IMG_TITLE')
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
            '\Baldr\Randomize\Prize\AdminInterface\PrizeEditHelper',
            '\Baldr\Randomize\Prize\AdminInterface\PrizeListHelper'
        );
    }
}