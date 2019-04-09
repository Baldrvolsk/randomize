<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Baldr\Randomize\Lottery\LotteryTable;
use Baldr\Randomize\Prize\PrizeTable;
use \Bitrix\Main\Loader;
use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Type\DateTime as BitDT;


/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CUser $USER */
/** @global CMain $APPLICATION */

class RandomizeDetailComponent extends CBitrixComponent
{
    protected $lottery;

    public function executeComponent()
    {
        $this->includeComponentLang('class.php');

        $this->checkModules();

        $this->getLottery();

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

    function getLottery()
    {
        $lotteryId = (int) $this->arParams["LOTTERY_ID"];
        $this->arResult['detail'] = ($lotteryId > 0)?true:false;
        if ($lotteryId === 0) {
            $qMaxId = LotteryTable::getRow(array(
                'select' => array(
                    new Bitrix\Main\Entity\ExpressionField('MAX_ID', 'MAX(`id`)')
                ),
            ));
            $lotteryId = $qMaxId['MAX_ID'];
        }
        if (empty($lotteryId)) {
            $this->arResult['lottery'] = null;
            return;
        }
        $this->lottery = LotteryTable::getByPrimary($lotteryId, array(
            'select'  => array('*', 'PRIZE_ITEMS'),
        ))->fetchObject();

        if (empty($this->lottery)) {
            $this->arResult['lottery'] = null;
            return;
        }
        $this->arResult['lottery']['id'] = $this->lottery->get('ID');
        $this->arResult['lottery']['title'] = $this->lottery->get('TITLE');
        $this->arResult['lottery']['descr'] = $this->lottery->get('DESCRIPTION');
        $this->arResult['lottery']['status'] = $this->lottery->get('STATUS');
        $this->arResult['lottery']['trs'] = $this->lottery->get('TIME_REG_START')->format("d-m-Y");
        $this->arResult['lottery']['tre'] = $this->lottery->get('TIME_REG_END')->format("d-m-Y");
        $this->arResult['lottery']['tds'] = $this->lottery->get('TIME_DRAW_START')->format("d-m-Y");
        $this->arResult['deadline'] = $this->lottery->get('TIME_DRAW_START')->getTimestamp();
        $this->arResult['lottery']['tde'] = $this->lottery->get('TIME_DRAW_END')->format("d-m-Y");

        $this->checkStatus();
        $lotteryPrize = $this->lottery->getPrizeItems();
        if ($lotteryPrize) {
            foreach ($lotteryPrize as $prizeItem) {
                $prizeId = $prizeItem->getPrizeId();
                if ($key = $this->arraySearchMultiDim($this->arResult['prize'], 'id', $prizeId)) {
                    $this->arResult['prize'][$key]['count']++;
                    if ($this->arResult['status'] === 4) {
                        $this->arResult['prize'][$key]['winner'][] = $prizeItem->get('WINNER_ID');
                    }
                } else {
                    $prize = array();
                    if ($this->arResult['status'] === 4) {
                        if (!$prizeItem->get('PUBLISH_IN_RESULTS')) {
                            continue;
                        }
                        $prize['winner'][] = $prizeItem->get('WINNER_ID');
                    }
                    $prize['count'] = 1;
                    $dbPrize = PrizeTable::getByPrimary($prizeId)->fetchObject();
                    $prize['id'] = $dbPrize->get('ID');
                    $prize['sort'] = $prizeItem->get('SORT');
                    $prize['name'] = $dbPrize->get('NAME');
                    $prize['descr'] = $dbPrize->get('DESCRIPTION');
                    $prize['img'] = CFile::GetPath($dbPrize->get('IMG'));
                    $this->arResult['prize'][] = $prize;
                }
            }

            $sort = SORT_ASC;//($this->arResult['status'] === 4)?SORT_DESC:SORT_ASC;
            $volume  = array_column($this->arResult['prize'], 'sort');
            array_multisort($volume, $sort, $this->arResult['prize']);
        } else {
            $this->arResult['prize'] = null;
        }

    }

    private function checkStatus()
    {
        $ct = new BitDT();
        $ts = $ct->getTimestamp();
        $trs = $this->lottery->get('TIME_REG_START')->getTimestamp();
        $tre = $this->lottery->get('TIME_REG_END')->getTimestamp();
        $tds = $this->lottery->get('TIME_DRAW_START')->getTimestamp();
        $tde = $this->lottery->get('TIME_DRAW_END')->getTimestamp();

        if ($ts < $trs) { //регистрация не началась
            $this->arResult['status'] = 0;
        } elseif ($ts < $tre) { //идет регистрация
            $this->arResult['status'] = 1;
        } elseif ($ts < $tds) { //регистрация закончилась, розыгрыш не начался
            $this->arResult['status'] = 2;
        } elseif ($ts < $tde) { //проводится розыгрыш
            $this->arResult['status'] = 3;
        } else { //розыгрыш завершен
            $this->arResult['status'] = 4;
        }
    }

    private function arraySearchMultiDim($array, $column, $key){
        return (array_search($key, array_column($array, $column)));
    }
}