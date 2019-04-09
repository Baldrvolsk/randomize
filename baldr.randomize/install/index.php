<?php

use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Config\Option;
use \Bitrix\Main\Loader;
use \Bitrix\Main\Entity\Base;
use \Bitrix\Main\Application;

Loc::loadMessages(__FILE__);

Class baldr_randomize extends CModule
{
    protected $theme_path;
    protected $component_path;
    protected $install_path;
    protected $i_theme_path;
    protected $i_component_path;
    protected $mailRegFormET = 'OL_REGISTER_FORM';
    protected $mailRejectRegET = 'OL_REJECT_REG';
    protected $mailRejectRegModET = 'OL_REJECT_M_REG';
    protected $mailConfirmRegET = 'OL_CONFIRM_REG';
    protected $mailWinnerET = 'OL_WINNER_NOTIFY';

    function __construct()
    {
        $arModuleVersion = array();
        include(__DIR__ . "/version.php");

        $this->MODULE_ID = 'baldr.randomize';
        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        $this->MODULE_NAME = Loc::getMessage("I_BALDR_RANDOMIZE_MODULE_NAME");
        $this->MODULE_DESCRIPTION = Loc::getMessage("I_BALDR_RANDOMIZE_MODULE_DESC");

        $this->PARTNER_NAME = Loc::getMessage("I_BALDR_RANDOMIZE_PARTNER_NAME");
        $this->PARTNER_URI = Loc::getMessage("I_BALDR_RANDOMIZE_PARTNER_URI");

        $this->MODULE_SORT = 1;
        $this->SHOW_SUPER_ADMIN_GROUP_RIGHTS = 'Y';
        $this->MODULE_GROUP_RIGHTS = "Y";

        $this->theme_path = $this->GetPath() . "/install/themes";
        $this->component_path = $this->GetPath() . "/install/components";
        $this->install_path = dirname(dirname($this->GetPath()));
        $this->i_theme_path = $_SERVER["DOCUMENT_ROOT"] . '/bitrix/themes';
        $this->i_component_path = $this->install_path . "/components";
    }

    //Определяем место размещения модуля
    public function GetPath($notDocumentRoot = false)
    {
        if ($notDocumentRoot)
            return str_ireplace(Application::getDocumentRoot(), '', dirname(__DIR__));
        else
            return dirname(__DIR__);
    }

    //Проверяем что система поддерживает D7
    public function isVersionD7()
    {
        return CheckVersion(\Bitrix\Main\ModuleManager::getVersion('main'), '14.00.00');
    }

    //Проверяем что в системе установлен модуль Admin Helper
    public function checkAdmInter()
    {
        return \Bitrix\Main\ModuleManager::isModuleInstalled('digitalwand.admin_helper');
    }

    public function InstallDB()
    {
        Loader::includeModule($this->MODULE_ID);
        // создаем таблицы если не существуют
        //таблица розыгрышей
        if (
        !Application::getConnection(\Baldr\Randomize\Lottery\LotteryTable::getConnectionName())
            ->isTableExists(Base::getInstance('\Baldr\Randomize\Lottery\LotteryTable')->getDBTableName())
        ) {
            Base::getInstance('\Baldr\Randomize\Lottery\LotteryTable')->createDbTable();
        }
        //таблица компаний
        if (
        !Application::getConnection(\Baldr\Randomize\Member\CompanyTable::getConnectionName())
            ->isTableExists(Base::getInstance('\Baldr\Randomize\Member\CompanyTable')->getDBTableName())
        ) {
            Base::getInstance('\Baldr\Randomize\Member\CompanyTable')->createDbTable();
        }
        //таблица участников
        if (
        !Application::getConnection(\Baldr\Randomize\Member\MemberTable::getConnectionName())
            ->isTableExists(Base::getInstance('\Baldr\Randomize\Member\MemberTable')->getDBTableName())
        ) {
            Base::getInstance('\Baldr\Randomize\Member\MemberTable')->createDbTable();
        }
        //таблица связей компания-розыгрыш
        if (
        !Application::getConnection(\Baldr\Randomize\Member\CompanyLotteryTable::getConnectionName())
            ->isTableExists(Base::getInstance('\Baldr\Randomize\Member\CompanyLotteryTable')->getDBTableName())
        ) {
            Base::getInstance('\Baldr\Randomize\Member\CompanyLotteryTable')->createDbTable();
        }
        //таблица призов
        if (
        !Application::getConnection(\Baldr\Randomize\Prize\PrizeTable::getConnectionName())
            ->isTableExists(Base::getInstance('\Baldr\Randomize\Prize\PrizeTable')->getDBTableName())
        ) {
            Base::getInstance('\Baldr\Randomize\Prize\PrizeTable')->createDbTable();
        }
        //таблица связей приз-розыгрыш
        if (
        !Application::getConnection(\Baldr\Randomize\Prize\PrizeLotteryTable::getConnectionName())
            ->isTableExists(Base::getInstance('\Baldr\Randomize\Prize\PrizeLotteryTable')->getDBTableName())
        ) {
            Base::getInstance('\Baldr\Randomize\Prize\PrizeLotteryTable')->createDbTable();
        }
    }

    public function UnInstallDB()
    {
        Loader::includeModule($this->MODULE_ID);

        Application::getConnection(\Baldr\Randomize\Prize\PrizeLotteryTable::getConnectionName())->
        queryExecute('drop table if exists ' . Base::getInstance('\Baldr\Randomize\Prize\PrizeLotteryTable')->getDBTableName());

        Application::getConnection(\Baldr\Randomize\Prize\PrizeTable::getConnectionName())->
        queryExecute('drop table if exists ' . Base::getInstance('\Baldr\Randomize\Prize\PrizeTable')->getDBTableName());

        Application::getConnection(\Baldr\Randomize\Member\CompanyLotteryTable::getConnectionName())->
        queryExecute('drop table if exists ' . Base::getInstance('\Baldr\Randomize\Member\CompanyLotteryTable')->getDBTableName());

        Application::getConnection(\Baldr\Randomize\Member\MemberTable::getConnectionName())->
        queryExecute('drop table if exists ' . Base::getInstance('\Baldr\Randomize\Member\MemberTable')->getDBTableName());

        Application::getConnection(\Baldr\Randomize\Member\CompanyTable::getConnectionName())->
        queryExecute('drop table if exists ' . Base::getInstance('\Baldr\Randomize\Member\CompanyTable')->getDBTableName());

        Application::getConnection(\Baldr\Randomize\Lottery\LotteryTable::getConnectionName())->
        queryExecute('drop table if exists ' . Base::getInstance('\Baldr\Randomize\Lottery\LotteryTable')->getDBTableName());

        Option::delete($this->MODULE_ID);
    }

    public function InstallFiles()
    {
        CopyDirFiles($this->theme_path, $this->i_theme_path, true, true);
        CopyDirFiles($this->component_path, $this->i_component_path, true, true);
        echo $this->component_path . '->' . $this->i_component_path;
        return true;
    }

    public function UnInstallFiles()
    {
        if (\Bitrix\Main\IO\Directory::isDirectoryExists($this->theme_path)) {
            DeleteDirFiles($this->theme_path . "/.default/", $this->i_theme_path . "/.default");//css
            \Bitrix\Main\IO\Directory::deleteDirectory($_SERVER['DOCUMENT_ROOT'] . "/bitrix/themes/.default/icons/baldr.randomize");//icons

        }
        if (\Bitrix\Main\IO\Directory::isDirectoryExists($this->component_path)) {
            \Bitrix\Main\IO\Directory::deleteDirectory($this->i_component_path . '/baldr');
        }
        echo $this->component_path . '->' . $this->i_component_path;
        return true;
    }

    public function InstallMail()
    {
        $obEventType = new CEventType;
        $eMess = new CEventMessage;
        // заявка на участие
        $obEventType->Add(array(
            "EVENT_NAME" => $this->mailRegFormET,
            "NAME" => Loc::getMessage("I_BALDR_RANDOMIZE_MAIL_REG_FORM_E_T"),
            "LID" => "ru",
            "DESCRIPTION" => Loc::getMessage("I_BALDR_RANDOMIZE_MAIL_REG_FORM_E_D")
        ));
        $mRegFormMember = array(
            "ACTIVE" => "Y",
            "EVENT_NAME" => $this->mailRegFormET,
            "LID" => "s1",
            "EMAIL_FROM" => "#DEFAULT_EMAIL_FROM#",
            "EMAIL_TO" => "#EMAIL_MEMBER#",
            "SUBJECT" => Loc::getMessage("I_BALDR_RANDOMIZE_MAIL_REG_FORM_T_T"),
            "BODY_TYPE" => "text",
            "MESSAGE" => Loc::getMessage("I_BALDR_RANDOMIZE_MAIL_REG_FORM_T_D")
        );
        $eMess->Add($mRegFormMember);
        $mRegFormModer = array(
            "ACTIVE" => "Y",
            "EVENT_NAME" => $this->mailRegFormET,
            "LID" => "s1",
            "EMAIL_FROM" => "#DEFAULT_EMAIL_FROM#",
            "EMAIL_TO" => "#EMAIL_MODER#",
            "SUBJECT" => Loc::getMessage("I_BALDR_RANDOMIZE_MAIL_REG_MODER_T_T"),
            "BODY_TYPE" => "text",
            "MESSAGE" => Loc::getMessage("I_BALDR_RANDOMIZE_MAIL_REG_MODER_T_D")
        );
        $eMess->Add($mRegFormModer);

        // отклонение заявки на участие в розыгрыше
        $obEventType->Add(array(
            "EVENT_NAME" => $this->mailRejectRegET,
            "NAME" => Loc::getMessage("I_BALDR_RANDOMIZE_MAIL_REJECT_E_T"),
            "LID" => "ru",
            "DESCRIPTION" => Loc::getMessage("I_BALDR_RANDOMIZE_MAIL_REJECT_E_D")
        ));
        $mRejectRegMember = array(
            "ACTIVE" => "Y",
            "EVENT_NAME" => $this->mailRejectRegET,
            "LID" => "s1",
            "EMAIL_FROM" => "#DEFAULT_EMAIL_FROM#",
            "EMAIL_TO" => "#EMAIL_MEMBER#",
            "SUBJECT" => Loc::getMessage("I_BALDR_RANDOMIZE_MAIL_REJECT_T_T"),
            "BODY_TYPE" => "text",
            "MESSAGE" => Loc::getMessage("I_BALDR_RANDOMIZE_MAIL_REJECT_T_D")
        );
        $eMess->Add($mRejectRegMember);
        // оповещение модератора при автоматическом отклонение заявки на участие в розыгрыше
        $obEventType->Add(array(
            "EVENT_NAME" => $this->mailRejectRegModET,
            "NAME" => Loc::getMessage("I_BALDR_RANDOMIZE_MAIL_REJECT_M_E_T"),
            "LID" => "ru",
            "DESCRIPTION" => Loc::getMessage("I_BALDR_RANDOMIZE_MAIL_REJECT_M_E_D")
        ));
        $mRejectRegModer = array(
            "ACTIVE" => "Y",
            "EVENT_NAME" => $this->mailRejectRegModET,
            "LID" => "s1",
            "EMAIL_FROM" => "#DEFAULT_EMAIL_FROM#",
            "EMAIL_TO" => "#EMAIL_TO#",
            "SUBJECT" => Loc::getMessage("I_BALDR_RANDOMIZE_MAIL_REJECT_M_T_T"),
            "BODY_TYPE" => "text",
            "MESSAGE" => Loc::getMessage("I_BALDR_RANDOMIZE_MAIL_REJECT_M_T_D")
        );
        $eMess->Add($mRejectRegModer);

        // подтверждение заявки на участие в розыгрыше
        $obEventType->Add(array(
            "EVENT_NAME" => $this->mailConfirmRegET,
            "NAME" => Loc::getMessage("I_BALDR_RANDOMIZE_MAIL_CONFIRM_E_T"),
            "LID" => "ru",
            "DESCRIPTION" => Loc::getMessage("I_BALDR_RANDOMIZE_MAIL_CONFIRM_E_D")
        ));
        $mConfirmReg = array(
            "ACTIVE" => "Y",
            "EVENT_NAME" => $this->mailConfirmRegET,
            "LID" => "s1",
            "EMAIL_FROM" => "#DEFAULT_EMAIL_FROM#",
            "EMAIL_TO" => "#EMAIL_MEMBER#",
            "SUBJECT" => Loc::getMessage("I_BALDR_RANDOMIZE_MAIL_CONFIRM_T_T"),
            "BODY_TYPE" => "text",
            "MESSAGE" => Loc::getMessage("I_BALDR_RANDOMIZE_MAIL_CONFIRM_T_D")
        );
        $eMess->Add($mConfirmReg);

        // оповещение победителя

        $obEventType->Add(array(
            "EVENT_NAME" => $this->mailWinnerET,
            "NAME" => Loc::getMessage("I_BALDR_RANDOMIZE_MAIL_WIINNER_E_T"),
            "LID" => "ru",
            "DESCRIPTION" => Loc::getMessage("I_BALDR_RANDOMIZE_MAIL_WINNER_E_D")
        ));
        $mWinner = array(
            "ACTIVE" => "Y",
            "EVENT_NAME" => $this->mailWinnerET,
            "LID" => "s1",
            "EMAIL_FROM" => "#DEFAULT_EMAIL_FROM#",
            "EMAIL_TO" => "#EMAIL_MEMBER#",
            "SUBJECT" => Loc::getMessage("I_BALDR_RANDOMIZE_MAIL_WINNER_T_T"),
            "BODY_TYPE" => "text",
            "MESSAGE" => Loc::getMessage("I_BALDR_RANDOMIZE_MAIL_WINNER_T_D")
        );
        $eMess->Add($mWinner);
    }

    public function UnInstallMail()
    {
        global $DB;
        $eMess = new CEventMessage;

        // почтовые шаблоны
        $typeArr = array($this->mailRegFormET, $this->mailRejectRegET, $this->mailRejectRegModET,
            $this->mailConfirmRegET, $this->mailWinnerET);
        $arFilter = Array("TYPE_ID" => $typeArr, "ACTIVE" => "Y");

        $dbType = CEventMessage::GetList($by = "ID", $order = "DESC", $arFilter);
        while ($arType = $dbType->GetNext()) {
            $DB->StartTransaction();
            if (!$eMess->Delete(intval($arType["ID"]))) {
                $DB->Rollback();
            } else $DB->Commit();
        }

        $et = new CEventType;
        $et->Delete($this->mailRegFormET);
        $et->Delete($this->mailRejectRegET);
        $et->Delete($this->mailRejectRegModET);
        $et->Delete($this->mailConfirmRegET);
        $et->Delete($this->mailWinnerET);
    }

    public function InstallAgent()
    {
        CAgent::AddAgent(
            "Baldr\Randomize\Lottery\Agent::run()",
            $this->MODULE_ID,
            "Y",
            120); //3600
    }

    public function UnInstallAgent()
    {
        CAgent::RemoveModuleAgents($this->MODULE_ID);
    }

    public function DoInstall()
    {
        global $APPLICATION;
        if ($this->isVersionD7()) {
            if ($this->checkAdmInter()) {
                \Bitrix\Main\ModuleManager::registerModule($this->MODULE_ID);
                $this->InstallDB();
                $this->InstallMail();
                $this->InstallFiles();
                $this->InstallAgent();
            } else {
                $APPLICATION->ThrowException(Loc::getMessage("I_BALDR_RANDOMIZE_INSTALL_ERROR_AI_DEP"));
            }
        } else {
            $APPLICATION->ThrowException(Loc::getMessage("I_BALDR_RANDOMIZE_INSTALL_ERROR_VERSION"));
        }

        $APPLICATION->IncludeAdminFile(Loc::getMessage("I_BALDR_RANDOMIZE_INSTALL_TITLE"), $this->GetPath() . "/install/step.php");
    }

    public function DoUninstall()
    {
        global $APPLICATION;
        try {
            $context = Application::getInstance()->getContext();
        } catch (\Bitrix\Main\SystemException $e) {
        }
        $request = $context->getRequest();

        if ($request["step"] < 2) {
            $APPLICATION->IncludeAdminFile(Loc::getMessage("I_BALDR_RANDOMIZE_UNINSTALL_TITLE"), $this->GetPath() . "/install/unstep1.php");
        } elseif ($request["step"] == 2) {
            if ($request["savecomp"] != "Y")
                $this->UnInstallFiles();
            $this->UnInstallMail();
            $this->UnInstallAgent();

            if ($request["savedata"] != "Y")
                $this->UnInstallDB();

            \Bitrix\Main\ModuleManager::unRegisterModule($this->MODULE_ID);

            $APPLICATION->IncludeAdminFile(Loc::getMessage("I_BALDR_RANDOMIZE_UNINSTALL_TITLE"), $this->GetPath() . "/install/unstep2.php");
        }
    }

    public function GetModuleRightList()
    {
        return array(
            "reference_id" => array("D", "L", "M", "S", "W"),
            "reference" => array(
                "[D] " . Loc::getMessage("I_BALDR_RANDOMIZE_DENIED"),
                "[L] " . Loc::getMessage("I_BALDR_RANDOMIZE_REGISTRATION"),
                "[M] " . Loc::getMessage("I_BALDR_RANDOMIZE_MODERATION"),
                "[W] " . Loc::getMessage("I_BALDR_RANDOMIZE_FULL"))
        );
    }
}