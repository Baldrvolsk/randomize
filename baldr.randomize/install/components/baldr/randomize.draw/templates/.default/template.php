<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if ($arResult['show']): ?>
<div class="l-container">
    <div class="n-info-block" style="border: 0;">
        <h3 class="b-section-heading">Розыгрыш "<?=$arResult["lottery"]["title"]?>"</h3>
    </div>
</div>
        <div class="yt-player">
            <iframe id="ytplayer" type="text/html"
                    src="https://www.youtube.com/embed/<?=$arResult["lottery"]["video"]?>?autoplay=1&hl=ru"
                    frameborder="0" allowfullscreen>
            </iframe>
        </div>
<? else: ?>
    <div class="l-container">
        <div class="n-info-block" style="border: 0;">
            <?php
            switch($arResult['lottery']):
                case 'no lottery': ?>
                    <h3 class="b-section-heading">Такого розыгрыша не существует</h3>
                    <?php break;
                case 'no start draw': ?>
                    <h3 class="b-section-heading">Время розыгрыша еще не началось</h3>
                <?php break;
                case 'end time draw': ?>
                    <h3 class="b-section-heading">Время розыгрыша прошло</h3>
                <?php break;
                case 'end draw': ?>
                <h3 class="b-section-heading">Розыгрыш завершён</h3>
                <?php break;
                default: ?>
                    <h3 class="b-section-heading">Розыгрыш "<?=$arResult["lottery"]["title"]?>"</h3>
        </div>
    </div>
    <div class="lottery-container">
        <ul id="lottery" class="lpl-draw">
            <?php foreach ($arResult['prize'] as $item): ?>
            <li class="lpl-draw-item" data-prize="<?=$item['id']?>"
                data-winner="<?=$item['winner']?>" data-text="<?=$item['dataText']?>">
                <div class="lpl-draw-title">
                    <?=$item['name']?>
                </div>
                <img class="lpl-draw-img" src="<?=$item['img']?>" alt="prize-<?=$item['id']?>" />
                <div class="lpl-draw-winner" id="prize-winner-<?=$item['winner']?>"></div>
            </li>
            <?php endforeach; ?>
        </ul>

        <?php if(empty($arResult['notMember'])): ?>
        <div>
            <button class="b-btn" style="display:block; margin: 0 auto" type="button" id="spin">Разыграть первый подарок</button>
            <div style="display: none; text-align:center;" id="end">
                <form method="post" action="<?= POST_FORM_ACTION_URI ?>">
                    <input type="hidden" name="end_draw" value="end">
                    <input type="hidden" name="lotteryId" value="<?=$arResult["lottery"]["id"]?>">
                    <button class="b-btn" type="submit">Розыгрыш окончен</button>
                </form>
            </div>
            <div id="roulette-container">
                <div id="roulette-indicator-id" class="roulette-indicator">
                    <div class="arrowup"></div>
                    <div class="arrowdown"></div>
                </div>
                <div id="roulette-images">
                    <ul id="roulette-images-list">
                    </ul>
                </div>
            </div>
        </div>
                <script>
                    var member = JSON.parse('<?=$arResult["members"]?>');
                </script>
        <?php else: ?>
        <h3>В розыгрыше отсутствуют участники</h3>
        <?php endif; ?>
    </div>

    <script src="//cdnjs.cloudflare.com/ajax/libs/gsap/1.17.0/plugins/CSSPlugin.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/gsap/1.18.5/TweenMax.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/gsap/1.18.5/TimelineMax.min.js"></script>
<?php endswitch;
endif; ?>
<p></p>
