import $ from 'jquery';

$(function (){
    const
        $input = $('#search'),
        $results = $('.results');

    $('form.search').on('submit', function (e) {
        const
            $form = $(this),
            val = $form.find('input').val();

        if (val.length < 3) {
            e.preventDefault();
            $results.html('<ul><li class="p-2 t-center">Минимум 3 символа</li></ul>');
        }

    })

    $input.on('keyup', function (e){
        const key = e.keyCode;

        switch (key) {
            case '38':
                console.log('up')
                return false;

            case '40':
                console.log('down')
                return false;

            case '13':
                console.log('enter')
                return false;

            default:
                const
                    $t = $(this),
                    url = $t.closest('form').data('ajax'),
                    data = new FormData();

                if  ($t.val().length < 3) {
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
                        if(response && $input.is(':focus')) {
                            const $html = $(response);
                            $results.children().remove();
                            $results.append($html)
                        }
                    },
                })

        }
    })

    $input.on('focus', function () {
        if ($(this).val().length > 2) $(this).trigger('keyup');
    })

    $input.on('blur', function () {
        setTimeout(function (){
            $results.html('')
        }, 100)
    })
})
