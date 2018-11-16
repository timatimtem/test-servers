<footer>



    <div class="footer-nav-wrap">


        <div class="footer-nav-item">


            <h4>Products:</h4>
            
            <ul>

                <li><a href="/hosting/vps/features/">VPS</a></li>
                <li><a href="/hosting/dedicated/features/">Dedicated Server</a></li>
                <li><a href="/hosting/bulk-ips/">Bulk IPs</a></li>
            </ul>
        </div>

        <div class="footer-nav-item">


            <h4>Pricing:</h4>

            <ul>

                <li><a href="/hosting/vps/pricing">VPS</a></li>
                <li><a href="/hosting/dedicated/pricing">Dedicated Servers</a></li>
            </ul>
        </div>

        <div class="footer-nav-item">


            <h4>Resources:</h4>

            <ul>

                <li><a href="/hosting/contact/">Contact</a></li>
                <li><a href="https://blazingseollc.com/blog/">Blog</a></li>
                <li><a href="https://www.blazingseollc.com/privacy-policy.html">Privacy Policy</a></li>
            </ul>
        </div>

        <div class="footer-nav-item">


            <h4>Contact Us:</h4>

            <ul class="footer-nav-img-wrap">

                <li><a href="https://blazingseollc.com/"><span class="footer-nav-img logo"></span></a></li>
                <li><a href="https://www.facebook.com/blazingseo/"><span class="footer-nav-img facebook"></span></a></li>
                <li><a href="https://twitter.com/blazingseo"><span class="footer-nav-img twitter"></span></a></li>
            </ul>
        </div>
    </div>

    <div class="copyright">
        Copyright 2018 <span class="span-row-breaker">Blazing Servers | All Rights Reserved</span>
    </div>

</footer>


<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri('')?>/libs/html5shiv/es5-shim.min.js"></script>
<script src="<?php echo get_template_directory_uri('')?>/libs/html5shiv/html5shiv.min.js"></script>
<script src="<?php echo get_template_directory_uri('')?>/libs/html5shiv/html5shiv-printshiv.min.js"></script>
<script src="<?php echo get_template_directory_uri('')?>/libs/respond/respond.min.js"></script>
<![endif]-->






<script  src="<?php echo get_template_directory_uri('')?>/js/jquery/dist/jquery.min.js"></script>
<script>
    $(document).on('click', 'a[href^="#"]', function (event) {
        event.preventDefault();

        $('html, body').animate({
            scrollTop: $($.attr(this, 'href')).offset().top
        }, 500);
    });




    function myFunction(x) {

        x.classList.toggle("change");

        $(".nav-menu").toggleClass("active");

        $(".top-navigation").toggleClass("active")


    }





    function togglePackage(event, x) {

        if ($(window).width() < 960) {
        }
        else {


            $(x).parent().find(".panel-body").toggleClass("active")
        }

    }


    $(".inputfile").on("change", function (e) {

        $(".ml-42 label span").html(e.target.value)
    })






</script>




<?php
/* Always have wp_footer() just before the closing </body>
 * tag of your theme, or you will break many plugins, which
 * generally use this hook to reference JavaScript files.
 */
wp_footer();
?>
    </body>
</html>


