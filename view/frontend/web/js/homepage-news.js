define(['jquery'], function ($) {
    'use strict';

    return function (config, element) {
        $.get('/news/block', function (result) {
            element.innerHTML = result;
        });
    }
});