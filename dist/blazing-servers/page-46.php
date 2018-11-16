<!--VPS pricing-->

<!--// CODE-->


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


            <h1 class="home-heading">VPS Hosting</h1>

            <h4 class="home-description">
                The most reliable VPS hosting powered by SSDs with RAID1 redundancy <br>on the latest, enterprise level hardware            </h4>




        </div>


    </div>



</header>

<div class="servers-img">
    <img src="<?php echo get_template_directory_uri();?>/img/servers-img.png" alt="servers">
</div>

<section class=" servers-packages-section" >


    <div class="container">

        <div class="vps-package">

            <h2 class="vps-package-title standard-vps">
                Essential Servers
            </h2>


            <div class="desktop-view">
                <div class="price-table-title-container">
                    <h5>CPU Cores</h5>
                    <h5>RAM</h5>
                    <h5 style="margin-right: 13px">SSD</h5>
                    <h5 style="margin-right: 16px">Speed</h5>
                    <h5>Bandwidth</h5>
                    <h5>Price</h5>
                    <h5 style="color: white">Price</h5>
                </div>
            </div>

            <div class="vps-server-item">
                <div class="padding-box standard-vps-package" onclick="togglePackage(event, this);">


                    <h3 class="vps-server-item-title">
                        Server #2
                    </h3>

                    <div class="vps-server-item-price">
                        Price: <span class="price-inner">$29</span>
                    </div>

                    <div class="vps-server-item-characteristics">

                        <div class="tt-table-left">
                            <h5>CPU Cores</h5>
                            <h5>RAM</h5>
                            <h5>SSD</h5>
                            <h5>Speed</h5>
                            <h5>Bandwidth</h5>
                        </div>

                        <div class="tt-table-right">

                            <div class="">

                                <p>2 Cores</p>
                                <p>2 GB</p>
                                <p>20 GB</p>
                                <p>1 Gbps</p>
                                <p>Unlimited</p>
                                <p class="desktop-view price" style="position: relative;left: 1px;">$29</p>
                                <p class="desktop-view more-toggle">More</p>

                            </div>
                        </div>

                    </div>
                </div>

                <div class="vps-server-more-btn">

                    <button class="accordion">More</button>

                    <div class="panel-body">

                        <div class="padding-box">
                            <div class="vps-server-item-characteristics">

                                <div class="tt-table-left">
                                    <h5>Operating System</h5>
                                    <h5>USA Support</h5>
                                    <h5>Location</h5>

                                </div>

                                <div class="tt-table-right">

                                    <div class="">

                                        <p class="windows-pull-left">Windows Server 2012 R2</p>
                                        <p><span class="desktop-view">USA Support</span>24/7/365</p>

                                        <div class="location-inner-wrap">
                                            <span class="desktop-view">Locations</span>
                                            <div class="custom-select " >
                                                <select>
                                                    <option value="server2">Los Angeles</option>
                                                    <option value="dallas">Dallas</option>
                                                    <option value="New york">New York</option>
                                                    <option value="Chicago">Chicago</option>

                                                </select>
                                            </div>
                                        </div>



                                        <p class="desktop-view price" >$29</p>

                                    </div>
                                </div>

                            </div>
                            <div class="package-btn-wrap">
                                <a href="https://billing.blazingseollc.com/hosting/cart.php?a=add&pid=24" class="package-btn package-buy-btn server2-buy" >Buy</a>
                            </div>
                        </div>
                    </div>


                </div>



            </div>

            <div class="vps-server-item">
                <div class="padding-box" onclick="togglePackage(event, this);">


                    <h3 class="vps-server-item-title">
                        Server #3
                    </h3>

                    <div class="vps-server-item-price">
                        Price: <span class="price-inner">$33</span>
                    </div>

                    <div class="vps-server-item-characteristics">

                        <div class="tt-table-left">
                            <h5>CPU Cores</h5>
                            <h5>RAM</h5>
                            <h5>SSD</h5>
                            <h5>Speed</h5>
                            <h5>Bandwidth</h5>
                        </div>

                        <div class="tt-table-right">

                            <div class="">

                                <p>3 Cores</p>
                                <p>3 GB</p>
                                <p>30 GB</p>
                                <p>1 Gbps</p>
                                <p>Unlimited</p>
                                <p class="desktop-view price" style="position: relative;left: 1px;">$33</p>
                                <p class="desktop-view more-toggle">More</p>

                            </div>
                        </div>

                    </div>
                </div>

                <div class="vps-server-more-btn">

                    <button class="accordion">More</button>

                    <div class="panel-body">

                        <div class="padding-box">
                            <div class="vps-server-item-characteristics">

                                <div class="tt-table-left">
                                    <h5>Operating System</h5>
                                    <h5>USA Support</h5>
                                    <h5>Location</h5>

                                </div>

                                <div class="tt-table-right">

                                    <div class="">

                                        <p class="windows-pull-left">Windows Server 2012 R2</p>
                                        <p><span class="desktop-view">USA Support</span>24/7/365</p>



                                        <div class="location-inner-wrap">
                                            <span class="desktop-view">Locations</span>
                                            <div class="custom-select " >
                                                <select>
                                                    <option value="server3">Los Angeles</option>
                                                    <option value="dallas">Dallas</option>
                                                    <option value="New york">New York</option>
                                                    <option value="Chicago">Chicago</option>

                                                </select>
                                            </div>
                                        </div>

                                        <p class="desktop-view price" >$33</p>

                                    </div>
                                </div>

                            </div>
                            <div class="package-btn-wrap">
                                <a href="https://billing.blazingseollc.com/hosting/cart.php?a=add&pid=25" class="package-btn package-buy-btn server3-buy" >Buy</a>
                            </div>
                        </div>
                    </div>


                </div>



            </div>

            <div class="vps-server-item">
                <div class="padding-box" onclick="togglePackage(event, this);">


                    <h3 class="vps-server-item-title">
                        Server #4
                    </h3>

                    <div class="vps-server-item-price">
                        Price: <span class="price-inner">$40</span>
                    </div>

                    <div class="vps-server-item-characteristics">

                        <div class="tt-table-left">
                            <h5>CPU Cores</h5>
                            <h5>RAM</h5>
                            <h5>SSD</h5>
                            <h5>Speed</h5>
                            <h5>Bandwidth</h5>
                        </div>

                        <div class="tt-table-right">

                            <div class="">

                                <p>4 Cores</p>
                                <p>4 GB</p>
                                <p>30 GB</p>
                                <p>1 Gbps</p>
                                <p>Unlimited</p>
                                <p class="desktop-view price" style="position:relative; left: 2px;">$40</p>
                                <p class="desktop-view more-toggle">More</p>

                            </div>
                        </div>

                    </div>
                </div>

                <div class="vps-server-more-btn">

                    <button class="accordion">More</button>

                    <div class="panel-body">

                        <div class="padding-box">
                            <div class="vps-server-item-characteristics">

                                <div class="tt-table-left">
                                    <h5>Operating System</h5>
                                    <h5>USA Support</h5>
                                    <h5>Location</h5>

                                </div>

                                <div class="tt-table-right">

                                    <div class="">

                                        <p class="windows-pull-left">Windows Server 2012 R2</p>
                                        <p><span class="desktop-view">USA Support</span>24/7/365</p>

                                        <div class="location-inner-wrap">
                                            <span class="desktop-view">Locations</span>
                                            <div class="custom-select " >
                                                <select>
                                                    <option value="server4">Los Angeles</option>
                                                    <option value="dallas">Dallas</option>
                                                    <option value="New york">New York</option>
                                                    <option value="Chicago">Chicago</option>

                                                </select>
                                            </div>
                                        </div>

                                        <p class="desktop-view price" >$40</p>

                                    </div>
                                </div>

                            </div>
                            <div class="package-btn-wrap">
                                <a href="https://billing.blazingseollc.com/hosting/cart.php?a=add&pid=26" class="package-btn package-buy-btn server4-buy" >Buy</a>
                            </div>
                        </div>
                    </div>


                </div>



            </div>


        </div>


        <div class="vps-package">

            <h2 class="vps-package-title enhanced-vps">
                Professional Servers
            </h2>




            <div class="desktop-view">
                <div class="price-table-title-container">
                    <h5>CPU Cores</h5>
                    <h5>RAM</h5>
                    <h5 style="margin-right: 13px">SSD</h5>
                    <h5 style="margin-right: 16px">Speed</h5>
                    <h5>Bandwidth</h5>
                    <h5>Price</h5>
                    <h5 style="color: white">Price</h5>
                </div>
            </div>


            <div class="vps-server-item">
                <div class="padding-box enhanced-vps-package" onclick="togglePackage(event, this);">


                    <h3 class="vps-server-item-title">
                        Server #6
                    </h3>

                    <div class="vps-server-item-price">
                        Price: <span class="price-inner">$59</span>
                    </div>

                    <div class="vps-server-item-characteristics">

                        <div class="tt-table-left">
                            <h5>CPU Cores</h5>
                            <h5>RAM</h5>
                            <h5>SSD</h5>
                            <h5>Speed</h5>
                            <h5>Bandwidth</h5>
                        </div>

                        <div class="tt-table-right">

                            <div class="">

                                <p>6 Cores</p>
                                <p>6 GB</p>
                                <p>30 GB</p>
                                <p>1 Gbps</p>
                                <p>Unlimited</p>
                                <p class="desktop-view price" style="position: relative;left: 1px;">$59</p>
                                <p class="desktop-view more-toggle">More</p>

                            </div>
                        </div>

                    </div>
                </div>

                <div class="vps-server-more-btn">

                    <button class="accordion">More</button>

                    <div class="panel-body">

                        <div class="padding-box">
                            <div class="vps-server-item-characteristics">

                                <div class="tt-table-left">
                                    <h5>Operating System</h5>
                                    <h5>USA Support</h5>
                                    <h5>Location</h5>

                                </div>

                                <div class="tt-table-right">

                                    <div class="">

                                        <p class="windows-pull-left">Windows Server 2012 R2</p>
                                        <p><span class="desktop-view">USA Support</span>24/7/365</p>

                                        <div class="location-inner-wrap">
                                            <span class="desktop-view">Locations</span>
                                            <div class="custom-select " >
                                                <select>
                                                    <option value="server6">Los Angeles</option>
                                                    <option value="dallas">Dallas</option>
                                                    <option value="New york">New York</option>
                                                    <option value="Chicago">Chicago</option>
                                                </select>
                                            </div>
                                        </div>

                                        <p class="desktop-view price" >$59</p>

                                    </div>
                                </div>

                            </div>
                            <div class="package-btn-wrap">
                                <a href="https://billing.blazingseollc.com/hosting/cart.php?a=add&pid=27" class="package-btn package-buy-btn server6-buy" >Buy</a>
                            </div>
                        </div>
                    </div>


                </div>



            </div>


            <div class="vps-server-item">
                <div class="padding-box" onclick="togglePackage(event, this);">


                    <h3 class="vps-server-item-title">
                        Server #8
                    </h3>

                    <div class="vps-server-item-price">
                        Price: <span class="price-inner">$79</span>
                    </div>

                    <div class="vps-server-item-characteristics">

                        <div class="tt-table-left">
                            <h5>CPU Cores</h5>
                            <h5>RAM</h5>
                            <h5>SSD</h5>
                            <h5>Speed</h5>
                            <h5>Bandwidth</h5>
                        </div>

                        <div class="tt-table-right">

                            <div class="">

                                <p>8 Cores</p>
                                <p>8 GB</p>
                                <p>50 GB</p>
                                <p>1 Gbps</p>
                                <p>Unlimited</p>
                                <p class="desktop-view price" style="position:relative;left: 1px;">$79</p>
                                <p class="desktop-view more-toggle">More</p>

                            </div>
                        </div>

                    </div>
                </div>

                <div class="vps-server-more-btn">

                    <button class="accordion">More</button>

                    <div class="panel-body">

                        <div class="padding-box">
                            <div class="vps-server-item-characteristics">

                                <div class="tt-table-left">
                                    <h5>Operating System</h5>
                                    <h5>USA Support</h5>
                                    <h5>Location</h5>

                                </div>

                                <div class="tt-table-right">

                                    <div class="">

                                        <p class="windows-pull-left">Windows Server 2012 R2</p>
                                        <p><span class="desktop-view">USA Support</span>24/7/365</p>



                                        <div class="location-inner-wrap">
                                            <span class="desktop-view">Locations</span>
                                            <div class="custom-select " >
                                                <select>
                                                    <option value="server8">Los Angeles</option>
                                                    <option value="dallas">Dallas</option>
                                                    <option value="New york">New York</option>
                                                    <option value="Chicago">Chicago</option>

                                                </select>
                                            </div>
                                        </div>

                                        <p class="desktop-view price" >$79</p>

                                    </div>
                                </div>

                            </div>
                            <div class="package-btn-wrap">
                                <a href="https://billing.blazingseollc.com/hosting/cart.php?a=add&pid=28" class="package-btn package-buy-btn server8-buy" >Buy</a>
                            </div>
                        </div>
                    </div>


                </div>



            </div>

            <div class="vps-server-item">
                <div class="padding-box" onclick="togglePackage(event, this);">


                    <h3 class="vps-server-item-title">
                        Server #10
                    </h3>

                    <div class="vps-server-item-price">
                        Price: <span class="price-inner">$95</span>
                    </div>

                    <div class="vps-server-item-characteristics">

                        <div class="tt-table-left">
                            <h5>CPU Cores</h5>
                            <h5>RAM</h5>
                            <h5>SSD</h5>
                            <h5>Speed</h5>
                            <h5>Bandwidth</h5>
                        </div>

                        <div class="tt-table-right">

                            <div class="">

                                <p>10 Cores</p>
                                <p style="    position: relative;
    left: -3px;">10 GB</p>
                                <p style="    position: relative;
    right: 8px;">50 GB</p>
                                <p style="position: relative;
    right: 6px;">1 Gbps</p>
                                <p style="    position: relative;
    right: 4px;">Unlimited</p>
                                <p class="desktop-view price" style="position:relative;right: 1px;">$95</p>
                                <p class="desktop-view more-toggle">More</p>

                            </div>
                        </div>

                    </div>
                </div>

                <div class="vps-server-more-btn">

                    <button class="accordion">More</button>

                    <div class="panel-body">

                        <div class="padding-box">
                            <div class="vps-server-item-characteristics">

                                <div class="tt-table-left">
                                    <h5>Operating System</h5>
                                    <h5>USA Support</h5>
                                    <h5>Location</h5>

                                </div>

                                <div class="tt-table-right">

                                    <div class="">

                                        <p class="windows-pull-left">Windows Server 2012 R2</p>
                                        <p><span class="desktop-view">USA Support</span>24/7/365</p>



                                        <div class="location-inner-wrap">
                                            <span class="desktop-view">Locations</span>
                                            <div class="custom-select " >
                                                <select>
                                                    <option value="server10">Los Angeles</option>
                                                    <option value="dallas">Dallas</option>
                                                    <option value="New york">New York</option>
                                                    <option value="Chicago">Chicago</option>

                                                </select>
                                            </div>
                                        </div>

                                        <p class="desktop-view price" >$95</p>

                                    </div>
                                </div>

                            </div>
                            <div class="package-btn-wrap">
                                <a href="https://billing.blazingseollc.com/hosting/cart.php?a=add&pid=31"
                                   class="package-btn package-buy-btn server10-buy" >Buy</a>
                            </div>
                        </div>
                    </div>


                </div>



            </div>

        </div>



        <div class="vps-package">

            <h2 class="vps-package-title enterprise-vps">
                Enterprise Servers
            </h2>


            <div class="desktop-view">
                <div class="price-table-title-container" style="    position: relative;
    right: -3px;">
                    <h5>CPU Cores</h5>
                    <h5>RAM</h5>
                    <h5 style="margin-right: 13px">SSD</h5>
                    <h5 style="margin-right: 16px">Speed</h5>
                    <h5>Bandwidth</h5>
                    <h5>Price</h5>
                    <h5 style="color: white">Price</h5>
                </div>
            </div>

            <div class="vps-server-item">
                <div class="padding-box" onclick="togglePackage(event, this);">


                    <h3 class="vps-server-item-title">
                        Server #14
                    </h3>

                    <div class="vps-server-item-price">
                        Price: <span class="price-inner">$130</span>
                    </div>

                    <div class="vps-server-item-characteristics">

                        <div class="tt-table-left">
                            <h5>CPU Cores</h5>
                            <h5>RAM</h5>
                            <h5>SSD</h5>
                            <h5>Speed</h5>
                            <h5>Bandwidth</h5>
                        </div>

                        <div class="tt-table-right">

                            <div class="">

                                <p>14 Cores</p>
                                <p>14 GB</p>
                                <p>60 GB</p>
                                <p>1 Gbps</p>
                                <p>Unlimited</p>
                                <p class="desktop-view price" style="position: relative; left: 4px;">$130</p>
                                <p class="desktop-view more-toggle">More</p>

                            </div>
                        </div>

                    </div>
                </div>

                <div class="vps-server-more-btn">

                    <button class="accordion">More</button>

                    <div class="panel-body">

                        <div class="padding-box">
                            <div class="vps-server-item-characteristics">

                                <div class="tt-table-left">
                                    <h5>Operating System</h5>
                                    <h5>USA Support</h5>
                                    <h5>Location</h5>

                                </div>

                                <div class="tt-table-right">

                                    <div class="">

                                        <p class="windows-pull-left">Windows Server 2012 R2</p>
                                        <p><span class="desktop-view">USA Support</span>24/7/365</p>


                                        <div class="location-inner-wrap">
                                            <span class="desktop-view">Locations</span>
                                            <div class="custom-select " >
                                                <select>
                                                    <option value="server14">Los Angeles</option>
                                                    <option value="dallas">Dallas</option>
                                                    <option value="New york">New York</option>
                                                    <option value="Chicago">Chicago</option>

                                                </select>
                                            </div>
                                        </div>

                                        <p class="desktop-view price" >$130</p>

                                    </div>
                                </div>

                            </div>
                            <div class="package-btn-wrap">
                                <a href="https://billing.blazingseollc.com/hosting/cart.php?a=add&pid=238" class="package-btn package-buy-btn server14-buy" >Buy</a>
                            </div>
                        </div>
                    </div>


                </div>



            </div>

            <div class="vps-server-item">
                <div class="padding-box" onclick="togglePackage(event, this);">


                    <h3 class="vps-server-item-title">
                        Server #18
                    </h3>

                    <div class="vps-server-item-price">
                        Price: <span class="price-inner">$155</span>
                    </div>

                    <div class="vps-server-item-characteristics">

                        <div class="tt-table-left">
                            <h5>CPU Cores</h5>
                            <h5>RAM</h5>
                            <h5>SSD</h5>
                            <h5>Speed</h5>
                            <h5>Bandwidth</h5>
                        </div>

                        <div class="tt-table-right">

                            <div class="">

                                <p>18 Cores</p>
                                <p>18 GB</p>
                                <p>60 GB</p>
                                <p>1 Gbps</p>
                                <p>Unlimited</p>
                                <p class="desktop-view price" style="position:relative;left: 3px;">$155</p>
                                <p class="desktop-view more-toggle">More</p>

                            </div>
                        </div>

                    </div>
                </div>

                <div class="vps-server-more-btn">

                    <button class="accordion">More</button>

                    <div class="panel-body">

                        <div class="padding-box">
                            <div class="vps-server-item-characteristics">

                                <div class="tt-table-left">
                                    <h5>Operating System</h5>
                                    <h5>USA Support</h5>
                                    <h5>Location</h5>

                                </div>

                                <div class="tt-table-right">

                                    <div class="">

                                        <p class="windows-pull-left">Windows Server 2012 R2</p>
                                        <p><span class="desktop-view">USA Support</span>24/7/365</p>


                                        <div class="location-inner-wrap">
                                            <span class="desktop-view">Locations</span>
                                            <div class="custom-select " >
                                                <select>
                                                    <option value="server18">Los Angeles</option>
                                                    <option value="dallas">Dallas</option>
                                                    <option value="New york">New York</option>
                                                    <option value="Chicago">Chicago</option>

                                                </select>
                                            </div>
                                        </div>

                                        <p class="desktop-view price" >$155</p>

                                    </div>
                                </div>

                            </div>
                            <div class="package-btn-wrap">
                                <a href="https://billing.blazingseollc.com/hosting/cart.php?a=add&pid=239" class="package-btn package-buy-btn server18-buy" >Buy</a>
                            </div>
                        </div>
                    </div>


                </div>



            </div>

            <div class="vps-server-item">
                <div class="padding-box enterprise-vps-package" onclick="togglePackage(event, this);">


                    <h3 class="vps-server-item-title">
                        Server #24
                    </h3>

                    <div class="vps-server-item-price">
                        Price: <span class="price-inner">$199</span>
                    </div>

                    <div class="vps-server-item-characteristics">

                        <div class="tt-table-left">
                            <h5>CPU Cores</h5>
                            <h5>RAM</h5>
                            <h5>SSD</h5>
                            <h5>Speed</h5>
                            <h5>Bandwidth</h5>
                        </div>

                        <div class="tt-table-right">

                            <div class="">

                                <p>24 Cores</p>
                                <p style="position: relative;
    right: 4px;">24 GB</p>
                                <p style="    position: relative;
    left: -4px;">60 GB</p>
                                <p style="position: relative;
    left: -3px;">1 Gbps</p>
                                <p style="    position: relative;
    left: -2px;">Unlimited</p>
                                <p class="desktop-view price" style="position: relative;left: 2px;">$199</p>
                                <p class="desktop-view more-toggle">More</p>

                            </div>
                        </div>

                    </div>
                </div>

                <div class="vps-server-more-btn">

                    <button class="accordion">More</button>

                    <div class="panel-body">

                        <div class="padding-box">
                            <div class="vps-server-item-characteristics">

                                <div class="tt-table-left">
                                    <h5>Operating System</h5>
                                    <h5>USA Support</h5>
                                    <h5>Location</h5>

                                </div>

                                <div class="tt-table-right">

                                    <div class="">

                                        <p class="windows-pull-left">Windows Server 2012 R2</p>
                                        <p><span class="desktop-view">USA Support</span>24/7/365</p>


                                        <div class="location-inner-wrap">
                                            <span class="desktop-view">Locations</span>
                                            <div class="custom-select " >
                                                <select>
                                                    <option value="server24">Los Angeles</option>
                                                    <option value="dallas">Dallas</option>
                                                    <option value="New york">New York</option>
                                                    <option value="Chicago">Chicago</option>

                                                </select>
                                            </div>
                                        </div>

                                        <p class="desktop-view price" >$199</p>

                                    </div>
                                </div>

                            </div>
                            <div class="package-btn-wrap">
                                <a href="https://billing.blazingseollc.com/hosting/cart.php?a=add&pid=32" class="package-btn package-buy-btn server24-buy" >Buy </a>
                            </div>
                        </div>
                    </div>


                </div>



            </div>

        </div>
    </div>

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

                <div class="benefit-img benefit benefit-match">

                </div>

                <div class="benefit-title">
                 
                    Locations Match Our Proxies
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
        New user? Let's get started with these basics
    </p>

    <div class="container">



        <div class="faq-item">
            <div class="accordion">
                <h3 class="panel-title">Do you offer help setting up or transferring my files and software from my current host?</h3>
            </div>

            <div class="panel-body">
                Yes, we will offer free support to transfer all your current files and software from your current host
                to our VPS server. After purchase, please just open a ticket on our site and our customer support technicians will help you as soon as possible.
            </div>

        </div>

        <div class="faq-item">
            <div class="accordion">
                <h3 class="panel-title">What is the network speed on the VPS?</h3>
            </div>

            <div class="panel-body">
                All of our VPS run on a 1 Gbps ethernet line. Please see this link to our <a href="http://support.blazingseollc.com/support/solutions/articles/19000045816-why-do-i-get-low-speed-test-results-">support site</a>
                about why you might not be seeing 1 Gbps on a speed test.
            </div>
        </div>



        <div class="faq-item">
            <div class="accordion">
                <h3 class="panel-title">Will the VPS work on my Mac/Windows/Linux/Phone?</h3>
            </div>

            <div class="panel-body">
                Yes, the VPS will work for any device where there is an app that enables a remote login. Windows/Mac/Linux/Phones support this, as well as almost any other device.
            </div>
        </div>



    </div>
</section>
<script>
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






</script>

<?php the_post() ?>


<?php the_content(); ?>

<?php get_footer();?>


