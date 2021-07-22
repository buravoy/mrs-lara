import $ from 'jquery';

$(function(){
    $('.category-menu-toggle').on('click', function (){
        const
            $t = $(this),
            $thisWrapper = $t.next('.drop-categories-wrapper');
        $('.drop-categories-wrapper').not($thisWrapper).slideUp(200)
        $thisWrapper.slideToggle(200)
    })
})