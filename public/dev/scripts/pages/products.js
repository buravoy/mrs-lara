import $
    from "jquery";

import 'bootstrap'

$(function () {

    const
        $modal = $('#images-popup'),
        $allFilters = $('.show-all-filters'),
        $sorting = $('select[name=sort]'),
        $paginate = $('select[name=paginate]'),
        $filters = $('.filter'),
        $filtersList = $('.filters-list'),
        $filterButton = $('.btn-filter');


    const $selectedFilters = $filters.find('.btn-filter.active').clone()

    $filtersList.each(function () {
        const $t = $(this);
        if (!$t.children().length) $t.closest('.filters-group').remove();
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
        location = location;
    })

    $paginate.on('change', function () {
        const val = $(this).val();
        document.cookie = `pagination=${val}; path=/; max-age=315360000`
        location = location;
    })

    $allFilters.on('click', function () {
        const $t = $(this);

        $t.toggleClass('show').closest('.filters-group').find('.filters-list').toggleClass('show');

        if ($t.hasClass('show')) $t.html('Скрыть <i class="ml-2 fas fa-chevron-up"></i>');
        else $t.html('Показать все <i class="ml-2 fas fa-chevron-down"></i>');
    })

    $(document).on('click', '.img-popup', function () {
        $modal.modal('show', $(this))
    })

    $modal.on('show.bs.modal', function (e) {
        const $mod = $(this);

        const target = e.relatedTarget;
        $mod.find('.modal-title').text(target.data('title'));
        $mod.find('.carousel-inner').html('');
        $mod.find('.carousel-indicators').html('');

        const href = target.data('href').substr(0, target.data('href').indexOf('ulp='));

        if (target.data('source')) {
            const images = target.data('source').map(function (item) {
                return `<div class="carousel-item" style="background-image: url('${item}')">
                            <a href="${href}ulp=${item}" target="_blank"><i class="fas fa-search-plus"></i></a>
                        </div>`
            });
            const thumbs = target.data('source').map(function (item, key) {
                return `<li data-target="#carousel" data-slide-to="${key}" class="captions"><img src="${item}" class="thumb"></li>`
            });

            $mod.find('.carousel-inner').html(images)

            if (images.length > 1) {
                $mod.find('.carousel-inner')
                    .append('<a class="carousel-control-prev carousel-control" href="#carousel" role="button" data-slide="prev"><div class="carousel-control-icon"><i class="fas fa-chevron-left"></i></div></a>')
                    .append('<a class="carousel-control-next carousel-control" href="#carousel" role="button" data-slide="next"><div class="carousel-control-icon"><i class="fas fa-chevron-right"></i></div></a>');
                $mod.find('.carousel-indicators').html(thumbs);
            }

            $mod.find('.carousel-item').first().addClass('active');
            $mod.find('.captions').first().addClass('active');
            $mod.find('.carousel').carousel({interval: false});
        } else {
            $mod.find('.carousel-inner').html('<div class="w-100 t-center pb-2 pt-5 px-5"><i class="far fa-image font-30 grey-light"></i></div>');
        }

        $mod.find('.away-link').attr('href', target.data('away'));

        const data = new FormData();

        data.append('_token', $('input[name=_token]').first().val());
        data.append('props', JSON.stringify(target.data('attributes')));

        $.ajax({
            async: true,
            type: "POST",
            dataType: "json",
            contentType: false,
            url: target.data('url'),
            data: data,
            processData: false,
            success: function (response) {
                const attributes = response.map(function (item) {
                    return `<li><span>${item.name}</span><span>${item.value.join(', ')}</span></li>`;
                });
                $('.attributes').html(attributes);
            },
        })
    })

    $(document).on('click', '.btn-filter', function () {
        const
            $t = $(this),
            href = $t.data('href'),
            url = $t.closest('.filter').data('url'),
            token = $('input[name=_token]').val();

        const data = new FormData();

        data.append('href', href)
        data.append('_token', token)

        $.ajax({
            async: true,
            type: "POST",
            dataType: "json",
            contentType: false,
            url: url,
            data: data,
            processData: false,
            success: function (response) {

                $('.ajax-filters').html(response)

                console.log(response)

                const $html = $(response);
                const $filters = $html.find('.filters-group');


                $filters.each(function() {
                    const $t = $(this);


                        // .find('.filters-list')
                        // .children()
                        // .remove()

                    // $(`#${$t.attr('id')}.filters-group`)
                    //     .find('.filters-list')
                    //     .append($t.find('.filters-list').children())



                })
            },
        })

    })
})
