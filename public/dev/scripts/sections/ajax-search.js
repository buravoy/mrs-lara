import $ from 'jquery';

$(function (){
    const
        $input = $('#search'),
        $results = $('.results'),
        $searchIcon = $('.fa-search'),
        $spinner = $('.fa-spinner');

    $('.search-toggle').on('click', function (){
        console.log('jklkjh');
        $('form.search').toggleClass('show');
    })



    $('form.search').on('submit', function (e) {
        e.preventDefault();
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


                const href = $results.find('a').first().attr('href')
                console.log($results.find('a'))
                if (href) window.location = href;

                e.stopImmediatePropagation();
                break;
        }
    })

    $input.on('input', delay(function (e){
            $results.fadeIn(100);
            $searchIcon.fadeOut(200);
            $spinner.fadeIn(200);

            const
                $t = $(this),
                url = $t.closest('form').data('ajax'),
                data = new FormData();

            if ($t.val().length < 3) {
                $searchIcon.fadeIn(200);
                $spinner.fadeOut(200);
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
                    }
                },
            }).done(function() {
                $searchIcon.fadeIn(200);
                $spinner.fadeOut(200);
            }).catch(function () {
                $searchIcon.fadeIn(200);
                $spinner.fadeOut(200);
            })

    }, 1000))

    $input.on('focus', function () {
        if ($(this).val().length > 2) {
            $results.fadeIn(100);
            $(this).trigger('keyup');
        }
    })

    function delay(fn, ms) {
        let timer = 0
        return function(...args) {
            clearTimeout(timer)
            timer = setTimeout(fn.bind(this, ...args), ms || 0)
        }
    }

    $input.on('blur', function () {
        setTimeout(function (){
            $results.fadeOut(100);
        }, 200)
    })
})
