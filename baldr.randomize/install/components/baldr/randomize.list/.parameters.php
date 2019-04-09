<?

use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if(!CModule::IncludeModule("baldr.randomize"))
	return;

Loc::loadMessages(__FILE__);

$arComponentParameters = array(
	"PARAMETERS"  =>  array(
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_GROUPS" => "Y",
	),
);