<?php get_header();?>




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

                <img src="<?php echo get_template_directory_uri();?>/img/bulk/home.png" alt="ds-features">



                <div class="vps-home-header-wrap">

                    <h1 class="section-header">Bulk IP Leasing</h1>

                    <p class="section-description">
                        Blazing SEO is excited to announce a new service for you, Bulk IP leasing! If you are in need of leasing large number of IPs, please use the contact form below to get a customized pricing quote from us today!                    </p>


                    <a href="#bulk-contact" target="_blank" class="vps-home-btn">Get Your Quote Today!</a>
                </div>

            </div>


        </div>



    </header>

    <section class="section-bulk-benefits">


        <h2 class="section-title">

            Features
        </h2>


        <div class="container">



            <div class="bulk-benefit">

                <div class="benefit-header">

                    <h3 class="benefit-title">Clean IP Address</h3>
                    <img src="<?php echo get_template_directory_uri();?>/img/bulk/f-1.png" alt="ip">
                </div>



                <p class="benefit-description">
                    We offer clean IP addresses that have never been used before to ensure the best possible performance. We do this to ensure that these IPs will work exactly as you need them to for your use cases.                </p>

            </div>


            <div class="bulk-benefit">

                <div class="benefit-header">

                    <h3 class="benefit-title">Multiple Locations</h3>
                    <img src="<?php echo get_template_directory_uri();?>/img/bulk/f-locations.png" alt="locations">
                </div>



                <p class="benefit-description">
                    We currently offer IP leasing at 3 different locations. New Jersey, Los Angeles, and Chicago are ready for use for your leasing needs. We plan to expand to more locations in the near future!
                </p>
            </div>



            <div class="bulk-benefit">

                <div class="benefit-header">

                    <h3 class="benefit-title">Proven Track Record</h3>
                    <img src="<?php echo get_template_directory_uri();?>/img/bulk/f-proven.png" alt="proven">
                </div>



                <p class="benefit-description">
                    Blazing SEO has a proven track record of providing quality products to our customers. We know the industry and know how important uptime is for you!                </p>

            </div>


            <div class="bulk-benefit">

                <div class="benefit-header">
                    <h3 class="benefit-title">Tier 1 Data Center</h3>
                    <img src="<?php echo get_template_directory_uri();?>/img/bulk/f-phone.png" alt="phone">
                </div>



                <p class="benefit-description">
                    Our tier 1 data center locations allow for maximum uptime for your needs. We also can offer top of the line security through these data centers.
                </p>

            </div>
        </div>

    </section>


    <section class="work">
        <div class="container">

            <div class="left">

                <h3 class="section-header">
                    How It Works
                </h3>

                <div class="text-block">
                    <h4>Letter of Authorization </h4>
                    <p>

                        Want to host the IPs on your own network? Then this method would be great for you!
                        We will provide you with a LOA that will allow you to host your IPs on your own network.
                    </p>
                </div>

                <div class="text-block">
                    <h4>Blazing SEO Hosted IPs</h4>
                    <p>
                        Looking for Bulk IP leasing without all the hassle? Then our Blazing SEO Hosting option is for you! Simply let us know how many IPs you need, and we will set up a IP and dedicated server just for you!
                    </p>
                </div>


            </div>

            <div class="right">


                <h3 class="section-header">
                    Pricing
                </h3>

                <div class="text-block">
                    <h5>
                        Letter of Authorization:
                    </h5>
                    <div class="text-block-price">
                        As low as $0.60/ip/mo


                    </div>

                    <div class="text-block-contacts">
                        <i class="fas fa-info-circle"></i>
                        <span>
                            LOA emailed upon purchase

                        </span>
                        <a href="#bulk-contact" class="btn">
                            Contact Us
                        </a>
                    </div>
                </div>


                <div class="text-block">
                    <h5>
                        Blazing SEO Hosted IP Leasing:
                    </h5>
                    <div class="text-block-price">

                        As low as $0.40/ip/mo

                    </div>

                    <div class="text-block-contacts">
                        <i class="fas fa-info-circle"></i>
                        <span>
Dedicated Server Lease Required

                        </span>
                        <a href="#bulk-contact" class="btn">
                            Contact Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <section class="contact-section">


        <div class="container">
            <div class="left">

                <div class="left-header">
                    <h5>
                        Contact Us Today!
                    </h5>


                    <img  class="desktop-none" src="<?php echo get_template_directory_uri();?>/img/bulk/plane.png" alt="">
                </div>

                <p>
                    If you are interested in a pricing quote, please fill out this form in full. After receiving your information, we will then generate a customized price for you. To ensure a quick turnaround on your quote, please be sure to include all requested information.
                </p>


                <div class="img-wrap desktop-view">
                    <img  class="plane plane-big" src="<?php echo get_template_directory_uri();?>/img/bulk/plane.png" alt="">
                    <img  class="plane plane-medium" src="<?php echo get_template_directory_uri();?>/img/bulk/plane.png" alt="">
                    <img  class=" plane plane-small" src="<?php echo get_template_directory_uri();?>/img/bulk/plane.png" alt="">

                </div>
            </div>

            <div id="bulk-contact" class="right">
                <?php echo do_shortcode('[contact-form-7 id="89" title="BulkIps"]'); ?>

            </div>
        </div>
    </section>


<?php the_post() ?>
<?php the_content(); ?>



<?php get_footer();?>