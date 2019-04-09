<?

use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if(!CModule::IncludeModule("baldr.randomize"))
	return;

Loc::loadMessages(__FILE__);

$arComponentParameters = array(
	"PARAMETERS"  =>  array(
		"LOTTERY_ID"  =>  Array(
			"PARENT" => "BASE",
			"NAME" => Loc::getMessage("BALDR_RANDOMIZE_DETAIL_PARAM_LOTTERY_ID"),
			"TYPE" => "STRING",
			"VALUES" => '0',
			"DEFAULT" => '0',
		),
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_GROUPS" => "Y",
        "DRAW_GROUP_PERMISSIONS" => $arParams["DRAW_GROUP_PERMISSIONS"],
	),
);
