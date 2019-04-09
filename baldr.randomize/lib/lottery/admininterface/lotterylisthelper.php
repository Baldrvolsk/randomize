<?php

namespace Baldr\Randomize\Lottery\AdminInterface;

use Bitrix\Main\Localization\Loc;
use DigitalWand\AdminHelper\Helper\AdminListHelper;

class LotteryListHelper extends AdminListHelper
{
	protected static $model = 'Baldr\Randomize\Lottery\LotteryTable';

    /**
     * @inheritdoc
     */
    public function setTitle($title = "")
    {
        $title = Loc::getMessage("BALDR_RANDOMIZE_LOT_AI_LIST_TITLE");
        parent::setTitle($title);
    }
}