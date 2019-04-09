<?php

namespace Baldr\Randomize\Prize\AdminInterface;

use Bitrix\Main\Localization\Loc;
use DigitalWand\AdminHelper\Helper\AdminEditHelper;

Loc::loadMessages(__FILE__);

class PrizeEditHelper extends AdminEditHelper
{
    protected static $model = "Baldr\Randomize\Prize\PrizeTable";

    /**
     * @inheritdoc
     */
    public function setTitle($title)
    {
        if (!empty($this->data)) {
            $title = Loc::getMessage("BALDR_RANDOMIZE_PRIZE_AI_EDIT_TITLE", array("#ID#" => $this->data[$this->pk()]));
        }
        else {
            $title = Loc::getMessage("BALDR_RANDOMIZE_PRIZE_AI_NEW_TITLE");
        }

        parent::setTitle($title);
    }
}