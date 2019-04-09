<?php

use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

Loc::loadMessages(__FILE__);

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

?>

<div class="l-container">
    <div class="n-info-block" style="border: 0;">
        <h3 class="b-section-heading"><?=$arResult["NAME"]?></h3>
        <?php if (isset($arResult['DETAIL_TEXT']) && strlen($arResult['DETAIL_TEXT']) > 0):?>
		    <?=$arResult['DETAIL_TEXT']?>
		<?php else:?>
		    <?=$arResult['PREVIEW_TEXT']?>
		<?php endif;?>
    </div>
    <?php if (strpos($_SERVER['HTTP_REFERER'], SITE_SERVER_NAME) === false) {
        $backLink = 'href="'.$arParams['FOLDER'].'"';
    } else {
        $backLink = 'href="#" onclick="history.back();"';
    } ?>
    <div class="n-simple-block n-simple-block--width n-simple-block--padding n-simple-block--border n-simple-block--btn-pos">
        <a class="n-btn-rev" <?=$backLink?>>
            <div class="n-head-pic__arr n-head-pic__arr--mod"></div>
            <span><?= Loc::getMessage("T_BALDR_RANDOMIZE_NEWS_DETAIL_BACK") ?></span>
        </a>
    </div>
</div>