import $ from 'jquery';

$(function (){
    const
        $input = $('#search'),
        $results = $('.results'),
        $searchIcon = $('.icon-search');

    $('form.search').on('submit', function (e) {
        const
            $form = $(this),
            val = $form.find('input').val();

        if (val.length < 3) {
            e.preventDefault();
            $results.html('<ul><li class="p-2 t-center">Минимум 3 символа</li></ul>');
        }

    })

    $input.on('keydown', function (e) {
        const key = e.keyCode;

        switch (key) {
            case 38:
                console.log('up')
                e.stopImmediatePropagation();
                break;
            case 40:
                console.log('down')
                e.stopImmediatePropagation();
                break;
            case 13:
                console.log('enter')
                e.stopImmediatePropagation();
                break;
        }
    })

    $input.on('input', delay(function (e){

            $searchIcon.fadeToggle(200);
            const
                $t = $(this),
                url = $t.closest('form').data('ajax'),
                data = new FormData();



            if ($t.val().length < 3) {
                // $results.children().remove();
                return false;
            }

            data.append('_token', $('input[name=_token]').first().val());
            data.append('string', $t.val());

            $.ajax({
                async: true,
                type: "POST",
                dataType: "json",
                contentType: false,
                url: url,
                data: data,
                processData: false,
                success: function (response) {
                    if (response && $input.is(':focus')) {
                        const $html = $(response);
                        $results.children().remove();
                        $results.append($html)
                        $searchIcon.fadeToggle(200);
                    }
                },
            })

    }, 1000))

    $input.on('focus', function () {
        if ($(this).val().length > 2) $(this).trigger('keyup');
    })

    function delay(fn, ms) {
        let timer = 0
        return function(...args) {
            clearTimeout(timer)
            timer = setTimeout(fn.bind(this, ...args), ms || 0)
        }
    }

    // $input.on('blur', function () {
    //     setTimeout(function (){
    //         $results.html('')
    //     }, 100)
    // })
})
