"use strict";




(function () {

    $('.location-anchor').bind("DOMSubtreeModified",function(){
        $('.total-country').html(this.innerHTML)
    });

    $('.ssd-anchor').bind("DOMSubtreeModified",function(){
        $('.total-ssd').html(this.innerHTML)
    });

    $('.os-anchor').bind("DOMSubtreeModified",function(){
        $('.total-os').html(this.innerHTML)
    });

    $('.ram-anchor').bind("DOMSubtreeModified",function(){
        $('.total-ram').html(this.innerHTML)
    });
}());




