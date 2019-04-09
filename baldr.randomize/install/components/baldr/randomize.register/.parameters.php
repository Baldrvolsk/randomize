<?

use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("baldr.randomize"))
	return;

Loc::loadMessages(__FILE__);

$site = ($_REQUEST["site"] <> ''? $_REQUEST["site"] : ($_REQUEST["src_site"] <> ''? $_REQUEST["src_site"] : false));
$arFilter = Array("TYPE_ID" => "OL_REGISTER_FORM", "ACTIVE" => "Y");
if($site !== false)
	$arFilter["LID"] = $site;

$arEvent = Array();
$dbType = CEventMessage::GetList($by="ID", $order="DESC", $arFilter);
while($arType = $dbType->GetNext())
	$arEvent[$arType["ID"]] = "[".$arType["ID"]."] ".$arType["SUBJECT"];

$arComponentParameters = array(
	"PARAMETERS"  =>  array(
		"LOTTERY_ID"  =>  Array(
			"PARENT" => "BASE",
			"NAME" => Loc::getMessage("BALDR_RANDOMIZE_DETAIL_PARAM_LOTTERY_ID"),
			"TYPE" => "STRING",
			"VALUES" => '0',
			"DEFAULT" => '0',
		),
		"USE_CAPTCHA" => Array(
			"NAME" => Loc::getMessage("MFP_CAPTCHA"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
			"PARENT" => "BASE",
		),
		"OK_TEXT" => Array(
			"NAME" => Loc::getMessage("MFP_OK_MESSAGE"),
			"TYPE" => "STRING",
			"DEFAULT" => Loc::getMessage("MFP_OK_TEXT"),
			"PARENT" => "BASE",
		),
		"EMAIL_TO" => Array(
			"NAME" => Loc::getMessage("MFP_EMAIL_TO"),
			"TYPE" => "STRING",
			"DEFAULT" => htmlspecialcharsbx(COption::GetOptionString("main", "email_from")),
			"PARENT" => "BASE",
		)
	),
);