<div style="background: #F6F6F6; color: #000;">
    <style>
        .button-slide {
            background-color: #7DCA3F ;
        }
    </style>
    <!--   banner     -->
    <!--<img class="img-responsive" width="100%" src="<?php echo base_url(); ?>assets/images/accessory/1.jpg" />
     
    -->
    <div class="clear"></div>


    <div class="container">  
        <div class="row">
            <!-- left menu -->
            <div class="col-lg-2">
                <div class="clear"></div><br/><br/>
                <?php include_once 'menu_about.php'; ?>
            </div>

            <div class="col-lg-10">

                <div class="clear"></div><br/><br/>
                <script type="text/javascript">
                    jssor_2_slider_init = function () {

                        var jssor_1_SlideshowTransitions = [

                            {$Duration: 1000, x: -0.2, $Delay: 40, $Cols: 12, $SlideOut: true, $Formation: $JssorSlideshowFormations$.$FormationStraight, $Assembly: 260, $Easing: {$Left: $Jease$.$InOutExpo, $Opacity: $Jease$.$InOutQuad}, $Opacity: 2, $Outside: true, $Round: {$Top: 0.5}},
                        ];

                        var jssor_1_options = {
                            $AutoPlay: 1,
                            $SlideshowOptions: {
                                $Class: $JssorSlideshowRunner$,
                                $Transitions: jssor_1_SlideshowTransitions,
                                $TransitionsOrder: 1
                            },
                            $ArrowNavigatorOptions: {
                                $Class: $JssorArrowNavigator$
                            },
                            $BulletNavigatorOptions: {
                                $Class: $JssorBulletNavigator$
                            }
                        };

                        var jssor_1_slider = new $JssorSlider$("jssor_2", jssor_1_options);

                        /*#region responsive code begin*/

                        var MAX_WIDTH = 1300;

                        function ScaleSlider() {
                            var containerElement = jssor_1_slider.$Elmt.parentNode;
                            var containerWidth = containerElement.clientWidth;

                            if (containerWidth) {

                                var expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);

                                jssor_1_slider.$ScaleWidth(expectedWidth);
                            } else {
                                window.setTimeout(ScaleSlider, 30);
                            }
                        }

                        ScaleSlider();

                        $Jssor$.$AddEvent(window, "load", ScaleSlider);
                        $Jssor$.$AddEvent(window, "resize", ScaleSlider);
                        $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
                        /*#endregion responsive code end*/


                    };
                </script>
                <style>
                    /* jssor slider loading skin spin css */
                    .jssorl-009-spin img {
                        animation-name: jssorl-009-spin;
                        animation-duration: 1.6s;
                        animation-iteration-count: infinite;
                        animation-timing-function: linear;
                    }

                    @keyframes jssorl-009-spin {
                        from {
                            transform: rotate(0deg);
                        }

                        to {
                            transform: rotate(360deg);
                        }
                    }


                    .jssorb053 .i {position:absolute;cursor:pointer;}
                    .jssorb053 .i .b {fill:#69be28;fill-opacity:0.5;}
                    .jssorb053 .i:hover .b {fill-opacity:.7;}
                    .jssorb053 .iav .b {fill-opacity: 1;}
                    .jssorb053 .i.idn {opacity:.3;}

                    .jssora093 {display:block;position:absolute;cursor:pointer;}
                    .jssora093 .c {fill:none;stroke:#69be28;stroke-width:400;stroke-miterlimit:10;}
                    .jssora093 .a {fill:none;stroke:#69be28;stroke-width:400;stroke-miterlimit:10;}
                    .jssora093:hover {opacity:.9;}
                    .jssora093.jssora093dn {opacity:.7;}
                    .jssora093.jssora093ds {opacity:.5;pointer-events:none;}
                </style>
                <div id="jssor_2" style="position:relative;margin:0 auto;top:0px;left:0px;width:1300px;height:846px;overflow:hidden;visibility:hidden;">
                    <!-- Loading Screen -->
                    <div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
                        <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="../svg/loading/static-svg/spin.svg" />
                    </div>
                    <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:1300px;height:846px;overflow:hidden;">

                        <?php
                        foreach ($about_gallery->result() as $row) {
                            ?>

                            <div>
                                <img data-u="image" src="<?php echo base_url() . 'assets/images/about/' . $row->image; ?>" />
                            </div>
                            <?php
                        }
                        ?>


                    </div>
                    <!-- Bullet Navigator -->
                    <div data-u="navigator" class="jssorb053" style="position:absolute;bottom:12px;right:12px;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
                        <div data-u="prototype" class="i" style="width:25px;height:25px;">
                            <svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                            <path class="b" d="M11400,13800H4600c-1320,0-2400-1080-2400-2400V4600c0-1320,1080-2400,2400-2400h6800 c1320,0,2400,1080,2400,2400v6800C13800,12720,12720,13800,11400,13800z"></path>
                            </svg>
                        </div>
                    </div>
                    <!-- Arrow Navigator -->
                    <div data-u="arrowleft" class="jssora093" style="width:50px;height:50px;top:0px;left:30px;" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
                        <svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                        <circle class="c" cx="8000" cy="8000" r="5920"></circle>
                        <polyline class="a" points="7777.8,6080 5857.8,8000 7777.8,9920 "></polyline>
                        <line class="a" x1="10142.2" y1="8000" x2="5857.8" y2="8000"></line>
                        </svg>
                    </div>
                    <div data-u="arrowright" class="jssora093" style="width:50px;height:50px;top:0px;right:30px;" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
                        <svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                        <circle class="c" cx="8000" cy="8000" r="5920"></circle>
                        <polyline class="a" points="8222.2,6080 10142.2,8000 8222.2,9920 "></polyline>
                        <line class="a" x1="5857.8" y1="8000" x2="10142.2" y2="8000"></line>
                        </svg>
                    </div>
                </div>
                <script type="text/javascript">jssor_2_slider_init();</script>
                <!-- #endregion Jssor Slider End -->



                <div class="clear"></div><br/><br/>



                <div>
                    <?php 
                        if(isset($about_kawa_query)){
                            echo '<h2 class="content_title"><span class="kawa_txt_color">'.$about_kawa_query->title.'</span></h2>';
                            echo $about_kawa_query->description;
                        }
                    ?>
                    
                    <?php 
                        if(isset($gm_message)){
                            echo '<h2 class="content_title"><span class="kawa_txt_color">'.$gm_message->title.'</span></h2>';
                            echo $gm_message->description;
                        }
                    ?>

                    
                </div>
                <div class="clear"></div><br/>

            </div>



        </div>

    </div>
</div>


