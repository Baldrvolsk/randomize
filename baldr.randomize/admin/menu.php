<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

use Baldr\Randomize\Lottery\AdminInterface\LotteryEditHelper;
use Baldr\Randomize\Lottery\AdminInterface\LotteryListHelper;

use Baldr\Randomize\Prize\AdminInterface\PrizeEditHelper;
use Baldr\Randomize\Prize\AdminInterface\PrizeListHelper;
use Baldr\Randomize\Prize\AdminInterface\PrizeLotteryEditHelper;
use Baldr\Randomize\Prize\AdminInterface\PrizeLotteryListHelper;

use Baldr\Randomize\Member\AdminInterface\CompanyEditHelper;
use Baldr\Randomize\Member\AdminInterface\CompanyListHelper;
use Baldr\Randomize\Member\AdminInterface\MemberEditHelper;
use Baldr\Randomize\Member\AdminInterface\MemberListHelper;
use Baldr\Randomize\Member\AdminInterface\CompanyLotteryEditHelper;
use Baldr\Randomize\Member\AdminInterface\CompanyLotteryListHelper;

if (!Loader::includeModule('digitalwand.admin_helper') || !Loader::includeModule('baldr.randomize')) return;

Loc::loadMessages(__FILE__);

$module_id = "baldr.randomize";
if($APPLICATION->GetGroupRight($module_id)>"M") // проверка уровня доступа к модулю
{
    // сформируем верхний пункт меню
    $aMenu = array(
        "parent_menu" => "global_menu_services", // поместим в раздел "Сервис"
        "section" => "baldr.randomize",
        "sort"        => 2000,                    // вес пункта меню
        "text"        => Loc::GetMessage("BALDR_RANDOMIZE_MENU_MAIN"),       // текст пункта меню
        "icon"        => "rand_menu_icon", // малая иконка
        "page_icon"   => "rand_page_icon", // большая иконка
        "items_id"    => "menu_randomize",  // идентификатор ветви
        'more_url' => array(
            LotteryEditHelper::getUrl(),
            PrizeEditHelper::getUrl(),
            PrizeListHelper::getUrl(),
            PrizeLotteryEditHelper::getUrl(),
            PrizeLotteryListHelper::getUrl(),
            CompanyLotteryListHelper::getUrl(),
            CompanyLotteryEditHelper::getUrl(),
            MemberEditHelper::getUrl(),
            MemberListHelper::getUrl(),
            CompanyEditHelper::getUrl(),
            CompanyListHelper::getUrl(),
        ),
        "items" => array(          // остальные уровни меню
            array(
                "text" => Loc::GetMessage("BALDR_RANDOMIZE_MENU_LOTTERY"),
                'more_url' => array(
                    LotteryListHelper::getUrl(),
                    LotteryEditHelper::getUrl(),
                    PrizeLotteryListHelper::getUrl(),
                    PrizeLotteryEditHelper::getUrl(),
                    CompanyLotteryListHelper::getUrl(),
                    CompanyLotteryEditHelper::getUrl()
                ),
                "items_id" => "menu_randomize_lottery",
                "items" => array(
                    array(
                        "text" => Loc::GetMessage("BALDR_RANDOMIZE_MENU_LOTTERY_TITLE"),
                        'url' => LotteryListHelper::getUrl(),
                        'more_url' => array(
                            LotteryEditHelper::getUrl()
                        )
                    ),
                    array(
                        "text" => Loc::GetMessage("BALDR_RANDOMIZE_MENU_PR_LOT_TITLE"),
                        'url' => PrizeLotteryListHelper::getUrl(),
                        'more_url' => array(
                            PrizeLotteryEditHelper::getUrl()
                        )
                    ),
                    array(
                        "text" => Loc::GetMessage("BALDR_RANDOMIZE_MENU_MEM_LOT_TITLE"),
                        'url' => CompanyLotteryListHelper::getUrl(),
                        'more_url' => array(
                            CompanyLotteryEditHelper::getUrl()
                        )
                    )
                )
            ),
            array(
                "text" => Loc::GetMessage("BALDR_RANDOMIZE_MENU_PRIZE"),
                'url' => PrizeListHelper::getUrl(),
                'more_url' => array(
                    PrizeEditHelper::getUrl()
                )
            ),
            array(
                "text" => Loc::GetMessage("BALDR_RANDOMIZE_MENU_MEMBER_TITLE"),
                'more_url' => array(
                    MemberListHelper::getUrl(),
                    MemberEditHelper::getUrl(),
                    CompanyListHelper::getUrl(),
                    CompanyEditHelper::getUrl()
                ),
                "items_id" => "menu_randomize_member",
                "items" => array(
                    array(
                        "text" => Loc::getMessage("BALDR_RANDOMIZE_MENU_COMPANY_TITLE"),
                        'url' => CompanyListHelper::getUrl(),
                        'more_url' => array(
                            CompanyEditHelper::getUrl()
                        )
                    ),
                    array(
                        "text" => Loc::GetMessage("BALDR_RANDOMIZE_MENU_MEMBER"),
                        'url' => MemberListHelper::getUrl(),
                        'more_url' => array(
                            MemberEditHelper::getUrl()
                        )
                    ),

                )
            )
        )
    );
    // вернем полученный список
    return $aMenu;
}
// если нет доступа, вернем false
return false;