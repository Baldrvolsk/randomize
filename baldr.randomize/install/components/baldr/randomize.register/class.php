<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Baldr\Randomize\Lottery\LotteryTable;
use Baldr\Randomize\Member\CompanyLotteryTable;
use Baldr\Randomize\Member\CompanyTable;
use Baldr\Randomize\Member\MemberTable;
use Bitrix\Main\Diag\Debug;
use \Bitrix\Main\Loader;
use \Bitrix\Main\LoaderException;
use \Bitrix\Main\Localization\Loc;
use Bitrix\Main\Mail\Event;

/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */

/** @global CUser $USER */

/** @global CMain $APPLICATION */
class RandomizeRegisterComponent extends CBitrixComponent
{
    private $post = array();

    public function executeComponent()
    {
        global $APPLICATION;
        $this->includeComponentLang('class.php');
        $this->checkModules();
        $this->prepareParams();
        if ($_SERVER["REQUEST_METHOD"] == "POST" &&
            (!isset($_POST["PARAMS_HASH"]) || $this->arResult["PARAMS_HASH"] === $_POST["PARAMS_HASH"])) {
            $this->processPost();
        } elseif ($_REQUEST["success"] == $this->arResult["PARAMS_HASH"]){
            $this->arResult["OK_MESSAGE"] = $this->arParams["OK_TEXT"];
        }

        if ($this->arParams["USE_CAPTCHA"] == "Y")
            $this->arResult["capCode"] = htmlspecialcharsbx($APPLICATION->CaptchaGetCode());
        $this->IncludeComponentTemplate();
    }

    protected function checkModules()
    {
        try {
            $check = Loader::IncludeModule("baldr.randomize");
        } catch (LoaderException $e) {
            $check = false;
        }
        if (!$check)
            Loc::getMessage("BALDR_RANDOMIZE_MODULE_NOT_INSTALLED");
    }

    protected function prepareParams()
    {
        global $USER;
        $this->arResult["PARAMS_HASH"] = md5(serialize($this->arParams) . $this->GetTemplateName());
        $this->arResult["LOTTERY_ID"] = $this->arParams["VARIABLES"]["LOTTERY_ID"];
        $this->arParams["USE_CAPTCHA"] = (($this->arParams["USE_CAPTCHA"] != "N" && !$USER->IsAuthorized()) ? "Y" : "N");
        $this->arParams["EVENT_NAME"] = trim($this->arParams["EVENT_NAME"]);
        if ($this->arParams["EVENT_NAME"] == '')
            $this->arParams["EVENT_NAME"] = "OL_REGISTER_FORM";
        $this->arParams["EMAIL_MODER"] = trim($this->arParams["EMAIL_TO"]);
        if ($this->arParams["EMAIL_MODER"] == '') {
            $this->arParams["EMAIL_MODER"] = COption::GetOptionString("main", "email_from");
        }
        $this->arParams["OK_TEXT"] = trim($this->arParams["OK_TEXT"]);
        if ($this->arParams["OK_TEXT"] == '')
            $this->arParams["OK_TEXT"] = Loc::getMessage("BALDR_RANDOMIZE_REGISTER_OK_MESSAGE");
        $this->arResult["lottery"] = LotteryTable::getRowById($this->arResult["LOTTERY_ID"]);
    }

    protected function processPost()
    {
        global $APPLICATION;
        /**
         * companyName, personName, email, phone, g-recaptcha-response, confirmRules, confirmOrder, PARAMS_HASH, lotteryId
         */
        $this->arResult["ERROR_MESSAGE"] = array();
        if (check_bitrix_sessid()) {
            // проверяем companyName
            $this->post['companyName'] = filter_input(INPUT_POST, 'companyName', FILTER_SANITIZE_STRING);
            switch ($this->post['companyName']) {
                case null:
                    $this->arResult["ERROR_MESSAGE"][] = Loc::getMessage("C_BALDR_RANDOMIZE_REGISTER_FIELD_NULL",
                        array("#FIELD_NAME#" => Loc::getMessage("C_BALDR_RANDOMIZE_REGISTER_FIELD_COMPANY")));
                    break;
                case false:
                    $this->arResult["ERROR_MESSAGE"][] = Loc::getMessage("C_BALDR_RANDOMIZE_REGISTER_FIELD_ERROR");
                    break;
            }
            // проверяем $this->post['personName']
            $this->post['personName'] = filter_input(INPUT_POST, 'personName', FILTER_SANITIZE_STRING);
            switch ($this->post['personName']) {
                case null:
                    $this->arResult["ERROR_MESSAGE"][] = Loc::getMessage("C_BALDR_RANDOMIZE_REGISTER_FIELD_NULL",
                        array("#FIELD_NAME#" => Loc::getMessage("C_BALDR_RANDOMIZE_REGISTER_FIELD_FULL_NAME")));
                    break;
                case false:
                    $this->arResult["ERROR_MESSAGE"][] = Loc::getMessage("C_BALDR_RANDOMIZE_REGISTER_FIELD_ERROR");
                    break;
            }
            // проверяем email
            $this->post['email'] = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            switch ($this->post['email']) {
                case null:
                    $this->arResult["ERROR_MESSAGE"][] = Loc::getMessage("C_BALDR_RANDOMIZE_REGISTER_FIELD_NULL",
                        array("#FIELD_NAME#" => "E-mail"));
                    break;
                case false:
                    $this->arResult["ERROR_MESSAGE"][] = Loc::getMessage("C_BALDR_RANDOMIZE_REGISTER_FIELD_ERROR");
                    break;
            }
            // проверяем phone
            $this->post['phone'] = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
            switch ($this->post['phone']) {
                case null:
                    $this->arResult["ERROR_MESSAGE"][] = Loc::getMessage("C_BALDR_RANDOMIZE_REGISTER_FIELD_NULL",
                        array("#FIELD_NAME#" => Loc::getMessage("C_BALDR_RANDOMIZE_REGISTER_FIELD_PHONE")));
                    break;
                case false:
                    $this->arResult["ERROR_MESSAGE"][] = Loc::getMessage("C_BALDR_RANDOMIZE_REGISTER_FIELD_ERROR");
                    break;
            }
            // проверяем confirmRules
            $this->post['confirmRules'] = filter_input(INPUT_POST, 'confirmRules', FILTER_SANITIZE_STRING);
            if ($this->post['confirmRules'] !== "Y") {
                $this->arResult["ERROR_MESSAGE"][] = Loc::getMessage("C_BALDR_RANDOMIZE_REGISTER_FIELD_C_RULES");
            }
            // проверяем confirmOrder
            $this->post['confirmOrder'] = filter_input(INPUT_POST, 'confirmOrder', FILTER_SANITIZE_STRING);
            if ($this->post['confirmOrder'] !== "Y") {
                $this->arResult["ERROR_MESSAGE"][] = Loc::getMessage("C_BALDR_RANDOMIZE_REGISTER_FIELD_C_ORDER");
            }

            //if ($this->arParams["USE_CAPTCHA"] == "Y") {
            /** TODO: реализовать проверку капчи g-recaptcha-response */
            //}

            if (empty($this->arResult["ERROR_MESSAGE"])) {
                $this->arResult["register"]["regStatus"] = $this->registerMember();
                LocalRedirect($APPLICATION->GetCurPageParam("success=".$this->arResult["PARAMS_HASH"], Array("success")));
            }
            $this->arResult["register"]['post'] = $this->post;
        } else
            $this->arResult["ERROR_MESSAGE"][] = GetMessage("MF_SESS_EXP");
    }

    private function registerMember()
    {
        // добавляем компанию
        $addCompany = CompanyTable::add(array(
            'COMPANY_NAME' => $this->post['companyName'],
        ));
        if ($addCompany->isSuccess()) { // если компания добавилась
            $companyId = $addCompany->getId();
            $newCompany = true;
        } else { // компания не добавилась, скорей всего такая уже есть
            $qCompanyId = CompanyTable::getRow(array(
                'filter' => array('=COMPANY_NAME' => $this->post['companyName']),
            ));
            $companyId = $qCompanyId['ID'];
            $newCompany = false;
        }
        // проверяем заявку компании
        $companyRegistered = false;
        $qCompanyLotteryId = array();
        if ($newCompany) { // если компания новая, то она никак не может быть зарегистрирована
            $companyRegistered = false;
        } else { // если компания уже есть, проверяем не зарегистрировалась ли она уже в розыгрыше
            $qCompanyLotteryId = CompanyLotteryTable::getRow(array(
                'filter' => array(
                    'LOTTERY_ID' => $this->arResult["LOTTERY_ID"],
                    'COMPANY_ID' => $companyId,
                )
            ));
        }

        if (empty($qCompanyLotteryId['ID'])) { // если компания не зарегистрировалась в розыгрыше добавляем
            CompanyLotteryTable::add(array(
                'LOTTERY_ID' => $this->arResult["LOTTERY_ID"],
                'COMPANY_ID' => $companyId,
            ));

        } else { // иначе выставляем флаг что компания уже зарегистрирована
            $companyRegistered = true;
        }
        // добавляем пользователя
        $params = array(
            'COMPANY_ID' => $companyId,
            'FULL_NAME' => $this->post["personName"],
            'EMAIL' => $this->post["email"],
            'PHONE' => $this->post["phone"],
        );
        if ($newCompany) { // если компания новая, то пользователю выставляем флаг активности
            $params['ACTIVE_MEMBER'] = true;
        }
        $addMember = MemberTable::add($params);
        if (!$addMember->isSuccess()) { // если добавление не удалось
            $qMemberId = MemberTable::getRow(array(
                'filter' => array('=EMAIL' => $this->post['email']),
            ));
            if (!$companyRegistered) { // если компания не зарегистрирована то существующему пользователю обновляем флаг
                MemberTable::update($qMemberId['ID'], array(
                    'ACTIVE_MEMBER' => true
                ));
            }
        }
        // обрабатываем результат
        if ($companyRegistered) {
            $arFields = Array(
                'EMAIL_MEMBER' => $this->post["email"],
                'EMAIL_MODER' => $this->arParams["EMAIL_MODER"],
                'REASON' => "Компания уже подала заявку на участие в розыгрыше",
                'FULL_NAME' => $this->post["personName"],
                'PHONE' => $this->post["phone"],
                'COMPANY_NAME' => $this->post['companyName'],
                'LOTTERY_NAME' => $this->arResult["lottery"]['TITLE']
            );
            Event::send(array(
                "EVENT_NAME" => 'OL_REJECT_REG',
                "LID" => "s1",
                "C_FIELDS" => $arFields
            ));
            Event::send(array(
                "EVENT_NAME" => 'OL_REJECT_M_REG',
                "LID" => "s1",
                "C_FIELDS" => $arFields
            ));
        } else {
            $arFields = Array(
                'EMAIL_MEMBER' => $this->post["email"],
                'EMAIL_MODER' => $this->arParams["EMAIL_MODER"],
                'FULL_NAME' => $this->post["personName"],
                'PHONE' => $this->post["phone"],
                'COMPANY_NAME' => $this->post['companyName'],
                'LOTTERY_NAME' => $this->arResult["lottery"]['TITLE'],
                'LOTTERY_ID' => $this->arResult["lottery"]['ID']
            );
            Event::send(array(
                "EVENT_NAME" => 'OL_REGISTER_FORM',
                "LID" => "s1",
                "C_FIELDS" => $arFields
            ));
        }
        return $this->arResult["PARAMS_HASH"];
    }
}