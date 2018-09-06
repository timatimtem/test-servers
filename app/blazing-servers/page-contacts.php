



<?php get_header(); ?>



<header class="header">


    <div class="header-inner">



        <nav class="top-navigation">


            <div class="nav-burger" onclick="myFunction(this)">
                <div class="bar1"></div>
                <div class="bar2"></div>
                <div class="bar3"></div>
            </div>




            <a href="" class="logo-link">

            </a>


            <?php
            wp_nav_menu( array(
                'theme_location' => 'top-navigation',
                'menu'            => '',
                'container'       => 'false',
                'container_class' => 'top-menu',
                'container_id'    => 'top-navigation-container',
                'menu_class'      => 'nav-menu',
                'menu_id'         => 'top-navigation-ul',
//    'echo'            => true,
//    'fallback_cb'     => 'wp_page_menu',
//    'before'          => '',
//    'after'           => '',
//    'link_before'     => '',
//    'link_after'      => '',
//    'items_wrap'      => '%3$s',
//    'depth'           => 0,
//    'walker'          => '',
            ))
            ?>





        </nav>

        <div class="container">


            <h1 class="home-heading">Submit a ticket</h1>

            <h4 class="home-description">
                Need help with something? Please fill out the information below and we will get back to you as soon as we can!            </h4>




        </div>


    </div>



</header>



<section class="contact-form">

    <form action="http://support.blazingseollc.com/support/tickets/new">


        <div class="container">

            <div class="contact-form-wrap">


                <div class="input-wrap">


                    Requester*: <input required type="email" name="helpdesk_ticket[email]" PLACEHOLDER="Email">
                </div>



                <div class="input-wrap">


                    Subject*: <input required type="text" name="helpdesk_ticket[subject]" PLACEHOLDER="Reason For Contacting Us">
                </div>



                <div class="input-wrap">


                    PayPal Email: <input type="email" name="helpdesk_ticket[custom_field][paypal_email_455547]" PLACEHOLDER="Paypal Email (If different from above)">
                </div>

                <div class="input-wrap">


                    Do you currently have a server with us?
                    <select name="helpdesk_ticket[custom_field][cf_how_many_proxies_do_you_currently_have_or_are_considering_purchasing_455547]">
                        <option value="">Yes</option>
                        <option value="">No</option>
                    </select>
                </div>



                <div class="input-wrap">


                    Type of Support:
                    <select name="helpdesk_ticket[ticket_type]">
                        <option value="server">Server</option>
                        <option value="proxy">Proxy</option>
                        <option value="billing">Billing</option>
                        <option value="sales">Sales</option>
                        <option value="general">General</option>
                    </select>
                </div>





                <div class="input-wrap">


                    Description: <textarea  name="helpdesk_ticket[ticket_body_attributes][description_html]" PLACEHOLDER="Description of Problem or Concern
"></textarea>
                </div>


                <div class="input-wrap ml-42">

                    <input type="file" name="file" id="file" class="inputfile" data-multiple-caption="{count} files selected" multiple />
                    <label for="file"><span>+ attach a file</span></label>

                </div>


                <div class="package-btn-wrap">
                    <input type="submit" class="package-btn package-buy-btn" />

                </div>



            </div>

            <p style="font-family: MetropolisMedium, sans-serif;
    font-size: 14px;
    color: #1754b2;
    text-align: center;
    position: relative;
    top: -54px;">You can also email us directly at <a href="support@blazingseollc.com">support@blazingseollc.com</a></p>

        </div>

    </form>
</section>


<script>
    var inputs = document.querySelectorAll( '.inputfile' );
    Array.prototype.forEach.call( inputs, function( input )
    {
        var label	 = input.nextElementSibling,
            labelVal = label.innerHTML;

        input.addEventListener( 'change', function( e )
        {
            var fileName = '';
            if( this.files && this.files.length > 1 )
                fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
            else
                fileName = e.target.value.split( '\\' ).pop();

            if( fileName )
                label.querySelector( 'span' ).innerHTML = fileName;
            else
                label.innerHTML = labelVal;
        });
    });
</script>

<?php the_post() ?>
<?php the_content(); ?>



<?php get_footer();?>




