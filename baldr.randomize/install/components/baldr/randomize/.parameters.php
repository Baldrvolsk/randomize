<?

use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

Loc::loadMessages(__FILE__);

if (!CModule::IncludeModule("baldr.randomize") || !CModule::IncludeModule("iblock"))
    return;
// информационные блоки
$arTypes = CIBlockParameters::GetIBlockTypes();

$arIBlocks=array();
$db_iblock = CIBlock::GetList(
    array("SORT"=>"ASC"),
    array("SITE_ID"=>$_REQUEST["site"], "TYPE" => ($arCurrentValues["IBLOCK_TYPE"]!="-"?$arCurrentValues["IBLOCK_TYPE"]:""))
);
while($arRes = $db_iblock->Fetch())
    $arIBlocks[$arRes["ID"]] = "[".$arRes["ID"]."] ".$arRes["NAME"];

// почтовые шаблоны
$site = ($_REQUEST["site"] <> ''? $_REQUEST["site"] : ($_REQUEST["src_site"] <> ''? $_REQUEST["src_site"] : false));
$arFilter = Array("TYPE_ID" => "OL_REGISTER_FORM", "ACTIVE" => "Y");
if($site !== false)
    $arFilter["LID"] = $site;

$arEvent = Array();
$dbType = CEventMessage::GetList($by="ID", $order="DESC", $arFilter);
while($arType = $dbType->GetNext())
    $arEvent[$arType["ID"]] = "[".$arType["ID"]."] ".$arType["SUBJECT"];

$arUGroupsEx = Array();
$dbUGroups = CGroup::GetList($by = "c_sort", $order = "asc");
while($arUGroups = $dbUGroups -> Fetch())
{
    $arUGroupsEx[$arUGroups["ID"]] = $arUGroups["NAME"];
}

// конфиг
$arComponentParameters = array(
    "GROUPS" => array(
        "RULES_PAGE" => array(
            "SORT" => 140,
            "NAME" => Loc::getMessage("C_BALDR_RANDOMIZE_CC_GROUP_RULES_PAGE"),
        ),
        "MAIL_CONFIG" => array(
            "SORT" => 150,
            "NAME" => Loc::getMessage("C_BALDR_RANDOMIZE_CC_GROUP_MAIL_CONFIG"),
        ),
    ),
    "PARAMETERS" => array(
        "MAIN_TYPE" => array(
            "PARENT" => "BASE",
            "NAME" => Loc::getMessage("C_BALDR_RANDOMIZE_CC_TYPE_MAIN_PAGE"),
            "TYPE" => "LIST",
            "VALUES" => array(
                "LAST_LOTTERY" => Loc::getMessage("C_BALDR_RANDOMIZE_CC_TMP_LAST"),
                "LIST_LOTTERY" => Loc::getMessage("C_BALDR_RANDOMIZE_CC_TMP_LIST"),
            ),
        ),
        "DEMO_DRAW" => array(
            "PARENT" => "BASE",
            "NAME" => Loc::getMessage("C_BALDR_RANDOMIZE_CC_PAR_DEMO_DRAW"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
        ),
        "IBLOCK_TYPE" => array(
            "PARENT" => "RULES_PAGE",
            "NAME" => Loc::getMessage("C_BALDR_RANDOMIZE_CC_PAR_IB_TYPE_RULES"),
            "TYPE" => "LIST",
            "VALUES" => $arTypes,
            "DEFAULT" => "news",
            "REFRESH" => "Y",
        ),
        "IBLOCK_ID" => array(
            "PARENT" => "RULES_PAGE",
            "NAME" => Loc::getMessage("C_BALDR_RANDOMIZE_CC_PAR_IB_ID_RULES"),
            "TYPE" => "LIST",
            "VALUES" => $arIBlocks,
            "DEFAULT" => '',
            "ADDITIONAL_VALUES" => "Y",
            "REFRESH" => "Y",
        ),
        "ELEMENT_ID" => array(
            "PARENT" => "RULES_PAGE",
            "NAME" => Loc::getMessage("C_BALDR_RANDOMIZE_CC_PAR_EIB_ID_RULES"),
            "TYPE" => "STRING",
            "DEFAULT" => '',
        ),
        "USE_CAPTCHA" => Array(
            "PARENT" => "MAIL_CONFIG",
            "NAME" => Loc::getMessage("C_BALDR_RANDOMIZE_CC_PAR_CAPTCHA"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y",
        ),
        "OK_TEXT" => Array(
            "PARENT" => "MAIL_CONFIG",
            "NAME" => Loc::getMessage("C_BALDR_RANDOMIZE_CC_PAR_MAIL_OK_NAME"),
            "TYPE" => "STRING",
            "DEFAULT" => Loc::getMessage("C_BALDR_RANDOMIZE_CC_PAR_MAIL_OK_DEF"),
        ),
        "EMAIL_TO" => Array(
            "PARENT" => "MAIL_CONFIG",
            "NAME" => Loc::getMessage("C_BALDR_RANDOMIZE_CC_PAR_MAIL_MODER"),
            "TYPE" => "STRING",
            "DEFAULT" => htmlspecialcharsbx(COption::GetOptionString("main", "email_from")),
        ),
        "SEF_MODE" => Array(
            "main" => array(
                "NAME" => Loc::getMessage("C_BALDR_RANDOMIZE_CC_SEF_MAIN"),
                "DEFAULT" => "",
                "VARIABLES" => array(),
            ),
            "rules" => array(
                "NAME" => Loc::getMessage("C_BALDR_RANDOMIZE_CC_SEF_RULES"),
                "DEFAULT" => "rules/",
                "VARIABLES" => array(),
            ),
            "list" => array(
                "NAME" => Loc::getMessage("C_BALDR_RANDOMIZE_CC_SEF_LIST"),
                "DEFAULT" => "list/",
                "VARIABLES" => array(),
            ),
            "detail" => array(
                "NAME" => Loc::getMessage("C_BALDR_RANDOMIZE_CC_SEF_DETAIL"),
                "DEFAULT" => "#LOTTERY_ID#/",
                "VARIABLES" => array("LOTTERY_ID"),
            ),
            "draw" => array(
                "NAME" => Loc::getMessage("C_BALDR_RANDOMIZE_CC_SEF_DRAW"),
                "DEFAULT" => "#LOTTERY_ID#/draw/",
                "VARIABLES" => array("LOTTERY_ID"),
            ),
            "register" => array(
                "NAME" => Loc::getMessage("C_BALDR_RANDOMIZE_CC_SEF_REGISTER"),
                "DEFAULT" => "#LOTTERY_ID#/register/",
                "VARIABLES" => array("LOTTERY_ID"),
            ),
        ),
        "DRAW_GROUP_PERMISSIONS" => Array(
            "PARENT" => "ADDITIONAL_SETTINGS",
            "NAME" => Loc::getMessage("C_BALDR_RANDOMIZE_CC_DESC_GROUP_PERMISSIONS"),
            "TYPE" => "LIST",
            "VALUES" => $arUGroupsEx,
            "DEFAULT" => Array(1),
            "MULTIPLE" => "Y",
        ),
        "CACHE_TIME" => Array("DEFAULT" => 36000000),
    ),
);