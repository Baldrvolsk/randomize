// https://css-tricks.com/snippets/javascript/shuffle-array/
function shuffle(o) {
    for(let j, x, i = o.length; i; j = parseInt(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);
    return o;
}

if (!String.prototype.format) {
    String.prototype.format = function() {
        let args = arguments;
        return this.replace(/{(\d+)}/g, function(match, number) {
            return typeof args[number] != 'undefined' ?
                args[number] :
                match;
        });
    };
}
$(window).load(function() {
    let tl = new TimelineMax({
        onUpdate: printLeftOfRouletteSpinner
    });

    let $roulette = $('#roulette-images-list');
    $roulette.html(generateRouletteImages(member));

    function getRandomInt(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    function getPositionOfWinner(winner) {
        let desiredImg;
        let widthOfImg = $('#roulette-images-list li:first-child img').width();
        let minDistanceToEdgeAllowed = 5;

        let leftOffset = $('#roulette-images').width()/2;
        if (winner == 0) {
            desiredImg = $('#roulette-images-list li:last-child img');
        }  else {
            desiredImg = $('#roulette-img' + winner.toString());
        }
        let minPos = desiredImg.position().left + minDistanceToEdgeAllowed - leftOffset;
        let maxPos = desiredImg.position().left + widthOfImg - minDistanceToEdgeAllowed - leftOffset;

        return getRandomInt(minPos, maxPos);
    }

    function printLeftOfRouletteSpinner() {
        let pos = $('#roulette-images-list').position().left;
        //if (pos % 100 == 0) console.log(pos);
    }

    function rouletteSpin(destImg) {
        let rouletteImages = $('#roulette-images-list'),
            startLeft = rouletteImages.position().left,
            moveImg = $('#roulette-img' + destImg.toString());

        tl
            .to(rouletteImages, 1, {
                x: 0,
                ease: Power0.easeOut
            })
            .to(rouletteImages, getRandomInt(1, 4), {
                x: getPositionOfWinner(0) * -1,
                ease: Power0.easeOut
            })
            .to(rouletteImages, getRandomInt(2, 5), {
                x: getPositionOfWinner(destImg) * -1,
                ease: Power0.easeOut
            })
            .set(moveImg, {
                css: {
                    zIndex: 9999
                }
            })
            .to(moveImg, 0.5, {
                css: {
                    boxShadow: "0px 0px 7px 3px rgb(0, 207, 0)",
                    position: 'absolute',
                    zIndex: 9999
                }
            })
            .to(moveImg, 1, {
                width: '120px',
                height: '120px',
                left: "-=20",
                top: "-=20",
                onComplete: function() { movingWinner(destImg); },
            })
    }

    function movingWinner(winner) {
        //создаем копию объекта:
        let win = $('#winner-' + winner.toString());
        let winImg = $('#roulette-img' + winner.toString());
        let dist = $('#prize-winner-' + winner.toString());
        let clone = winImg.clone().appendTo("body");

        //задаем первоначальную позицию:
        clone.css({
            top: winImg.offset().top,
            left: winImg.offset().left,
            position: 'absolute'
        });

        win.remove();
        //анимируем к позиции цели:
        clone.animate({
                top: dist.offset().top,
                left: dist.offset().left,
                width: '80px',
                height: '80px',
            }, 3000,
            //по завершении анимации удаляем элемент:
            function() {
                winImg.css({position:'relative', top: 0, left: 0, width: '80px', height: '80px',});
                dist.append(winImg);
                setTimeout(function(){clone.remove()}, 500)
                nextRound();
            });
    }

    function getRandomColor() {
        return ((1 << 24) * Math.random() | 0).toString(16)
    }

    function generateRouletteImages(member) {
        let imgTemplate = '<img src="{0}" class="{1}" id="roulette-img{2}">';
        let imgClass = 'roulette-img';
        let imgSrcTemplate = '//placehold.it/{0}/{1}/FFFFFF/?text={2}';

        let completedRouletteImages = [];
        for (let key in member) {
            let color = (member[key])?member[key]:getRandomColor();
            let imgSrc = imgSrcTemplate.format('80', color, key);
            let completedTemplate = imgTemplate.format(imgSrc, imgClass, key);

            completedRouletteImages.push('<li id="winner-' + key + '">' + completedTemplate + '</li>');
        }
        shuffle(completedRouletteImages);

        return completedRouletteImages;
    }

    const $spin = $('#spin');
    const prizes = $('#lottery li');
    const prizesCount = prizes.length;
    let currentPrizeIdx = 0;
    $spin.click(function() {
        const $prizeItem = $(prizes[currentPrizeIdx]);
        const winner = $prizeItem.data('winner');
        currentPrizeIdx++;
        rouletteSpin(winner);
        $spin.prop('disabled', true);
    });

    function nextRound() {
        if (currentPrizeIdx < prizesCount) {
            let $prizeItem = $(prizes[currentPrizeIdx]);
            let text = $prizeItem.data('text');
            $spin.text(text);
            $spin.prop('disabled', false);
        } else {
            $spin.hide();
            $('#end').show();
        }
    }

    nextRound();
});