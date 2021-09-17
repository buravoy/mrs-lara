import $
    from "jquery";

import 'bootstrap'

$(function () {

    const
        $modal = $('#images-popup'),
        $sorting = $('select[name=sort]'),
        $paginate = $('select[name=paginate]'),
        $filters = $('.filter.common'),
        $filterField = $('.filter'),
        $filtersList = $('.filters-list');




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

    $(document).on('click', '.selected-filters > .btn-filter', function () {
        location = window.location.origin + '/' +$(this).data('href');
    })

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

    $(document).on('click', '.show-all-filters', function () {
        const $t = $(this);

        $t.toggleClass('show').closest('.filters-group').find('.filters-list').toggleClass('show');

        if ($t.hasClass('show')) $t.html('Скрыть <i class="ml-2 fas fa-chevron-up"></i>');
        else $t.html('Показать все <i class="ml-2 fas fa-chevron-down"></i>');

        const $filterWrapper = $('.main-filter-wrapper');
        $filterWrapper.css({
            'top': `-${ $filterWrapper.height() - $(window).height() + 100 }px`
        });
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

        $filterField.addClass('loader').fadeTo("fast", 0.3 );

        $.ajax({
            async: true,
            type: "POST",
            dataType: "json",
            contentType: false,
            url: url,
            data: data,
            processData: false,
            success: function (response) {

                const $html = $(response.view);
                const $ajaxFilters = $('.ajax-filters');
                const $groups = $ajaxFilters.find('.filters-group')


                if (response.message) {
                    console.log('error')
                    $html.find('a.filter-result').addClass('error-message').html(response.message);
                }


                $html.find('.filters-list').each(function () {
                    const $t = $(this);
                    $t.attr('data-all', true)
                    if (!$t.children().length) $t.closest('.filters-group').remove();
                });

                const $modalHref = $html.find('a.filter-modal-href');

                $groups.each(function() {
                    const $t = $(this);
                    const slug = $t.attr('id');
                    const isShow = $t.find('.filters-list').hasClass('show')

                    if ( isShow ) {
                        $html.find(`#${slug}.filters-group`).find('.filters-list').addClass('show')
                        $html.find(`#${slug}.filters-group`).find('.show-all-filters').html('Скрыть <i class="ml-2 fas fa-chevron-up"></i>')
                    }
                })

                $ajaxFilters.html('').html($html.children())
                $ajaxFilters.closest('.modal-content').find('.filter-modal-button').html('').html($modalHref)
                $filterField.removeClass('loader').fadeTo("fast", 1 );

                const $filterWrapper = $('.main-filter-wrapper');
                $filterWrapper.css({
                    'top': `-${ $filterWrapper.height() - $(window).height() + 100 }px`
                });
            },
        })
    })

    $('.filter-show-categories').on('click', function (){
        $('.filter-categories').slideToggle(200);
    })
})
