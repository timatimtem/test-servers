"use strict";


function Total(price, ssd, ram) {


    this.price = price;
    this.ssd = ssd;
    this.ram = ram;


    this.get = function() {
        return this.price + this.ssd + this.ram;
    }

    this.monthly =function () {
        return this.get() -10;
    }


    this.setRAM = function (x) {

        this.ram = x;
    }

    this.setSSD = function (x) {

        this.ssd = x;
    }



}


var total = new Total(74, 13, 13);




(function () {
    // body of the function
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.maxHeight){

                //
                // panel.style.maxHeight = null;
                // panel.style.padding = "0em";

                panel.classList.toggle("active")

            } else {
                // panel.style.maxHeight = panel.scrollHeight + "px";
                // panel.style.padding = "1.5em";

                panel.classList.toggle("active");
            }
        });
    }

}());

(function () {
    var x, i, j, selElmnt, a, b, c;
    /*look for any elements with the class "custom-select":*/
    x = document.getElementsByClassName("custom-select");
    for (i = 0; i < x.length; i++) {
        selElmnt = x[i].getElementsByTagName("select")[0];
        /*for each element, create a new DIV that will act as the selected item:*/
        a = document.createElement("DIV");
        a.setAttribute("class", "select-selected");
        a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
        a.classList.add(selElmnt.options[selElmnt.selectedIndex].value);
        x[i].appendChild(a);
        /*for each element, create a new DIV that will contain the option list:*/
        b = document.createElement("DIV");
        b.setAttribute("class", "select-items select-hide");
        for (j = 0; j < selElmnt.length; j++) {
            /*for each option in the original select element,
            create a new DIV that will act as an option item:*/
            c = document.createElement("DIV");
            c.innerHTML = selElmnt.options[j].innerHTML;
            c.addEventListener("click", function(e) {
                /*when an item is clicked, update the original select box,
                and the selected item:*/
                var y, i, k, s, h;
                s = this.parentNode.parentNode.getElementsByTagName("select")[0];
                h = this.parentNode.previousSibling;
                for (i = 0; i < s.length; i++) {
                    if (s.options[i].innerHTML == this.innerHTML) {
                        s.selectedIndex = i;
                        h.innerHTML = this.innerHTML;

                        y = this.parentNode.getElementsByClassName("same-as-selected");
                        for (k = 0; k < y.length; k++) {
                            y[k].removeAttribute("class");
                        }
                        this.setAttribute("class", "same-as-selected");
                        break;
                    }
                }
                h.click();
            });
            b.appendChild(c);
        }
        x[i].appendChild(b);
        a.addEventListener("click", function(e) {
            /*when the select box is clicked, close any other select boxes,
            and open/close the current select box:*/
            e.stopPropagation();
            closeAllSelect(this);
            this.nextSibling.classList.toggle("select-hide");
            this.classList.toggle("select-arrow-active");
        });
    }
    function closeAllSelect(elmnt) {
        /*a function that will close all select boxes in the document,
        except the current select box:*/
        var x, y, i, arrNo = [];
        x = document.getElementsByClassName("select-items");
        y = document.getElementsByClassName("select-selected");
        for (i = 0; i < y.length; i++) {
            if (elmnt == y[i]) {
                arrNo.push(i)
            } else {
                y[i].classList.remove("select-arrow-active");
            }
        }
        for (i = 0; i < x.length; i++) {
            if (arrNo.indexOf(i)) {
                x[i].classList.add("select-hide");
            }
        }
    }
    /*if the user clicks anywhere outside the select box,
    then close all select boxes:*/
    document.addEventListener("click", closeAllSelect);
}());


function get_parsed_string(str) {
    var res = str.split(" ", 4);


    var priceToAdd = res[1];
    priceToAdd = parseInt(priceToAdd.substring(1));

    var value = res[0].replace('GB' ,'');
    return {
        priceToAdd : priceToAdd,
        val1 : value
    };
}

(function () {

    $('.total-price').html(total.get());



    $('.location-anchor').bind("DOMSubtreeModified",function(){


            $('.total-country').html(this.innerHTML);
            $('#location-input').val(this.innerHTML);

    });

    $('.ssd-anchor').bind("DOMSubtreeModified",function(){
        if (this.innerHTML){

            $('.total-ssd').html(get_parsed_string(this.innerHTML).val1);
            $('.ssd-extra-price-span').html(get_parsed_string(this.innerHTML).priceToAdd);

            // alert("1." + get_parsed_string(this.innerHTML)[2]);
            total.setSSD(+get_parsed_string(this.innerHTML).priceToAdd);


            $('#ssd-input').val(this.innerHTML);


            $(".monthly-price-span").html(total.monthly());

            $('.total-price').html(total.get());
            // alert(total.ssd)
        }


    });

    $('.os-anchor').bind("DOMSubtreeModified",function(){
        if(this.innerHTML){
            $('.total-os').html(this.innerHTML);
            $('#os-input').val(this.innerHTML);

        }

    });

    $('.ram-anchor').bind("DOMSubtreeModified",function(){


        if (this.innerHTML){

            $('.total-ram').html(get_parsed_string(this.innerHTML).val1);
            $('.ram-extra-price-span').html(get_parsed_string(this.innerHTML).priceToAdd);

            // alert("1." + get_parsed_string(this.innerHTML)[2]);
            total.setRAM(+get_parsed_string(this.innerHTML).priceToAdd);


            $('#ram-input').val(this.innerHTML);

            $(".monthly-price-span").html(total.monthly());
            $('.total-price').html(total.get());
            // alert(total.ssd)
        }
    });




}());


function change_package( item) {

    if (item == 'Standart'){
        $(".ssd-custom-select .select-items div:nth-child(1)").click();
        $(".ram-custom-select .select-items div:nth-child(1)").click();


    }

    if (item == 'Enchanced'){
        $(".ssd-custom-select .select-items div:nth-child(2)").click();
        $(".ram-custom-select .select-items div:nth-child(2)").click();


    }
    if (item == 'Enterprise'){
        $(".ssd-custom-select .select-items div:nth-child(3)").click();
        $(".ram-custom-select .select-items div:nth-child(4)").click();


    }
}




$(document).ready(function() {
    var urlParse = window.location.href.split('/');

    if (urlParse[urlParse.length - 1] == '#standard') {


        change_package("Standart");
        $('html, body').animate({
            scrollTop: $('#server-configuration').offset().top
        }, 200);


    }

    if (urlParse[urlParse.length - 1] == '#enhanced') {


        change_package("Enchanced");

        $('html, body').animate({
            scrollTop: $('#server-configuration').offset().top
        }, 200);


    }

    if (urlParse[urlParse.length - 1] == '#enterprise') {

        change_package("Enterprise");

        $('html, body').animate({
            scrollTop: $('#server-configuration').offset().top
        }, 200);

    }
});

