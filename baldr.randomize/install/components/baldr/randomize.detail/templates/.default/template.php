<?
use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

Loc::loadMessages(__FILE__);

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
?>
<div class="l-container">
    <div class="n-info-block" style="border: 0;">
        <?php
        if (empty($arResult['lottery'])): ?>
            <h3 class="b-section-heading"><?=Loc::getMessage("T_BALDR_RANDOMIZE_DETAIL_LOTTERY_IS_NULL")?></h3>
        <?php else: ?>
            <h3 class="b-section-heading"><?=$arResult['lottery']['title']?></h3>
            <?=$arResult['lottery']['descr']?>
            <div class="lottery-status">
                <p>
                    <a class="b-btn" href="<?=$arParams['RULES_URL']?>"><?= Loc::getMessage("T_BALDR_RANDOMIZE_DETAIL_RULES_LINK_TEXT") ?></a>
                    <?php
                    $hrefDraw = str_replace('#LOTTERY_ID#', $arResult['lottery']['id'], $arParams['FOLDER'].$arParams["URL_TEMPLATES"]['draw']);
                    global $USER;
                    $arGroups = $USER->GetUserGroupArray();
                    $arIntersectGroup = array_intersect($arParams["DRAW_GROUP_PERMISSIONS"], $arGroups);
                    if (count($arIntersectGroup) > 0) {
                        switch ($arResult['status']) {
                            case 4:
                            case 3:
                                echo '<a class="b-btn" href="'.$hrefDraw.'">'.Loc::getMessage("T_BALDR_RANDOMIZE_DETAIL_DRAW_END").'</a>';
                                break;
                            case 2:
                                echo '<span class="b-btn">
                                        <a href="'.$hrefDraw.'">'.Loc::getMessage("T_BALDR_RANDOMIZE_DETAIL_DRAW_RUN").'</a>
                                        <a href="'.$hrefDraw.'?reset=1" style="color: transparent">&nbsp;</a>
                                </span>';
                                break;
                            default:
                                echo '<span class="b-btn">'.Loc::getMessage("T_BALDR_RANDOMIZE_DETAIL_DRAW_START").'</span>';
                        }
                    } else {
                        switch ($arResult['status']) {
                            case 4:
                                echo '<a class="b-btn" href="'.$hrefDraw.'">'.Loc::getMessage("T_BALDR_RANDOMIZE_DETAIL_DRAW_END").'</a>';
                                break;
                            case 3:
                                echo '<a class="b-btn" href="'.$hrefDraw.'">'.Loc::getMessage("T_BALDR_RANDOMIZE_DETAIL_DRAW_RUNNING").'</a>';
                                break;
                            case 1: ?>
                                <a class="b-btn tooltip " href="<?=
                                $arParams['FOLDER'].str_replace("#LOTTERY_ID#", $arResult['lottery']['id'], $arParams["URL_TEMPLATES"]["register"])
                                ?>"><?= Loc::getMessage("T_BALDR_RANDOMIZE_DETAIL_REGISTRATION_TEXT_BUTTON") ?>
                                    <span class="tooltip-content">
                                        <span class="tooltip-text">
                                            <span class="tooltip-inner">
                                                <?= Loc::getMessage("T_BALDR_RANDOMIZE_DETAIL_REGISTRATION_TT_END") ?> <?=$arResult['lottery']['trs']?>
                                            </span>
                                        </span>
                                    </span>
                                </a>
                            <? break;
                            default: ?>
                                <span class="b-btn tooltip" style="cursor: pointer;">
                                    <?= Loc::getMessage("T_BALDR_RANDOMIZE_DETAIL_REGISTRATION_TEXT_BUTTON") ?>
                                    <span class="tooltip-content">
                                        <span class="tooltip-text">
                                            <span class="tooltip-inner">
                                                <?php if ($arResult['status'] === 0): ?>
                                                    <?= Loc::getMessage("T_BALDR_RANDOMIZE_DETAIL_REGISTRATION_TT_START") ?> <?=$arResult['lottery']['trs']?>
                                                <?php endif; ?>
                                                <?php if ($arResult['status'] >= 2 ): ?>
                                                    <?= Loc::getMessage("T_BALDR_RANDOMIZE_DETAIL_REGISTRATION_TT_AFTER") ?>
                                                <?php endif; ?>
                                            </span>
                                        </span>
                                    </span>
                                </span>
                        <? }
                    } ?>
                </p>
                <?php if ($arResult['status'] < 3): ?>
                <p style="text-align: center;"><?= Loc::getMessage("T_BALDR_RANDOMIZE_DETAIL_REGISTRATION_DRAW_BEFORE") ?></p>
                <div id="clockDiv">
                    <div>
                        <span class="days"></span>
                        <div class="smallText">Дней</div>
                    </div>
                    <div>
                        <span class="hours"></span>
                        <div class="smallText">Часов</div>
                    </div>
                    <div>
                        <span class="minutes"></span>
                        <div class="smallText">Минут</div>
                    </div>
                    <div>
                        <span class="seconds"></span>
                        <div class="smallText">Секунд</div>
                    </div>
                </div>
                <div id="deadline-message"></div>

                <script>
                    let deadline = '<?=$arResult['deadline']?>000';
                    initializeClock('clockDiv', deadline);
                </script>
                <?php endif; ?>
            </div>
            <h3 class="b-section-heading"><?=Loc::getMessage("T_BALDR_RANDOMIZE_DETAIL_PRIZE_LIST_TITLE")?></h3>
            <?php if ($arResult['prize'] === null): ?>
                <p><?= Loc::getMessage("T_BALDR_RANDOMIZE_DETAIL_PRIZE_LIST_NO_PRIZE") ?></p>
            <?php else: ?>
            <div class="lpl-detail prize-list">
                <?php foreach ($arResult['prize'] as $prize): ?>
                <div class="lpl-detail-item">
                    <img class="ld-item-img" src="<?=$prize['img']?>" alt="prize-<?=$prize['id']?>" />
                    <div class="ld-item-title"><?=$prize['name']?></div>
                    <div class="ld-item-descr">
                        <?=$prize['descr'];?>
                        <p class="bolder">
                        <?php if ($arResult['status'] === 4):
                            echo (
                                    (is_array($prize['winner']) && (count($prize['winner']) > 1)) ?
                                        Loc::getMessage("T_BALDR_RANDOMIZE_DETAIL_WINNERS_ID").implode(", ", $prize['winner']) :
                                        ((is_array($prize['winner'])) ?
                                            Loc::getMessage("T_BALDR_RANDOMIZE_DETAIL_WINNER_ID").$prize['winner'][0]:
                                        Loc::getMessage("T_BALDR_RANDOMIZE_DETAIL_WINNER_ID").$prize['winner'])
                                ).".";
                        else:
                            echo Loc::getMessage("T_BALDR_RANDOMIZE_DETAIL_PRIZE_LIST_COUNT_PRIZE", array("#NUM#" => $prize['count']));
                        endif; ?>
                        </p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            <div class="n-simple-block ">
                <?php if ($arResult['detail']): ?>
                    <?php if (strpos($_SERVER['HTTP_REFERER'], SITE_SERVER_NAME) === false) {
                        $backLink = 'href="'.$arParams['FOLDER'].'"';
                    } else {
                        $backLink = 'href="#" onclick="history.back();"';
                    } ?>
                    <a class="n-btn-rev" <?=$backLink?>>
                        <div class="n-head-pic__arr n-head-pic__arr--mod"></div>
                        <span>назад</span>
                    </a>
                <?php else: ?>
                    <a class="b-btn" href="<?=$arParams['LIST_URL']?>"><?=Loc::getMessage("T_BALDR_RANDOMIZE_DETAIL_LINK_LOTTERY_LIST_TITLE")?></a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>