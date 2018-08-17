<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php wp_title(  ); ?></title>

    <link href="<?php echo get_bloginfo( 'template_directory' );?>/css/style.css" rel="stylesheet">

    <?php wp_head();?>

    <link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/img/logoblue.png" />

</head>

<body>



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

            <div class="container-60">


                <h1 class="home-heading">Best performance, <span class="span-row-breaker"> best prices</span></h1>



                <p class="home-subheading">
                    Starting at <span class="text-bold">$29/month</span> <span class="free-trials-title">*Free Trials Available</span>
                </p>

                <p class="home-description">
                    Looking for a Virtual Private Server (VPS) or a fully Dedicated Server to meet your server needs?

                    <span class="span-row-breaker">
            Blazing SEO is proud to provide top of the line server products to meet any of our customers' needs.
                </span>
                </p>

                <div class="locations-wrap">
                    <div class="location location-los-angeles " >
						<span class="location-name">
							<span>Los Angeles</span>
						</span>
                    </div>

                    <div class="location location-chicago " >
						<span class="location-name">
							<span>Chicago</span>
						</span>
                    </div>


                    <div class="location location-new-york " >
						<span class="location-name">
							<span>New York</span>
						</span>
                    </div>

                    <div class="location location-dallas " >
						<span class="location-name">
							<span>Dallas</span>
						</span>
                    </div>

                </div>
                <a href="" class="btn home-btn">Get Your Server Today!</a>

                <a href="/servers" class="home-arrow-down-link">
                    <img class="arrow-down" src="<?php echo get_bloginfo( 'template_directory' );?>/img/arrow-down.svg" alt="">
                </a>
            </div>

        </div>
    </div>





</header>



<section class="product-section" style="display:block;">
    <h2 class="section-header">Our Products</h2>

    <div class="products-wrap">

        <div class="product">
            <div class="product-img img-cloud">

            </div>

            <h3 class="product-title">
                Windows VPS
            </h3>
            <p class="product-description">
                Need a server? Take a look at our VPS products and find great, affordable packages that will meet your needs.
            </p>


            <div class="product-footer">

                <span>Starting At:</span>
                <span class="product-price">90$</span>
                <a class="get-started-btn vps">Get Started!</a>
            </div>
        </div>

        <div class="product">


            <div class="product-img img-product-done">

            </div>

            <h3 class="product-title">
                Dedicated Servers
            </h3>
            <p class="product-description">
                Need even more customization? Take a look our selection of Dedicated Servers and customize them to your
                exact needs!
            </p>

            <div class="product-footer">

                <span>Starting At:</span>
                <span class="product-price">90$</span>
                <a class="get-started-btn">Get Started!</a>
            </div>
        </div>



    </div>


</section>






<section class="benefit-section">



    <div class="container">

        <h2 class="benefits-section-title">Why Blazing SEO?</h2>

        <p class="benefits-section-description">
            We offer everything you need from a server provider

        </p>


        <div class="benefits-wrap">
            <div class="benefits-item">

                <div class="benefit-img benefit-locations">

                </div>

                <div class="benefit-title">
                    Multiple Locations
                </div>
            </div>

            <div class="benefits-item">

                <div class="benefit-img benefit-locations">

                </div>

                <div class="benefit-title">
                    Solid State Drives
                </div>
            </div>

            <div class="benefits-item">

                <div class="benefit-img benefit-locations">

                </div>

                <div class="benefit-title">
                    1 Gbps Speeds
                </div>
            </div>

            <div class="benefits-item">

                <div class="benefit-img benefit-locations">

                </div>

                <div class="benefit-title">
                    Enterprise Hardware
                </div>
            </div>


            <div class="benefits-item">

                <div class="benefit-img benefit-locations">

                </div>

                <div class="benefit-title">
                    Multiple Locations
                </div>
            </div>

            <div class="benefits-item">

                <div class="benefit-img benefit-locations">

                </div>

                <div class="benefit-title">
                    Solid State Drives
                </div>
            </div>

            <div class="benefits-item">

                <div class="benefit-img benefit-locations">

                </div>

                <div class="benefit-title">
                    1 Gbps Speeds
                </div>
            </div>

            <div class="benefits-item">

                <div class="benefit-img benefit-locations">

                </div>

                <div class="benefit-title">
                    Enterprise Hardware
                </div>
            </div>
        </div>


    </div>



</section>


<section style="background-color: #fff;padding: 100px 0; text-align: center">

    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad aperiam architecto aut cupiditate debitis dolore eligendi et excepturi facilis fugiat id in incidunt ipsam labore laboriosam laudantium maiores necessitatibus, nesciunt nobis nostrum numquam omnis provident quae repellat sunt velit voluptate voluptates? Aperiam aspernatur at atque consequuntur debitis distinctio esse eum excepturi ipsa itaque natus neque, nobis porro praesentium quae quod saepe sit sunt, suscipit voluptates! Ab ad architecto aspernatur consequatur dolores explicabo hic id illum impedit, ipsa magnam maxime nemo, odio perferendis porro quae quasi qui quis reiciendis rem ut veritatis voluptate? Aspernatur dicta dolor ipsam natus nulla quas, rem!
</section>