<?

use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

Loc::loadMessages(__FILE__);

$arComponentDescription = array(
    "NAME" => Loc::getMessage("C_BALDR_RANDOMIZE_DETAIL_COMPONENT_NAME"),
    "DESCRIPTION" => Loc::getMessage("C_BALDR_RANDOMIZE_DETAIL_COMPONENT_DESCR"),
    "PATH" => array(
        "ID" => "baldr",
        "CHILD" => array(
            "ID" => "randomize",
            "NAME" => Loc::getMessage("C_BALDR_RANDOMIZE_PARENT_GROUP_NAME"),
            "SORT" => 10,
            "CHILD" => array(
                "ID" => "randomize.complex",
            ),
        ),
    ),
);