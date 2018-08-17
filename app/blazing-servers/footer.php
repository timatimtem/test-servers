<footer>



    <div class="footer-nav-wrap">


        <div class="footer-nav-item">


            <h4>Pricing</h4>
            
            <ul>

                <li><a href="">VPS</a></li>
                <li><a href="">Dedicated Server</a></li>
                <li><a href="">Sneaker Server</a></li>
            </ul>
        </div>

        <div class="footer-nav-item">


            <h4>Company</h4>

            <ul>

                <li><a href="">About Us</a></li>
                <li><a href="">Blog</a></li>
                <li><a href="">Contacts</a></li>
                <li><a href="">Careers</a></li>
            </ul>
        </div>

        <div class="footer-nav-item">


            <h4>Resources</h4>

            <ul>

                <li><a href="">Privacy Policy</a></li>
                <li><a href="">FAQ</a></li>
            </ul>
        </div>

        <div class="footer-nav-item">


            <h4>Contact Us</h4>

            <ul class="footer-nav-img-wrap">

                <li><a href=""><span class="footer-nav-img"></span></a></li>
                <li><a href=""><span class="footer-nav-img"></span></a></li>
                <li><a href=""><span class="footer-nav-img"></span></a></li>
            </ul>
        </div>
    </div>

</footer>

<script async
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
<script>
    function myFunction(x) {

        x.classList.toggle("change");

        $(".nav-menu").toggleClass("active");

        $(".top-navigation").toggleClass("active")


    }
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


