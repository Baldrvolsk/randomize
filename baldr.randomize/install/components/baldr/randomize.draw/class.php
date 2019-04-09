<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Baldr\Randomize\Lottery\LotteryTable;
use Baldr\Randomize\Member\CompanyLotteryTable;
use Baldr\Randomize\Member\CompanyTable;
use Baldr\Randomize\Member\MemberTable;
use Baldr\Randomize\Prize\PrizeLotteryTable;
use Baldr\Randomize\Prize\PrizeTable;
use Bitrix\Main\Diag\Debug;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Mail\Event;

/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */

/** @global CMain $APPLICATION */
class RandomizeDrawComponent extends CBitrixComponent
{
    private $members;

    public function executeComponent()
    {
        $this->includeComponentLang('class.php');
        $this->checkModules();
        $this->arResult['permission'] = $this->checkPermission();
        $this->arResult['lotteryId'] = (int)$this->arParams["LOTTERY_ID"];
        if ($this->arResult['permission']) {
            if ($_SERVER["REQUEST_METHOD"] == "POST" && (!empty($_POST["end_draw"]) && $_POST["end_draw"] === 'end')) {
                $this->endDraw();
            }
            if (!empty($_GET["reset"]) && $_GET["reset"] === '1') {
                $this->resetDraw();
            }
            $this->prepareData();
            $this->draw();
        } else {
            $this->showDraw();
        }
        $this->IncludeComponentTemplate();
    }

    protected function checkModules()
    {
        try {
            if (!Loader::IncludeModule('baldr.randomize')) {
                die(Loc::getMessage("BALDR_RANDOMIZE_MODULE_NOT_INSTALLED"));
            }
        } catch (\Bitrix\Main\LoaderException $e) {
        }
    }

    protected function checkPermission()
    {
        global $USER;
        $arGroups = $USER->GetUserGroupArray();
        $arIntersectGroup = array_intersect($this->arParams["DRAW_GROUP_PERMISSIONS"], $arGroups);
        return (count($arIntersectGroup) > 0) ? true : false;
    }

    private function prepareData()
    {
        $this->arParams["EMAIL_MODER"] = trim($this->arParams["EMAIL_TO"]);

        $lottery = LotteryTable::getByPrimary($this->arResult['lotteryId'], array(
            'select' => array('*', 'PRIZE_ITEMS', 'MEMBERS_ITEMS'),
        ))->fetchObject();

        if (empty($lottery)) {
            $this->arResult['lottery'] = 'no lottery';
            return;
        }
        $objDateTime = new DateTime();
        $ct = $objDateTime->getTimestamp();
        $tre = $lottery->get('TIME_REG_END')->getTimestamp();
        $tds = $lottery->get('TIME_DRAW_START')->getTimestamp();


        if ($tds < $ct) {
            $this->arResult['lottery'] = 'end time draw';
            return;
        }
        if ($tre > $ct) {
            $this->arResult['lottery'] = 'no start draw';
            return;
        }
        $this->arResult['lottery']['id'] = $lottery->get('ID');
        $this->arResult['lottery']['title'] = $lottery->get('TITLE');
        // список подарков
        $lotteryPrize = $lottery->getPrizeItems();
        foreach ($lotteryPrize as $key => $prizeItem) {
            $dbPrize = PrizeTable::getByPrimary($prizeItem->getPrizeId())->fetchObject();
            $prize['plId'] = $prizeItem->get('ID');
            $prize['id'] = $dbPrize->get('ID');
            $prize['sort'] = $prizeItem->get('SORT');
            $prize['name'] = $dbPrize->get('NAME');
            $prize['winner'] = $prizeItem->get('WINNER_ID');
            $prize['img'] = CFile::GetPath($dbPrize->get('IMG'));

            $this->arResult['prize'][] = $prize;
        }
        $volume = array_column($this->arResult['prize'], 'sort');
        array_multisort($volume, SORT_ASC, $this->arResult['prize']);
        foreach ($this->arResult['prize'] as $key => $value) {
            $this->arResult['prize'][$key]['dataText'] = Loc::getMessage("C_BALDR_RANDOMIZE_DRAW_BUTTON_TEXT_" . ($key + 1));
        }
        // список участников
        if ($this->arParams["DEMO_DRAW"] === "Y") {
            $this->members = $this->generateDemo();
        } else {
            $lotteryMembers = $lottery->getMembersItems();
            foreach ($lotteryMembers as $memberItem) {
                if ($memberItem->get('DRAW_ALLOWED') == 1) {
                    $this->members[$memberItem->get('ID')] = "";
                }
            }
        }
        if (empty($this->members)) {
            $this->arResult['notMember'] = true;
            return;
        }
        $this->arResult['members'] = json_encode($this->members);

    }

    private function generateDemo()
    {
        $arr = array();
        for ($i = 1; $i <= 200; $i++) {
            $arr[$i] = "";
        }
        return $arr;
    }

    private function draw()
    {
        $prizeWinner = array_count_values(array_column($this->arResult['prize'], 'winner'));
        $countWinners = $prizeWinner[0];
        unset($prizeWinner[0]);
        if ($countWinners !== null) {
            $members = array_diff_key($this->members, $prizeWinner);
            $winners = array_rand($members, $countWinners);
            shuffle($winners);
            foreach ($this->arResult['prize'] as $key => $prize) {
                if ($this->arResult['prize'][$key]['winner'] == 0) {
                    $this->arResult['prize'][$key]['winner'] = $winners[$key];
                    PrizeLotteryTable::update($prize['plId'], array(
                        'WINNER_ID' => $winners[$key]
                    ));
                }
            }
        }

    }

    private function endDraw()
    {
        LocalRedirect($this->arParams["FOLDER"]);
    }

    private function resetDraw()
    {
        $id = PrizeLotteryTable::getList(array(
            'select' => array('ID'),
            'filter' => array('=LOTTERY_ID' => $this->arResult['lotteryId'])
        ))->fetchAll();
        foreach ($id as $value) {
            Debug::dumpToFile($value);
            PrizeLotteryTable::update($value['ID'], array(
                'WINNER_ID' => null
            ));
        }
    }

    private function endLottery()
    {
        $lotteryId = filter_input(INPUT_POST, 'lotteryId', FILTER_VALIDATE_INT);
        $lotteryPrize = PrizeLotteryTable::getList(array(
            'filter' => array(
                'LOTTERY_ID' => $lotteryId
            )
        ))->fetchAll();
        LotteryTable::update($lotteryId, array(
            'STATUS' => true
        ));
        Debug::dumpToFile($lotteryPrize);
        foreach ($lotteryPrize as $prizeItem) {
            $winner = CompanyLotteryTable::getRow(array(
                'filter' => array(
                    'ID' => $prizeItem['WINNER_ID']
                )
            ));
            $company = CompanyTable::getRow(array(
                'filter' => array(
                    'ID' => $winner['COMPANY_ID']
                )
            ));
            $member = MemberTable::getRow(array(
                'filter' => array(
                    'COMPANY_ID' => $company['ID'],
                    'ACTIVE_MEMBER' => true
                )
            ));
            $prize = PrizeTable::getRow(array(
                'filter' => array(
                    'ID' => $prizeItem['PRIZE_ID']
                )
            ));
            $arFields = Array(
                'EMAIL_MEMBER' => $member['EMAIL'],
                'FULL_NAME' => $member['FULL_NAME'],
                'PRIZE_NAME' => $prize['NAME']
            );
            Event::send(array(
                "EVENT_NAME" => 'OL_WINNER_NOTIFY',
                "LID" => "s1",
                "C_FIELDS" => $arFields
            ));

        }

    }

    private function showDraw()
    {

        $lottery = LotteryTable::getByPrimary($this->arResult['lotteryId'])->fetchObject();
        if ($url = $lottery->get("VIDEO_LINK")) {
            if ( preg_match( "/(http|https):\/\/(www.youtube|youtube|youtu)\.(be|com)\/([^<\s]*)/", $url, $match ) ) {
                if ( preg_match( '/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $id ) ) {
                    $this->arResult['lottery']['video'] = $id[1];
                } else if ( preg_match( '/youtube\.com\/embed\/([^\&\?\/]+)/', $url, $id ) ) {
                    $this->arResult['lottery']['video'] = $id[1];
                } else if ( preg_match( '/youtube\.com\/v\/([^\&\?\/]+)/', $url, $id ) ) {
                    $this->arResult['lottery']['video'] = $id[1];
                } else if ( preg_match( '/youtu\.be\/([^\&\?\/]+)/', $url, $id ) ) {
                    $this->arResult['lottery']['video'] = $id[1];
                } else if ( preg_match( '/youtube\.com\/verify_age\?next_url=\/watch%3Fv%3D([^\&\?\/]+)/', $url, $id ) ) {
                    $this->arResult['lottery']['video'] = $id[1];
                }
            } else {
                $this->arResult['lottery']['video'] = $url;
            }
            $this->arResult['show'] = true;
            $this->arResult['lottery']['title'] = $lottery->get('TITLE');
        } else {
            $this->arResult['show'] = false;
        }
    }
}