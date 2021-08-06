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

        $t.find('#menu-closed').fadeToggle(200)
        $t.find('#menu-shown').fadeToggle(200)
    })
})