<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <?php
        if (isset($seo_keyword) && isset($seo_description)) {
            echo '<meta name="description" content="' . $seo_description . '" />';
            echo '<meta name="Keywords" content="' . $seo_keyword . '" />';
        } else {
            ?>
            <meta name="description" content="The Unforgettable supercharged street performance Kawasaki motorcycle are now in Cambodia. BUILT BEYOND BELIEF" />
            <meta name="Keywords" content="Kawasaki Cambodia, Motors Kawasaki, Cambodia Motors, motorcycle cambodia, Motors for sale cambodia, Kawasaki, motor shop in cambodia, motor price in cambodia, motor for sell in cambodia, motorcycle in cambodia, motor kawasaki,motor ninja" />
            <?php
        }
        ?>
        <meta name="author" content="">
        <meta name="robots" content="index, follow"/>


        <title>
            <?php
            if (isset($top_title)) {
                echo $top_title;
            } else {
                echo 'Kawasaki Motors Cambodia';
            }
            ?>
        </title>

        <?php
        /*  Open Graph data  */
        if (isset($social_url) && isset($socail_title) && isset($social_description) && isset($social_image)) {
            echo '<meta property="og:url"  content="' . $social_url . '" />';
            echo '<meta property="og:type"               content="article" />';
            echo '<meta property="og:title"              content="' . $socail_title . '" />';
            echo '<meta property="og:description"        content="' . $social_description . '" />';
            echo '<meta property="og:image"              content="' . $social_image . '" />';
        } else {
            ?>
            <meta property="og:url"                content="http://kawasaki.com.kh" />
            <meta property="og:type"               content="article" />
            <meta property="og:title"              content="Kawasaki Motors Cambodia" />
            <meta property="og:description"        content="The Unforgettable supercharged street performance Kawasaki motorcycle are now in Cambodia.
                  (SHOWROOM)  No. 92 - PQRST, Toeklaak 1, Sahakpornrussey, Toul Kork, Phnom Penh
                  BUILT BEYOND BELIEF" />
            <meta property="og:image"              content="<?php echo base_url() . "assets/images/og_fb.jpg"; ?>" />

            <!-- Twitter Card data -->
            <meta name="twitter:card" content="summary">
            <meta name="twitter:site" content="@publisher_handle">
            <meta name="twitter:title" content="Page Title">
            <meta name="twitter:description" content="Page description less than 200 characters">
            <meta name="twitter:creator" content="@author_handle">
            <meta name="twitter:image" content="<?php echo base_url() . "assets/images/og_fb.jpg"; ?>">

            <?php
        }
        ?>
        <meta property="og:image" content="fully_qualified_image_url_here" />


        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/favicon.ico" />

        <link href="http://fonts.googleapis.com/css?family=Hanuman’ rel=’stylesheet’ type=’text/css">
        <link href="<?php echo base_url(); ?>assets/scroll/aos.css" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Exo+2' rel='stylesheet' type='text/css'>
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
        <!-- W3 CSS -->
        <link href="<?php echo base_url(); ?>assets/css/w3.css" rel="stylesheet">
        <!--        Custom-->
        <link href="<?php echo base_url(); ?>assets/css/custom.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/custom-menu.css" rel="stylesheet">

        <!--        sub menu-->

<!--        <link href="<?php echo base_url(); ?>assets/submenu/yamm.css" rel="stylesheet">-->
        <!--        home slideshow-->
        <link href="<?php echo base_url(); ?>assets/css/home-slide.css" rel="stylesheet">


        <script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>

        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/performance.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jssor.slider.debug.js"></script>
        <script>
            $(document).ready(function () {
                $("#model_motor").click(function () {
                    $('html, body').animate({scrollTop: 0}, 'fast');
                    $(".menu_model").slideToggle("slow");
                });

            });
        </script>

        <script>
            // BY KAREN GRIGORYAN

            $(document).ready(function () {
                /******************************
                 BOTTOM SCROLL TOP BUTTON
                 ******************************/

                // declare variable
                var scrollTop = $(".scrollTop");

                $(window).scroll(function () {
                    // declare variable
                    var topPos = $(this).scrollTop();

                    // if user scrolls down - show scroll to top button
                    if (topPos > 100) {
                        $(scrollTop).css("opacity", "1");

                    } else {
                        $(scrollTop).css("opacity", "0");
                    }

                }); // scroll END

                //Click event to scroll to top
                $(scrollTop).click(function () {
                    $('html, body').animate({
                        scrollTop: 0
                    }, 800);
                    return false;

                }); // click() scroll top EMD

                /*************************************
                 LEFT MENU SMOOTH SCROLL ANIMATION
                 *************************************/
                // declare variable
                var h1 = $("#h1").position();
                var h2 = $("#h2").position();
                var h3 = $("#h3").position();

                $('.link1').click(function () {
                    $('html, body').animate({
                        scrollTop: h1.top
                    }, 500);
                    return false;

                }); // left menu link2 click() scroll END

                $('.link2').click(function () {
                    $('html, body').animate({
                        scrollTop: h2.top
                    }, 500);
                    return false;

                }); // left menu link2 click() scroll END

                $('.link3').click(function () {
                    $('html, body').animate({
                        scrollTop: h3.top
                    }, 500);
                    return false;

                }); // left menu link3 click() scroll END

            }); // ready() END
        </script>

        

    </head>

    <body>


