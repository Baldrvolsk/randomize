<?php

use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

Loc::loadMessages(__FILE__);

$APPLICATION->IncludeComponent(
    "baldr:randomize.detail",
    $templateName,
    Array(
        "LOTTERY_ID" => $arResult["VARIABLES"]["LOTTERY_ID"],
        "RULES_URL"	=>	$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["rules"],
        "LIST_URL"	=>	$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["list"],
        "FOLDER" => $arResult["FOLDER"],
        "URL_TEMPLATES" => $arResult["URL_TEMPLATES"],
        "VARIABLES" => $arResult["VARIABLES"],
        "DRAW_GROUP_PERMISSIONS" =>$arParams["DRAW_GROUP_PERMISSIONS"],
        "DEMO_DRAW" => $arParams["DEMO_DRAW"],
        "CACHE_TYPE" => 'N',
    ),
    $component
);