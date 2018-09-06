
function togglePackage(event, x) {

    if ($(window).width() < 960) {
    }
    else {


        $(x).parent().find(".panel-body").toggleClass("active")
    }

}







var vpsRedirects = {

    "server2":{

        "Los Angeles": 24,
        "New York": 35,

        "Dallas": 113,
        "Chicago": 29607,
    },

    "server3":{

        "Los Angeles": 25,
        "New York": 36,


        "Dallas": 114,
        "Chicago": 29608,
    },

    "server4":{

        "Los Angeles": 26,
        "New York": 37,

        "Dallas": 115,
        "Chicago": 29609,
    },






    "server6":{

        "Los Angeles": 27,
        "New York": 38,

        "Dallas": 116,
        "Chicago": 29610,
    },



    "server8":{

        "Los Angeles": 28,
        "New York": 39,

        "Dallas": 117,
        "Chicago": 29612,
    },


    "server10":{

        "Los Angeles": 31,
        "New York": 40,

        "Dallas": 118,
        "Chicago": 29613,
    },




    "server14":{

        "Los Angeles": 238,
        "New York": 42,


        "Dallas": 119,
        "Chicago": 29614,
    },


    'server18':{

        "Los Angeles": 239,
        "New York": 43,

        "Dallas": 121,
        "Chicago": 29617,
    },

    'server24':{

        "Los Angeles": 32,
        "New York": 44,

        "Dallas": 122,
        "Chicago": 29618,
    },
}


var url = "https://billing.blazingseollc.com/hosting/cart.php?a=add&amp;pid=";


$('.server2').bind("DOMSubtreeModified",function(){

    var location = this.innerHTML;


    if (location){

        alert(vpsRedirects.server2[location]);


        $(".server2-buy").attr("href" , url + vpsRedirects.server2[location]);

    }


});

$('.server3').bind("DOMSubtreeModified",function(){

    var location = this.innerHTML;


    if (location){

        alert(vpsRedirects.server3[location]);


        $(".server3-buy").attr("href" , url + vpsRedirects.server3[location]);

    }

});

$('.server4').bind("DOMSubtreeModified",function(){

    var location = this.innerHTML;


    if (location){

        alert(vpsRedirects.server4[location]);


        $(".server4-buy").attr("href" , url + vpsRedirects.server4[location]);

    }

})

$('.server6').bind("DOMSubtreeModified",function(){

    var location = this.innerHTML;


    if (location){

        alert(vpsRedirects.server6[location]);


        $(".server6-buy").attr("href" , url + vpsRedirects.server6[location]);

    }

});


$('.server8').bind("DOMSubtreeModified",function(){

    var location = this.innerHTML;


    if (location){

        alert(vpsRedirects.server8[location]);


        $(".server8-buy").attr("href" , url + vpsRedirects.server8[location]);

    }

});

$('.server10').bind("DOMSubtreeModified",function(){

    var location = this.innerHTML;


    if (location){

        alert(vpsRedirects.server10[location]);


        $(".server10-buy").attr("href" , url + vpsRedirects.server10[location]);

    }

});


$('.server14').bind("DOMSubtreeModified",function(){

    var location = this.innerHTML;


    if (location){

        alert(vpsRedirects.server14[location]);


        $(".server14-buy").attr("href" , url + vpsRedirects.server14[location]);

    }

});

$('.server18').bind("DOMSubtreeModified",function(){

    var location = this.innerHTML;


    if (location){

        alert(vpsRedirects.server18[location]);


        $(".server18-buy").attr("href" , url + vpsRedirects.server18[location]);

    }

});

$('.server24').bind("DOMSubtreeModified",function(){

    var location = this.innerHTML;


    if (location){

        alert(vpsRedirects.server24[location]);


        $(".server24-buy").attr("href" , url + vpsRedirects.server24[location]);

    }

});




$(document).ready(function() {
    var urlParse = window.location.href.split('/');

    if (urlParse[url.length - 1] == '#standard') {

        alert("X")
    }
});
