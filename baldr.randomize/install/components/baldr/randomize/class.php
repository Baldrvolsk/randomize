<?php

use \Bitrix\Main\Loader;
use \Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/** @var CBitrixComponent $this
 * @var array $arParams
 * @var array $arResult
 * @var string $componentPath
 * @var string $componentName
 * @var string $componentTemplate
 * @global CMain $APPLICATION
 */
class RandomizeComponent extends CBitrixComponent
{
    public $arDefaultUrlTemplates404 = array(
        "main" => "",
        "rules" => "rules/",
        "list" => "list/",
        "detail" => "#LOTTERY_ID#/",
        "draw" => "#LOTTERY_ID#/draw/",
        "register" => "#LOTTERY_ID#/register/",
    );

    public $arComponentVariables = array();

    public $componentPage = '';
    private $arDefaultVariableAliases = array();

    public function executeComponent()
    {
        $this->includeComponentLang('class.php');
        $this->checkModules();
        $this->prepareParams();
        $this->IncludeComponentTemplate($this->componentPage);
    }

    public function checkModules()
    {
        try {
            if (!Loader::IncludeModule('baldr.randomize')) {
                die(Loc::getMessage("BALDR_RANDOMIZE_MODULE_NOT_INSTALLED"));
            }
        } catch (\Bitrix\Main\LoaderException $e) {
        }
    }

    public function prepareParams()
    {
        if ($this->arParams["SEF_MODE"] == "Y") {
            $arUrlTemplates = CComponentEngine::MakeComponentUrlTemplates($this->arDefaultUrlTemplates404, $this->arParams["SEF_URL_TEMPLATES"]);

            $arVariables = array();
            $this->componentPage = CComponentEngine::ParseComponentPath(
                $this->arParams["SEF_FOLDER"],
                $arUrlTemplates,
                $arVariables
            );
            if (!$this->componentPage) {
                $this->componentPage = "main";
            }

            $this->arResult = array(
                "FOLDER" => $this->arParams["SEF_FOLDER"],
                "URL_TEMPLATES" => $arUrlTemplates,
                "VARIABLES" => $arVariables,
                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                "ADD_ELEMENT_CHAIN" => "Y",
                "EMAIL_TO" => $this->arParams["EMAIL_TO"],
            );
        } else {
            /** TODO: прописать разбор URL в не ЧПУ режиме */
            $arVariables = array();

            $arVariableAliases = CComponentEngine::MakeComponentVariableAliases($this->arDefaultVariableAliases, $this->arParams["VARIABLE_ALIASES"]);
            CComponentEngine::InitComponentVariables(false, $this->arComponentVariables, $arVariableAliases, $arVariables);

            $this->componentPage = "";

            if (isset($arVariables["ELEMENT_ID"]) && intval($arVariables["ELEMENT_ID"]) > 0)
                $this->componentPage = "film";
            elseif (isset($arVariables["ELEMENT_CODE"]) && strlen($arVariables["ELEMENT_CODE"]) > 0)
                $this->componentPage = "film";
            elseif (isset($arVariables["add_film"]))
                $this->componentPage = "add_film";
            else
                $this->componentPage = "main";

            $this->arResult = array(
                "FOLDER" => "",
                "URL_TEMPLATES" => Array("aphisha" => htmlspecialcharsbx($APPLICATION->GetCurPage()),
                    "film" => htmlspecialcharsbx($APPLICATION->GetCurPage() . "?" . $arVariableAliases["ELEMENT_ID"] . "=#ELEMENT_ID#"),
                    "add_film" => htmlspecialcharsbx($APPLICATION->GetCurPage() . "?add_film=y"),
                ),
                "VARIABLES" => $arVariables,
            );
        }
    }
}