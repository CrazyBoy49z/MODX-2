$(function () {

    var $lottery = $('#lottery'),
        sec = 15, secd = sec,
        atxt = {},
        ntry = 0,
        m1 = $lottery.find("#machine1").slotMachine(),
        m2 = $lottery.find("#machine2").slotMachine(),
        m3 = $lottery.find("#machine3").slotMachine();

    // Прячем аттрибуты
    $lottery.find('.slotMachineContainer').first().children().each(function ($key) {

        var $this = $(this);

        if ($key == 0 || $key == $(this).siblings().length) {
            return;
        }

        $this.data('s', $this.attr('data-s')).removeAttr('data-s');
        $this.data('c', $this.attr('data-c')).removeAttr('data-c');
        $this.data('n', $this.attr('data-n')).removeAttr('data-n');

        if ($this.data('c')) {
            atxt[$this.data('s')] = $this.data('c');
        }
    });
    $lottery.find('.slotMachineContainer').slice(1).children().removeAttr('data-s data-c data-n');

    $('.slotMachineButton').click(function () {

        $lottery.find('.res').html('');
        $lottery.find('.gift').removeClass('show');

        var x, y, z, r,
            $loose = function () {
                r = shuffle_array(Object.keys(atxt));
                startShuffle(r[1]-1, r[2]-1, r[3]-1, function () {
                    _timer();
                });
            },
            $win = function () {

                // Тут все запутанно так что хрен распутаешь
                var rnd = randomizer(atxt),
                    $form = $('[data-target=#slotmachine_form]'),
                    gift = 0,
                    s = '',
                    k = 'n',
                    f = 's';

                $lottery.find('.slots').each(function (key) {
                    if (parseInt($(this).data('s')) === rnd) {
                        x = y = z = key-1;
                        gift = $(this);
                        f = parseInt(gift.data(f)) + parseInt($lottery.find('.slots').length / 3 - 2);
                        return false;
                    }
                });
                startShuffle(x, y, z, function () {

                    // Случайный код
                    while (s.length < 10) {
                        s += String.fromCharCode(Math.random() * 127).replace(/\W|\d|_/g, '');
                    }
                    $lottery
                        .find('.res').html('Поздравляем, вы выиграли <b>' + gift.data(k) + '</b>').end()
                        .find('.start').html('Испытайте удачу!').attr('disabled', false).end()
                        .find('.gift').addClass('show');

                    $form.find('input[name="code"]').val(s);
                    $form.find('input[name="gift"]').val(f);
                });
            };

        switch (ntry++) {
            case 0:
                $loose();
                break;
            case 1:
                switch (randomInteger(1, 5)) {
                    case 1:
                    case 2:
                        $win();
                        break;
                    default:
                        $loose();
                        break;
                }
                break;
            case 2:
                $win();
                break;
            default:
                $win();
                ntry = 0;
        }

        ntry = (ntry >= 5) ? 0 : ntry;
    });


    /**
     * startShuffle
     */
    function startShuffle(x, y, z, func) {

        $lottery.find('.start').attr('disabled', true);

        m1.setRandomize(x);
        m2.setRandomize(y);
        m3.setRandomize(z);

        m1.shuffle(13);
        setTimeout(function () {
            m2.shuffle(13);
            setTimeout(function () {
                m3.shuffle(13);
                setTimeout(function () {
                    if (typeof func === 'function')
                        func();
                }, 2000);
            }, 800);
        }, 800);
    }


    /**
     * timer
     * @returns {boolean}
     * @private
     */
    function _timer() {

        $lottery.find('.start').html('не повезло, попробуйте через ' + sec + ' секнуд');

        if (sec == 00) {
            sec = secd;
            $lottery.find('.start').html('Испытайте удачу!').attr('disabled', false);
            return false;
        }
        sec--;
        setTimeout(_timer, 1000);
    }

    /**
     * randomInteger
     * @param min
     * @param max
     * @returns {number}
     */
    function randomInteger(min, max) {
        var rand = min - 0.5 + Math.random() * (max - min + 1);
        return Math.round(rand);
    }

    /**
     * shuffle_array
     * @param o
     * @returns {*}
     */
    function shuffle_array(o) {
        for (var j, x, i = o.length; i; j = parseInt(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);
        return o;
    }

    /**
     * randomizer
     * @param $obj
     * @returns {*}
     */
    function randomizer($obj) {
        var arr = [];
        $.each($obj, function (key, val) {
            if (parseInt(val)) {
                i = 0;
                while (i++ < parseInt(val)) {
                    arr.push(parseInt(key));
                }
            }
        });

        return arr[Math.floor(Math.random() * arr.length)];
    }
});

