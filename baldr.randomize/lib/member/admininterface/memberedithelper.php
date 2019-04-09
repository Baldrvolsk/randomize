<?php

namespace Baldr\Randomize\Member\AdminInterface;

use Bitrix\Main\Localization\Loc;
use DigitalWand\AdminHelper\Helper\AdminEditHelper;

Loc::loadMessages(__FILE__);

class MemberEditHelper extends AdminEditHelper
{
    protected static $model = '\Baldr\Randomize\Member\MemberTable';

    /**
     * @inheritdoc
     */
    public function setTitle($title)
    {
        if (!empty($this->data)) {
            $title = Loc::getMessage('DEMO_AH_NEWS_EDIT_TITLE', array('#ID#' => $this->data[$this->pk()]));
        }
        else {
            $title = Loc::getMessage('DEMO_AH_NEWS_NEW_TITLE');
        }

        parent::setTitle($title);
    }
}