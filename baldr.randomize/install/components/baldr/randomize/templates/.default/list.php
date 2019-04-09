<?php

use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

Loc::loadMessages(__FILE__);

$APPLICATION->IncludeComponent(
    "baldr:randomize.list",
    $templateName,
    Array(
        "RULES_URL"	=>	$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["rules"],
        "LIST_URL"	=>	$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["list"],
        "FOLDER" => $arResult["FOLDER"],
        "URL_TEMPLATES" => $arResult["URL_TEMPLATES"],
        "VARIABLES" => $arResult["VARIABLES"],
        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
        "CACHE_TIME" => $arParams["CACHE_TIME"],
        "CACHE_GROUPS" => "Y",
    ),
    $component
);