import './sections/user-menu';
import './sections/categories-tree';
import './pages/products'
import './sections/ajax-search'

import $ from 'jquery';

$(function () {
    const $filterWrapper = $('.main-filter-wrapper');

    $filterWrapper.css({
        'top': `-${ $filterWrapper.height() - $(window).height() + 100 }px`
    });
});