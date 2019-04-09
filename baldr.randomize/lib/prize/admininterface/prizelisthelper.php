<?php

namespace Baldr\Randomize\Prize\AdminInterface;

use Bitrix\Main\Localization\Loc;
use DigitalWand\AdminHelper\Helper\AdminListHelper;

Loc::loadMessages(__FILE__);

class PrizeListHelper extends AdminListHelper
{
	protected static $model = "Baldr\Randomize\Prize\PrizeTable";
    /**
     * @inheritdoc
     */
    public function setTitle($title)
    {
        parent::setTitle(Loc::getMessage("BALDR_RANDOMIZE_PRIZE_AI_LIST_TITLE"));
    }
}