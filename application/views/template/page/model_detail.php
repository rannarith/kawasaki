<!--   banner     -->
<?php
if ($model_info->num_rows() > 0) {
    $row = $model_info->row();
    ?>
    <img class="img-responsive" width="100%" src="<?php echo base_url() . 'assets/images/model/' . $row->full_image; ?>" />
    <div style="width: 100%;background-color: #ffffff; color: #000000;">
        <div class="container">  
            <div class="row">
                <div class="col-sm-offset-2 col-sm-8">
                    <div class="clear"></div><br/><br/>
                    <div class="col-md-6"><h2 class="content_title "><span class="kawa_txt_color"><?php echo $row->model_name; ?></span></h2></div>
                    
                    <div class="col-md-6 text-right"><a class="btn btn-sm btn_apply_forloan" href="<?php echo base_url()."page/applyloan/1?m=".$row->model_id; ?>">APPLY FOR LOAN</a></div>
                        <div class="clear"></div><br/>
                            <?php echo $row->description; ?>
                    <div class="clear"></div><br/><br/><br/>
                    
                </div>

                <?php
                if ($model_color->num_rows() > 0) {
                    ?>
                    <div class="clear"></div>
                    <div class="col-lg-12">
                        <div class="w3-content" style="max-width:800px">
                            <?php
                            foreach ($model_color->result() as $row_mc) {
                                echo '<img class="mySlides3" src="' . base_url() . 'assets/images/model_color/' . $row_mc->image . '" style="width:100%">';
                            }
                            ?>

                        </div>

                        <div class="w3-center">
                            Click the button to show more images with different colors  &nbsp;&nbsp;<br/> 
                            <?php
                            $i = 0;
                            foreach ($model_color->result() as $row_mc) {
                                $i++;
                                echo '<button class="btn" style="background: ' . $row_mc->color_code . '; height: 25px; padding-right: 10px;border:0; box-shadow: 2px 2px 3px #888888;" onclick="currentDiv1(' . $i . ')">&nbsp;</button> ';
                            }
                            ?>

                        </div>

                        <script>
                            var slideIndex1 = 1;
                            showDivs1(slideIndex1);

                            function plusDivs(n) {
                                showDivs1(slideIndex1 += n);
                            }

                            function currentDiv1(n) {
                                showDivs1(slideIndex1 = n);
                            }

                            function showDivs1(n) {
                                var i;
                                var x = document.getElementsByClassName("mySlides3");
                                var dots = document.getElementsByClassName("demo2");
                                if (n > x.length) {
                                    slideIndex1 = 1
                                }
                                if (n < 1) {
                                    slideIndex1 = x.length
                                }
                                for (i = 0; i < x.length; i++) {
                                    x[i].style.display = "none";
                                }
                                for (i = 0; i < dots.length; i++) {
                                    dots[i].className = dots[i].className.replace(" w3-red", "");
                                }
                                x[slideIndex1 - 1].style.display = "block";
                                dots[slideIndex1 - 1].className += " w3-red";
                            }
                        </script>
                    </div>
                    <?php
                }
                ?>               

                <div class="clear"></div><br/><br/>
                
                

            </div>
        </div>
    </div>

    <?php
    if ($feature->num_rows() > 0) {
        ?>
        <div style="padding-bottom: 50px;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="clear"></div><br/>
                        <h2 class="content_title"><span class="kawa_txt_color"> TOP FEATURES</span></h2>
                        <div class="clear"></div><br/>
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs md_features" role="tablist">
                            <?php
                            $i = 0;
                            foreach ($feature->result() as $row) {
                                $i++;
                                $act = '';
                                if ($i == 1) {
                                    $act = 'active';
                                }
                                echo '<li role="presentation" class="' . $act . '"><a href="#feature' . $row->feature_id . '" aria-controls="feature' . $row->feature_id . '" role="tab" data-toggle="tab">' . $row->top_title . '</a></li>';
                            }
                            ?>

                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content md_feature_content">
                            <?php
                            $i = 0;
                            foreach ($feature->result() as $row) {
                                $i++;
                                $act = '';
                                if ($i == 1) {
                                    $act = 'active';
                                }
                                ?>
                                <div role="tabpanel" class="tab-pane <?php echo $act; ?>" id="feature<?php echo $row->feature_id; ?>">
                                    <div class="col-md-6" style="padding: 0;"><img src="<?php echo base_url() . 'assets/images/feature/' . $row->thumbnail; ?>" class="img-responsive" style="float: left;"/></div>
                                    <div  class="col-md-6" style="padding: 25px;">
                                        <h3 class="title_kawa"><span class="kawa_txt_color"> <?php echo $row->title; ?></span></h3>
                                        <?php echo $row->long_des; ?>
                                    </div>

                                    <div class="clear"></div>
                                </div>
                                <?php
                            }
                            ?>

                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div class="clear"></div>
    <?php } ?>


    <div style="background: #202123;padding-bottom: 20px;">
        <div class="container">  
            <div class="row">
                <div class="col-lg-12">
                    <div class="clear"></div><br/>
                    <h2 class="content_title"><span class="kawa_txt_color"> Specifications </span></h2>
                    <div class="clear"></div><br/>
                </div>

                <?php
                foreach ($spec->result() as $row) {
                    ?>
                    <div class="col-sm-6 spec-contain">
                        <h3 class="spec_title"><?php echo $row->title; ?></h3>
                        <div class="clear"></div>
                        <?php echo $row->description; ?>

                    </div>
                    <?php
                }
                ?>

            </div>
        </div>
    </div>

<?php } ?>



<?php
if ($model_gallery->num_rows() > 0) {
    ?>
    <div class="container">  
        <div class="row">
            <div class="clear"></div><br/>
            <h2 class="content_title"> <span class="kawa_txt_color"> Gallery</span></h2>
            <div class="clear"></div><br/>

            <div class="grid">
                <?php
                $i = 0;
                foreach ($model_gallery->result() as $row) {
                    $i++;
                    ?>

                    <figure class="effect-julia">
                        <img src="<?php echo base_url() . 'assets/images/model_gallery/' . $row->image; ?>" alt="img21"  style="cursor: zoom-in;" onclick="openModal();currentDiv(<?php echo $i; ?>)"/>

                    </figure>


                    <?php
                }
                ?>
            </div>


        </div>
    </div>   
<?php } ?>



<!-- Modal 1 -->
<div id="myModal" class="w3-modal " style="">
<!--    <span class=" w3-container w3-display-topright cursor" style="font-size: 56px; color: #BB162B; cursor: pointer;" onclick="closeModal()">&times;</span>-->
    <div class="w3-content  w3-animate-zoom" style="width: 90% ">

        <div class="" style=" height: 100%;margin-top: 10%;">

            <div class="col-md-12" style="margin: 0px; padding-left: 0;padding-bottom: 5px;overflow: hidden;">
                <span class=" cursor" style="color: #6ABE28;font-size: 55px;font-weight: bold; cursor: pointer;float: right; margin-top: -5px;" onclick="closeModal()"> &times; </span>

                <?php
                foreach ($model_gallery->result() as $row) {
                    ?>
                    <img class="mySlides2" src="<?php echo base_url() . 'assets/images/model_gallery/' . $row->image; ?>" style="width:100%;height: auto; max-height: 650px;">
                    <?php
                }
                ?>
                <div style="position: absolute; height: 100%;top: 50%;width: 100%;">
                    <span class="cursor pull-left" style="top: 10%;float: left; left: 0; font-size: 46px; cursor: pointer; color: #6ABE28;" onclick="plusDivs(-1)">&#10094;</span>
                    <span class=" cursor pull-right" style="top: 10%;float: right; margin-right: 16px; font-size: 46px; cursor: pointer; color: #6ABE28;" onclick="plusDivs(1)">&#10095;</span>
                </div>               
            </div>


            <div style="clear: both;"></div>
        </div> <!-- End w3-content -->

    </div> <!-- End modal content -->
</div> <!-- End modal -->

<script>
    function openModal() {
        document.getElementById('myModal').style.display = "block";
    }

    function closeModal() {
        document.getElementById('myModal').style.display = "none";
    }

    var slideIndex = 1;
    showDivs(slideIndex);

    function plusDivs(n) {
        showDivs(slideIndex += n);
    }

    function currentDiv(n) {
        showDivs(slideIndex = n);
    }

    function showDivs(n) {
        var i;
        var x = document.getElementsByClassName("mySlides2");
        var dots = document.getElementsByClassName("demo");
        var captionText = document.getElementById("caption");
        if (n > x.length) {
            slideIndex = 1
        }
        if (n < 1) {
            slideIndex = x.length
        }
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" w3-opacity-off", "");
        }
        x[slideIndex - 1].style.display = "block";
        dots[slideIndex - 1].className += " w3-opacity-off";
        captionText.innerHTML = dots[slideIndex - 1].innerHTML;

        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace("w3-opacity-off", "");
        }
        var captionText = document.getElementById("caption");
        if (n > x.length) {
            slideIndex = 1;
        }
        if (n < 1) {
            slideIndex = x.length;
        }
    }
</script>