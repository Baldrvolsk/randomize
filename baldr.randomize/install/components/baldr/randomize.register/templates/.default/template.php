<?

use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

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
        <h3 class="b-section-heading">
            <?= Loc::getMessage("T_BALDR_RANDOMIZE_REGISTER_TITLE_PAGE") ?> "<?= $arResult["lottery"]['TITLE'] ?>"
        </h3>
        <p>
            Регистрация продлится с <?=$arResult["lottery"]['TIME_REG_START']->toString()//->format("d-m-Y") ?>
            по <?=$arResult["lottery"]['TIME_REG_END']->toString()//->format("d-m-Y") ?>
        </p>
        <p>
            Розыгрыш подарков будет произведен с <?=$arResult["lottery"]['TIME_DRAW_START']->toString()//->format("d-m-Y") ?>
            по <?=$arResult["lottery"]['TIME_DRAW_END']->toString()//->format("d-m-Y") ?>
        </p>
        <div>
            <? if (!empty($arResult["ERROR_MESSAGE"])) { //были ошибки
                foreach ($arResult["ERROR_MESSAGE"] as $v)
                    ShowError($v);
            }
            if (strlen($arResult["OK_MESSAGE"]) > 0): ?>
                <p style="text-align:center;font:20px bolder;color:green;"><?=$arResult["OK_MESSAGE"]?></p>
                <div class="n-simple-block n-simple-block--width n-simple-block--btn-pos" style="padding: 15px 0;">
                <a class="n-btn-rev" href="<?=$arParams['FOLDER']?>">
                    <div class="n-head-pic__arr n-head-pic__arr--mod"></div>
                    <span>Назад</span>
                </a>
                </div>
            <?php endif; ?>
        </div>
        <div class="b-order-forms__content tabs-pane active" id="tab1">


            <form class="form-generator b-form" id="ol-register" name="ol-register" method="post"
                  action="<?= POST_FORM_ACTION_URI ?>">
                <?= bitrix_sessid_post() ?>
                <div class="form-group">
                    <input type="text" class="form-control b-form__field" placeholder="Организация *"
                           name="companyName" value="<?=$arResult["companyName"]?>">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control b-form__field" placeholder="ФИО *"
                           name="personName" value="<?=$arResult["personName"]?>">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control b-form__field" placeholder="E-mail *"
                           name="email" value="<?=$arResult["email"]?>">
                </div>
                <div class="form-group">
                    <input type="tel" class="form-control b-form__field" placeholder="Ваш телефон *"
                           name="phone" value="<?=$arResult["phone"]?>">
                </div>

                <? if ($arParams["USE_CAPTCHA"] == "Y"): ?>
                    <div id="reCaptcha">
                        <div style="width: 304px; height: 78px;">
                            <div>
                                <iframe src="https://www.google.com/recaptcha/api2/anchor?ar=1&amp;k=6LfYj1cUAAAAAAExuQqxwLDP44qCunnXBRWyGYDM&amp;co=aHR0cHM6Ly9vbG0ub3JnOjQ0Mw..&amp;hl=ru&amp;v=v1547447582668&amp;size=normal&amp;cb=baut3k5onysp"
                                        width="304" height="78" role="presentation" name="a-46irn7gthtr7"
                                        frameborder="0" scrolling="no"
                                        sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-top-navigation allow-modals allow-popups-to-escape-sandbox"></iframe>
                            </div>
                            <textarea id="g-recaptcha-response" name="g-recaptcha-response" class="g-recaptcha-response"
                                      style="width: 250px; height: 40px; border: 1px solid rgb(193, 193, 193); margin: 10px 25px; padding: 0; resize: none; display: none;"></textarea>
                        </div>
                    </div>
                <? endif; ?>

                <div class="form-group">
                    <label class="checkbox-wrap">
                        <input type="checkbox" name="confirmRules" id="confirmRules" value="Y" required aria-required="true" aria-invalid="false">
                        <span class="checkbox-view"></span> Согласен
                        <a href="<?= $arParams['FOLDER'] . $arParams['URL_TEMPLATES']['rules'] ?>" target="_blank" class="checkbox-link">
                            с условиями розыгрыша.
                        </a>
                    </label>
                    <label for="confirmRules" class="error"></label>
                </div>
                <div class="form-group">
                    <label class="checkbox-wrap">
                        <input type="checkbox" name="confirmOrder" id="confirmOrder" value="Y" required aria-required="true" aria-invalid="false">
                        <span class="checkbox-view"></span> Согласен
                        <a href="/personal-data-processing-policy/" target="_blank" class="checkbox-link">
                            с условиями обработки моих персональных данных.
                        </a>
                    </label>
                    <label for="confirmOrder" class="error"></label>
                </div>
                <input type="hidden" name="PARAMS_HASH" value="<?= $arResult["PARAMS_HASH"] ?>">
                <input type="hidden" name="lotteryId" value="<?= $arResult["LOTTERY_ID"] ?>">
                <input type="hidden" name="regStatus" value="<?= $arResult["regStatus"] ?>">
                <button type="submit"
                        class="b-form__submit"><?= Loc::getMessage("T_BALDR_RANDOMIZE_REGISTER_SUBMIT_BUTTON") ?></button>
            </form>

        </div>
    </div>
</div>