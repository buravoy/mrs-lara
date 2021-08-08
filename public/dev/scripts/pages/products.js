import $ from "jquery";

import 'bootstrap'

$(function (){

    const $modal = $('#images-popup')

    $('.product-img').on('click', function (){
        $modal.modal('show', $(this))
    })

    $modal.on('show.bs.modal', function (e) {
        const target = e.relatedTarget;


        $modal.find('.modal-title').text(target.data('title'))

        const images = target.data('source').map(function (item) {
            return '<div class="carousel-item" style="background-image: url('+item+')"></div>';
        })

        const thumbs = target.data('source').map(function (item,key) {
            return '<li data-target="#carousel" data-slide-to="'+key+'" class="captions"><img src="'+item+'" class="thumb"></li>';
        })

        $modal.find('.carousel-inner')
            .html(images)
            .append('<a class="carousel-control-prev carousel-control" href="#carousel" role="button" data-slide="prev"><div class="carousel-control-icon"><i class="fas fa-chevron-left"></i></div></a>')
            .append('<a class="carousel-control-next carousel-control" href="#carousel" role="button" data-slide="next"><div class="carousel-control-icon"><i class="fas fa-chevron-right"></i></div></a>');

        $modal.find('.carousel-indicators').html(thumbs);

        $('.carousel-item').first().addClass('active');
        $('.captions').first().addClass('active');
        $('.carousel').carousel({
            interval: false
        });
    })
})
