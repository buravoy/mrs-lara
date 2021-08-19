import $ from "jquery";

import 'bootstrap'

$(function (){

    const $modal = $('#images-popup')

    $('.img-popup').on('click', function (){
        $modal.modal('show', $(this))
    })

    $modal.on('show.bs.modal', function (e) {
        const target = e.relatedTarget;
        $modal.find('.modal-title').text(target.data('title'));

        $modal.find('.carousel-inner').html('');
        $modal.find('.carousel-indicators').html('');

        if (target.data('source')) {
            const images = target.data('source').map(function (item) {return '<div class="carousel-item" style="background-image: url('+item+')"></div>'});
            const thumbs = target.data('source').map(function (item,key) {return '<li data-target="#carousel" data-slide-to="'+key+'" class="captions"><img src="'+item+'" class="thumb"></li>'});

            $modal.find('.carousel-inner').html(images)

            if (images.length > 1 ) {
                $modal.find('.carousel-inner')
                    .append('<a class="carousel-control-prev carousel-control" href="#carousel" role="button" data-slide="prev"><div class="carousel-control-icon"><i class="fas fa-chevron-left"></i></div></a>')
                    .append('<a class="carousel-control-next carousel-control" href="#carousel" role="button" data-slide="next"><div class="carousel-control-icon"><i class="fas fa-chevron-right"></i></div></a>');
                $modal.find('.carousel-indicators').html(thumbs);
            }

            $('.carousel-item').first().addClass('active');
            $('.captions').first().addClass('active');
            $('.carousel').carousel({interval: false});
        } else {
            $modal.find('.carousel-inner').html('<div class="w-100 t-center pb-2 pt-5 px-5"><i class="far fa-image font-30 grey-light"></i></div>');
        }

        $modal.find('.away-link').attr('href', target.data('away'));

        const data = new FormData();

        data.append('_token', $('input[name=_token]').first().val());
        data.append('props',  JSON.stringify(target.data('attributes')));

        $.ajax({
            async: true,
            type: "POST",
            dataType: "json",
            contentType: false,
            url: target.data('url'),
            data: data,
            processData: false,
            success: function (response) {
                console.log(response)
                const attributes = response.map(function (item) {
                    return `<li><span>${item.name}</span><span>${item.value.join(', ')}</span></li>`;
                });

                $('.attributes').html(attributes);
            },
        })
    })
})
