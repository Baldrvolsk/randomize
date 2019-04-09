<?php
$APPLICATION->IncludeComponent(
    "bitrix:news.detail",
    $templateName,
    Array(
        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "ELEMENT_ID" => $arParams["ELEMENT_ID"],
        "SET_TITLE" => "N",
        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
        "CACHE_TIME" => $arParams["CACHE_TIME"],
        "CACHE_GROUPS" => "Y",
        "INCLUDE_IBLOCK_INTO_CHAIN" => $arResult["INCLUDE_IBLOCK_INTO_CHAIN"],
        "ADD_ELEMENT_CHAIN" => $arResult["ADD_ELEMENT_CHAIN"],
        "FOLDER" => $arResult["FOLDER"],
        "URL_TEMPLATES" => $arResult["URL_TEMPLATES"],
        "VARIABLES" => $arResult["VARIABLES"],
    ),
    $component
);