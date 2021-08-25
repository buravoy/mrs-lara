import $ from "jquery";

import 'bootstrap'

$(function (){

    const
        $modal = $('#images-popup'),
        $allFilters = $('.show-all-filters'),
        $sorting = $('select[name=sort]'),
        $paginate = $('select[name=paginate]'),
        $filters = $('.filter'),
        $filtersList = $('.filters-list');

    const $selectedFilters = $filters.find('.btn-filter.active').clone()

    $filtersList.each(function (){
       const $t = $(this);
       if(!$t.children().length) $t.closest('.filters-group').remove();
    });


    $(document).on('click', '.add-more', function () {
        const
            $t = $(this),
            href = $t.data('href'),
            url = $t.data('url'),
            current = $t.data('current'),
            last = $t.data('last'),
            next = +current + 1,
            $paginationBlock = $('.pagination-block');


        console.log(current)


        $.ajax({
            async: true,
            type: "GET",
            url: href,
            processData: false,
            success: function (response) {
                const
                    jQueryObj = $(response),
                    products = jQueryObj.find('.product-list').children(),
                    pagination = jQueryObj.find('.pagination-block').children();

                $('.product-list').append(products);
                $paginationBlock.children().remove();

                if (next < last) $paginationBlock.append(pagination);

                $t.attr('data-href', url + '?page=' + next);
                $t.attr('data-current', next);

                window.history.pushState(null, null, href);
            },
        })

    })


    $('.selected-filters').append($selectedFilters)

    $sorting.on('change', function () {
        const val = $(this).val();
        document.cookie = `sorting=${val}; path=/; max-age=315360000`
        location=location;
    })

    $paginate.on('change', function () {
        const val = $(this).val();
        document.cookie = `pagination=${val}; path=/; max-age=315360000`
        location=location;
    })

    $allFilters.on('click', function (){
        const $t = $(this);

        $t.toggleClass('show').closest('.filters-group').find('.filters-list').toggleClass('show');

        if($t.hasClass('show')) $t.html('Скрыть <i class="ml-2 fas fa-chevron-up"></i>');
        else $t.html('Показать все <i class="ml-2 fas fa-chevron-down"></i>');
    })

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
