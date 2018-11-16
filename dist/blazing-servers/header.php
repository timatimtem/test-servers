<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Blazing SEO Hosting">
    <meta name="author" content="BlazingSEO">

    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_stylesheet_directory_uri(); ?>/img/flav/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo get_stylesheet_directory_uri(); ?>/img/flav/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_stylesheet_directory_uri(); ?>/img/flav/favicon-16x16@new.png">
<!--    <link rel="manifest" href="--><?php //echo get_stylesheet_directory_uri(); ?><!--/img/flav/manifest.json">-->
<!--    <meta name="msapplication-TileColor" content="#ffffff">-->
<!--    <meta name="msapplication-TileImage" content="--><?php //echo get_stylesheet_directory_uri(); ?><!--/img/flav/ms-icon-144x144.png">-->
<!--    <meta name="theme-color" content="#ffffff">-->

    <title><?php wp_title(  ); ?></title>

<!--    <link href="--><?php //echo get_bloginfo( 'template_directory' );?><!--/css/style.css" rel="stylesheet">-->


    <?php wp_head();?>
<!--    <link rel="shortcut icon" href="--><?php //echo get_stylesheet_directory_uri(); ?><!--/img/flav.png" />-->


    <?php if ( is_page( 'bulk-ips' ) ):  ?>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <?php endif ?>

</head>

<body>

<?php if ( function_exists( 'gtm4wp_the_gtm_tag' ) ) { gtm4wp_the_gtm_tag(); } ?>


