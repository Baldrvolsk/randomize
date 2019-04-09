<?php

namespace Baldr\Randomize\Lottery\AdminInterface;

use Bitrix\Main\Localization\Loc;
use DigitalWand\AdminHelper\Helper\AdminEditHelper;

Loc::loadMessages(__FILE__);

class LotteryEditHelper extends AdminEditHelper
{
    protected static $model = 'Baldr\Randomize\Lottery\LotteryTable';

    /**
     * @inheritdoc
     */
    public function setTitle($title = "")
    {
        if (!empty($this->data)) {
            $title = Loc::getMessage('BALDR_RANDOMIZE_LOT_AI_EDIT_TITLE', array('#ID#' => $this->data[$this->pk()]));
        }
        else {
            $title = Loc::getMessage('BALDR_RANDOMIZE_LOT_AI_NEW_TITLE');
        }

        parent::setTitle($title);
    }
}