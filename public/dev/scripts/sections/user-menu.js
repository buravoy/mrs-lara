import $ from 'jquery';

$(function (){
    $('.user-menu-toggle').on('click', function (){
        const $t = $(this);
        $t
            .toggleClass('active')
            .next('.user-menu-drop')
            .slideToggle(100);

        return false;
    })


    $('.main-menu-toggle').on('click', function () {
        const $t = $(this)

        $t.find('.menu-button-text').fadeToggle(200)
        $('.categories-menu').slideToggle(200)
    })
})
