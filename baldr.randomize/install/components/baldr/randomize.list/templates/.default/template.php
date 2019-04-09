<?

use Bitrix\Main\Localization\Loc;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

Loc::loadMessages(__FILE__);

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
?>
<div class="l-container">
    <div class="n-info-block" style="border: 0;">
        <?php
        if (empty($arResult['lottery'])): ?>
            <h3 class="b-section-heading"><?=Loc::getMessage("T_BALDR_RANDOMIZE_DETAIL_LOTTERY_IS_NULL")?></h3>
        <?php else: ?>
            <h3 class="b-section-heading"><?=Loc::getMessage("T_BALDR_RANDOMIZE_LOTTERY_LIST_PAGE_TITLE")?></h3>
            <ol>
                <?php foreach ($arResult['lottery'] as $key => $lot): ?>
                <li>
                    <a href="<?=$arParams['FOLDER'].$lot['ID']?>/"><?=$lot['TITLE']?></a>
                </li>
                <?php endforeach; ?>
            </ol>

            <div class="n-simple-block n-simple-block--width n-simple-block--padding n-simple-block--border n-simple-block--btn-pos">
                <?php if (strpos($_SERVER['HTTP_REFERER'], SITE_SERVER_NAME) === false) {
                    $backLink = 'href="'.$arParams['FOLDER'].'"';
                } else {
                    $backLink = 'href="#" onclick="history.back();"';
                } ?>
                <a class="n-btn-rev" <?=$backLink?>>
                    <div class="n-head-pic__arr n-head-pic__arr--mod"></div>
                    <span>назад</span>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>