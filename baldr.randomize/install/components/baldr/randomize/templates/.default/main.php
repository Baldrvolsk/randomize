<?php

use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

Loc::loadMessages(__FILE__);

if ($arParams['MAIN_TYPE'] === 'LAST_LOTTERY') {
    $APPLICATION->IncludeComponent(
        "baldr:randomize.detail",
        $templateName,
        Array(
            "LOTTERY_ID" => 0,
            "RULES_URL"	=>	$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["rules"],
            "LIST_URL"	=>	$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["list"],
            "FOLDER" => $arResult["FOLDER"],
            "URL_TEMPLATES" => $arResult["URL_TEMPLATES"],
            "VARIABLES" => $arResult["VARIABLES"],
            "DRAW_GROUP_PERMISSIONS" => $arParams["DRAW_GROUP_PERMISSIONS"],
            "DEMO_DRAW" => $arParams["DEMO_DRAW"],
            "CACHE_TYPE" => 'N',
        ),
        $component
    );
} elseif ($arParams['MAIN_TYPE'] === 'LIST_LOTTERY') {
    $APPLICATION->IncludeComponent(
        "baldr:randomize.list",
        $templateName,
        Array(
            "RULES_URL"	=>	$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["rules"],
            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
            "CACHE_TIME" => $arParams["CACHE_TIME"],
            "CACHE_GROUPS" => "Y",
        ),
        $component
    );
} else {
    echo Loc::getMessage("T_BALDR_RANDOMIZE_COMPLEX_MAIN_NO_SELECT_TYPE");
}