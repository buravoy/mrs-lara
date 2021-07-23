import $ from 'jquery';

$(function(){
    $('.category-menu-toggle').on('click', function (){
        const
            $t = $(this),
            $toggle = $('.category-menu-toggle'),
            $thisWrapper = $t.next('.drop-categories-wrapper');

        $toggle.not($t).removeClass('active');
        $t.toggleClass('active');

        $toggle.not($t).find('i').removeClass('rotate');
        $t.find('i').toggleClass('rotate');


        $('.drop-categories-wrapper').not($thisWrapper).slideUp(200);
        $thisWrapper.slideToggle(200)
    })
})