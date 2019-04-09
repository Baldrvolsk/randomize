<?php

namespace Baldr\Randomize\Lottery;

use Bitrix\Main\Diag\Debug;
use Bitrix\Main\Type\DateTime;

class Agent
{
    public static function run()
    {
        $time = DateTime::createFromTimestamp(time());
        Debug::dumpToFile($time, 'last run agent');
    }
}