<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Baldr\Randomize\Lottery\LotteryTable;
use \Bitrix\Main\Loader;
use \Bitrix\Main\LoaderException;
use \Bitrix\Main\Localization\Loc;

/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */

class RandomizeListComponent extends CBitrixComponent
{
	protected function checkModules()
	{
		if (!Loader::IncludeModule("baldr.randomize"))
			throw new LoaderException(Loc::getMessage("BALDR_RANDOMIZE_MODULE_NOT_INSTALLED"));
	}

	function getLotteryList()
	{
		$getParams = array(
			'select' => array('*')
		);

		$arResult['lottery'] = LotteryTable::getList($getParams)->fetchAll();

		return $arResult;

	}

	public function executeComponent()
	{
		$this->includeComponentLang('class.php');

		$this->checkModules();

		$this->arResult = $this->getLotteryList();

		$this->IncludeComponentTemplate();
	}
}