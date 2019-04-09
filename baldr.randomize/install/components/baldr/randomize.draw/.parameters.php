<?

use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

Loc::loadMessages(__FILE__);

if(!CModule::IncludeModule("baldr.randomize"))
	return;

$arComponentParameters = array(
	"PARAMETERS"  =>  array(
		"LOTTERY_ID"  =>  Array(
			"PARENT" => "BASE",
			"NAME" => Loc::getMessage("BALDR_RANDOMIZE_DETAIL_PARAM_LOTTERY_ID"),
			"TYPE" => "STRING",
			"VALUES" => '0',
			"DEFAULT" => '0',
		),
		"DEMO_DRAW" => array(
			"PARENT" => "BASE",
			"NAME" => "Демо розыгрыш",
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
		"DRAW_GROUP_PERMISSIONS" => Array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => Loc::getMessage("C_BALDR_RANDOMIZE_CC_DESC_GROUP_PERMISSIONS"),
			"TYPE" => "LIST",
			"VALUES" => $arUGroupsEx,
			"DEFAULT" => Array(1),
			"MULTIPLE" => "Y",
		),
        "FOLDER" => Array(
            "PARENT" => "BASE",
            "NAME" => Loc::getMessage("C_BALDR_RANDOMIZE_DRAW_PARAM_FOLDER"),
            "TYPE" => "STRING",
        )
	),
);