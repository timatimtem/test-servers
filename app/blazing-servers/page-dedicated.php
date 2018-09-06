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


            <h1 class="home-heading">Dedicated Servers</h1>

            <h4 class="home-description">
                High Performance Servers for Low Prices
            </h4>


        </div>


    </div>



</header>



<section class="packages-section" id="packages-dedicated">




    <div class="container">


        <div class="packages-wrap">

            <div  class="package-row ">

                <div class="package">


                    <h3 class="package-title trial-flex">Standard <span class="trial-title">Free Trial!</span></h3>

                    <div class="package-price-wrap">

                        <span>Starting At:</span>
                        <span class="product-price">$90</span>
                    </div>


                    <ul class="package-description-list">

                        <li>
                            <p>Speed</p><p>1 Gbps</p>
                        </li>
                        <li>
                            <p>RAM</p><p>8 GB</p>
                        </li>
                        <li>
                            <p>CPU</p><p>Intel E3-1240v5 </p>
                        </li>

                        <li>
                            <p>SSD</p><p>128 GB</p>
                        </li>

                        <li>
                            <p>Locations</p><p>Los Angeles, Dallas, Buffalo, Chicago</p>
                        </li>

                    </ul>


                    <div class="package-btn-wrap">
                        <a href="#server-configuration" class="standard-package-btn package-btn package-buy-btn" onclick="change_package('Standart')">Configure</a>
                    </div>
                </div>


                <div class="package">

                    <span class="package-popular">
                        POPULAR
                    </span>


                    <h3 class="package-title">Enhanced</h3>

                    <div class="package-price-wrap">

                        <span>Starting At:</span>
                        <span class="product-price">$116</span>
                    </div>


                    <ul class="package-description-list">

                        <li>
                            <p>Speed</p><p>1 Gbps</p>
                        </li>
                        <li>
                            <p>RAM</p><p>16 GB</p>
                        </li>
                        <li>
                            <p>CPU</p><p>Intel E3-1240v5</p>
                        </li>

                        <li>
                            <p>SSD</p><p>256 GB</p>
                        </li>

                        <li>
                            <p>Locations</p><p>Los Angeles, Dallas, Buffalo, Chicago</p>
                        </li>

                    </ul>


                    <div class="package-btn-wrap">
                        <a href="#server-configuration" class="enhanced-package-btn package-btn package-buy-btn" onclick="change_package('Enchanced');">Configure</a>
                    </div>
                </div>


                <div class="package">


                    <h3 class="package-title">Enterprise</h3>

                    <div class="package-price-wrap">

                        <span>Starting At:</span>
                        <span class="product-price">$220</span>
                    </div>


                    <ul class="package-description-list">

                        <li>
                            <p>Speed</p><p>1 Gbps</p>
                        </li>
                        <li>
                            <p>RAM</p><p>64 GB</p>
                        </li>
                        <li>
                            <p>CPU</p><p>Intel E3-1240v5</p>
                        </li>

                        <li>
                            <p>SSD</p><p>512 GB</p>
                        </li>
                        <li>
                            <p>Locations</p><p>Los Angeles, Dallas, Buffalo, Chicago</p>
                        </li>

                    </ul>


                    <div class="package-btn-wrap">
                        <a href="#server-configuration" class="enterprise-package-btn package-btn package-buy-btn" onclick="change_package('Enterprise')">Configure</a>
                    </div>
                </div>


            </div>
        </div>


    </div>

</section>



<section class="personal-configuration-section">

    <form action="https://billing.blazingseollc.com/hosting/index.php?m=whmcs_templates_adjustments&method=addProductToCart&pid=1846" METHOD="get">

        <input type="hidden" id="custId1" name="m" value="whmcs_templates_adjustments">
        <input type="hidden" id="custId2" name="method" value="addProductToCart">
        <input type="hidden" id="custId3" name="pid" value="1846">
        <input type="hidden" id="location-input" name="rfields[Location]" value="Los Angeles">
        <input type="hidden" id="os-input" name="rfields[OS]" value="Windows 2012 R2">
        <input type="hidden" id="ssd-input" name="rfields[SSD Size]" value="128GB $13.00 USD">
        <input type="hidden" id="ram-input" name="rfields[RAM Size]" value="8GB $13.00 USD">

        <div class="container">

        <div id="server-configuration"  class="left-side">

            <h2 class="section-header">Personal Server Configuration</h2>



            <div class="input-group">

                <h4 class="input-header">Location</h4>

                <div class="custom-select">
                    <select>
                        <option value="location-anchor">Los Angeles</option>
                        <option value="dallas">Dallas</option>
                        <option value="buffalo">Buffalo</option>
                        <option value="chicago">Chicago</option>

                    </select>
                </div>
            </div>



            <div class="input-group">

                <h4 class="input-header">OS</h4>

                <div class="custom-select" >
                    <select>

                        <option value="os-anchor" >Windows 2012 R2</option>
                        <option value="153">CentOS 6</option>
                        <option value="154">CentOS 7</option>
                        <option value="155">Fedora 22</option>
                        <option value="156">Ubuntu 16.04 LTS</option>
                        <option value="157">Debian Wheezy</option>
                        <option value="158">Debian Jessie</option>
                        <option value="184">Ubuntu 14.04 LTS</option>
                    </select>
                </div>
            </div>




            <div class="input-group">

                <h4 class="input-header">SSD Size</h4>

                <div class="custom-select ssd-custom-select">
                    <select class="xx" >
                        <option value="ssd-anchor">128GB $13.00 USD</option>
                        <option value="ssd-256">256GB $26.00 USD</option>
                        <option value="ssd-512">512GB $52.00 USD</option>

                    </select>


                </div>




            </div>



            <div class="input-group">

                <h4 class="input-header">RAM Size</h4>

                <div class="custom-select ram-custom-select" >
                    <select>
                        <option value="ram-anchor">8GB $13.00 USD</option>
                        <option value="ram-16">16GB $26.00 USD</option>
                        <option value="ram-32">32GB $52.00 USD</option>
                        <option value="ram-64">64GB $104.00 USD</option>

                    </select>
                </div>
            </div>



            <p class="left-info">
                We strive to have your server ready as soon as possible. However please allow up to 12 hours for delivery.
            </p>

        </div>

        <div class="right-side">


            <div class="package">


                <h3 class="package-title">Current Configuration</h3>


                <ul class="package-description-list">
                    <li>
                        <p>CPU</p><p>E3-1240v5 <span class=" extra-price-span ">($64)</span></p>
                    </li>
                    <li>
                        <p>Speed</p><p>1 Gbps </p>
                    </li>
                    <li>
                        <p>RAM</p><p><span class="total-ram">8 </span> GB <span class="extra-price-span ">($<span class="ram-extra-price-span">13</span>)</span></p>
                    </li>


                    <li>
                        <p>Hard Drive</p><p><span class="total-ssd">128 </span> GB <span class=" extra-price-span ">($<span class="ssd-extra-price-span">13</span>)</span></p>
                    </li>
                    <li>
                        <p>Locations</p><p><span class="total-country">Los Angeles </span></p>
                    </li>

                    <li>
                        <p>OS</p><p><span class="total-os">Windows 2012 R2 </span> </p>
                    </li>

                    <li style="border-bottom: 1px solid #cfdbef;">
                        <p>USA Support</p><p>24/7/365 </p>
                    </li>
                    <li>
                        <p>Setup Fees</p><p>One Time <span class=" extra-price-span ">($10)</span> </p>
                    </li>

                    <li style="border-bottom: 1px solid #cfdbef;">
                        <p>Price</p><p> Monthly<span class=" extra-price-span ">($<span class="monthly-price-span">90</span>)</span> </p>
                    </li>
                    <li>
                        <p class="total-price-label" style="width: 100%;">Total Price Today</p>
                    </li>
                </ul>


                <div class="package-btn-wrap">
                    <div class="total-text">
                        $<span class="total-price" >100</span>
                    </div>
                    <input type="submit" class="package-btn package-buy-btn" />
                </div>
            </div>
        </div>
    </div>
    </form>
</section>




<section class="benefit-section">



    <div class="container">

        <h2 class="benefits-section-title">Why Blazing SEO?</h2>

        <p class="benefits-section-description">
            We offer everything you need from a server provider! Blazing SEO offers you fast speeds, top of the line hardware, and unmatched customer support to ensure the best experience for you!

        </p>


        <div class="benefits-wrap">
            <div class="benefits-item">

                <div class="benefit-img benefit benefit-multiple ">

                </div>

                <div class="benefit-title">
                    Multiple Locations
                </div>
            </div>

            <div class="benefits-item">

                <div class="benefit-img benefit benefit-solid">

                </div>

                <div class="benefit-title">
                    Solid State Drives
                </div>
            </div>

            <div class="benefits-item">

                <div class="benefit-img benefit benefit-gbps">

                </div>

                <div class="benefit-title">
                    1 Gbps Speeds
                </div>
            </div>

            <div class="benefits-item">

                <div class="benefit-img benefit benefit-enterprise">

                </div>

                <div class="benefit-title">
                    Enterprise Hardware
                </div>
            </div>


            <div class="benefits-item">

                <div class="benefit-img benefit benefit-configuration">

                </div>

                <div class="benefit-title">
                    Varying Configurations
                </div>
            </div>

            <div class="benefits-item">

                <div class="benefit-img benefit benefit-support">

                </div>

                <div class="benefit-title">
                    24/7 Customer Support
                </div>
            </div>

            <div class="benefits-item">

                <div class="benefit-img benefit benefit-hardware">

                </div>

                <div class="benefit-title">
                    100% Owned Hardware
                </div>
            </div>

            <div class="benefits-item">

                <div class="benefit-img benefit benefit-match">

                </div>

                <div class="benefit-title">
                    Locations Matchs Our proxies
                </div>
            </div>
        </div>


    </div>



</section>


<section class="faq-section">

    <h2 class="section-header">
        Frequently Asked Questions
    </h2>

    <p class="section-description">
        New to our products? Check out these frequently asked questions!
    </p>
    
    <div class="container">



        <div class="faq-item">
            <div class="accordion">
                <h3 class="panel-title">Are there more customization options available?</h3>
            </div>

            <div class="panel-body">
                Yes, we are not limited to only the hardware we have listed. If you would like a more custom option,
                please contact our support team <a href="/servers/contacts/">here</a>.
            </div>

        </div>

        <div class="faq-item">
            <div class="accordion">
                <h3 class="panel-title">What Speeds Can I Expect For My Dedicated Server?</h3>
            </div>

            <div class="panel-body">Our servers are all set up on dedicated 1 Gbps Ethernet ports.
                If you are not seeing 1 Gbps on for your connection, please see <a href="http://support.blazingseollc.com/support/solutions/articles/19000045816-why-do-i-get-low-speed-test-results-">this article</a> from our support site.

            </div>
        </div>



        <div class="faq-item">
            <div class="accordion">
                <h3 class="panel-title">How Long Until My Server Is Ready?</h3>
            </div>

            <div class="panel-body">We strive to have your server ready as soon as we possibly can. Usually this will
                happen in 4 hours or less. However, please allow up to 12 hours for us to complete the setup for your dedicated server.
            </div>
        </div>



    </div>
</section>


<script>


    
</script>


<?php the_post() ?>


<?php the_content(); ?>



<?php get_footer();?>

