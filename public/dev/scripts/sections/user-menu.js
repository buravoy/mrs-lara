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
})