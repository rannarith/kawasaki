<script type="text/javascript">
    function genericSocialShare(url) {
        window.open(url, 'sharer', 'toolbar=0,status=0,width=648,height=395');
        return true;
    }
</script>

<!--   banner     -->

<?php
if ($model_info->num_rows() > 0) {
    $row = $model_info->row();

    if ($row->is_available == 0) {
        $pre_order = '<br/><span class="pre-order-text">Pre Order</span>';
    } else {
        $pre_order = ' ';
    }

    if ($row->full_image != '') {
        echo '<img class="img-responsive" width="100%" src="' . base_url() . 'assets/images/model/' . $row->full_image . '" />';
    }
    ?>

    <div style="width: 100%;background-color: #ffffff; color: #000000;">
        <div class="container">  
            <div class="row">
                <div class="col-sm-offset-1 col-sm-10">
                    <div class="clear"></div><br/><br/>
                    <div class="col-md-6"><h2 class="content_title "><span class="kawa_txt_color"><?php echo $row->model_name; ?></span> <?php echo $pre_order; ?></h2></div>
                    
                    <div class="col-md-6 text-right">
                        Share On Social Media
                        <a href="http://www.facebook.com/sharer.php?u=<?php echo base_url() . 'page/model/' . $this->uri->segment(3); ?>" target="_blank">
                            <img src="<?php echo base_url() . 'images/fb.png'; ?>" alt="kawasaki social link" style="width: 40px;"/>
                        </a>
                        <a href="https://plus.google.com/share?url=<?php echo base_url() . 'page/model/' . $this->uri->segment(3); ?>"  target="_blank">
                            <img src="<?php echo base_url() . 'images/gplus.png'; ?>" alt="kawasaki social link" style="width: 40px;"/>
                        </a>
                    </div>

                    <!--
                    apply loan 
                    
                    <div class="col-md-6 text-right"><a class="btn btn-sm btn_apply_forloan" href="<?php echo base_url() . "page/applyloan/1?m=" . $row->model_id; ?>">APPLY FOR LOAN</a></div>
                    -->    
                    <div class="clear"></div><br/>

                    <?php echo $row->description; ?>
                    <div class="clear"></div><br/><br/><br/>
                </div>

                <?php
                if ($model_color->num_rows() > 0) {
                    ?>
                    <div class="clear"></div>
                    <div class="col-sm-offset-1 col-sm-10">
                        <div style="position: absolute;width: 100%; top: 40%; ">
                            <span class="cursor " style="position: absolute; top: 45%;float: left; left: 0; font-size: 46px; cursor: pointer; color: #6ABE28;" onclick="plusDivs_color(-1)">&#10094;</span>
                            <span class="cursor " style="position: absolute; top: 45%;float: right; right: 0; font-size: 46px; cursor: pointer; color: #6ABE28;" onclick="plusDivs_color(-1)">&#10095;</span>
                        </div>
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
                                echo '<button class="btn" style=" border: 2px solid #ccc; background: ' . $row_mc->color_code . '; height: 30px;z-index: 500; padding-right: 25px;" onclick="currentDiv1(' . $i . ')">&nbsp;</button> ';
                            }
                            ?>
                        </div>
                        <script>
                            var slideIndex1 = 1;
                            showDivs1(slideIndex1);

                            function plusDivs_color(n) {
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
                        <ul class="nav nav-tabs nav-justified md_features " role="tablist">
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

<?php
}

include 'model_gallery.php';
?>




<!-- accessory by model -->
<?php
if ($accessory->num_rows() > 0) {
    ?>
    <div style="background: #F6F6F6; color: #7e7e7e;">
        <div class="container">  
            <div class="row">
                <div class="clear"></div><br/>
                <div class="col-md-6">
                    <h2 class="content_title" >Accessories & <span class="kawa_txt_color"> Apparel</span></h2>
                </div>
                <div class="col-md-6">
                    <a href="<?php echo base_url(); ?>page/allaccessory_part" class="btn contact-btn btn-kawa-gradient"><span>View All >></span></a>
                </div>
                <div class="clear"></div><br/>

                <?php
                $i = 0;
                foreach ($accessory->result() as $row) {
                    $i++;
                    ?>

                    <div class="col-md-3">
                        <div class="product-item">
                            <div class="pi-img-wrapper">
                                <img src="<?php echo base_url() . 'assets/images/accessory/' . $row->thumbnail; ?>" class="img-responsive" alt="<?php echo $row->title; ?>">
                            </div>
                            <h3><a href="#"><?php echo $row->title; ?></a></h3>
                            <div class="pi-price">Price : $<?php echo $row->price; ?></div>
                            <div class="clear"></div>
                            <?php echo $row->short_des; ?>
                            <?php
                            if ($row->is_new == 1) {
                                echo '<div class="sticker sticker-new"></div>';
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                    if (($i % 4) == 0) {
                        echo '<div class="clear"></div>';
                    }
                }
                ?>
                <div class="clear"></div><br/><br/>
            </div>
        </div>
        <!-- new style -->

    </div>
    <?php
}
?>