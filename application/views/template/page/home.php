<style>
    .holder_img {
        position: relative;
        padding: 0;
    }

    .image {
        display: block;
        width: 100%;
        height: auto;
    }

    .overlay {
        position: absolute;
        bottom: 100%;
        left: 0;
        right: 0;
        background-color:rgba(105, 191, 42, 0.8);
        overflow: hidden;
        width: 100%;
        height:0;
        transition: .5s ease;
    }

    .holder_img:hover .overlay {
        bottom: 0;
        height: 100%;
    }

    .text {
        white-space: nowrap; 
        color: white;
        font-size: 20px;
        position: absolute;
        overflow: hidden;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
    }
</style>

<div style="background: #F6F6F6; color: #7e7e7e;">

    <div class="clear"></div> <br/>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="clear"></div> <br/>

                <h2 class="content_title">THE LATEST FROM KAWASAKI</h2>
                <div style="   float: right; border-bottom: 1px solid #717171;"></div>
                <div class="clear"></div><br/>

                <ul class="nav nav-tabs nav-justified home_tab" role="tablist">
                    <li role="presentation" class="active"><a href="#test" aria-controls="test" role="tab" data-toggle="tab">OFFERS, PROMOTIONS & MORE</a></li>
                    <li role="presentation" class=""><a href="#test2" aria-controls="test2" role="tab" data-toggle="tab">FEATURED VEHICLES</a></li>
                    <li role="presentation" class=""><a href="#social_community" aria-controls="social_community" role="tab" data-toggle="tab">SOCIAL COMMUNITY</a></li>
                    <li role="presentation" class=""><a href="#closet_dealer" aria-controls="closet_dealer" role="tab" data-toggle="tab"> KAWASAKI DEALERS</a></li>
                </ul>

                <div class="tab-content home_tab_content">
                    <div role="tabpanel" class="tab-pane active" id="test"  style="background: none;">
                        <div class="row">
                            <div class="clear"></div> <br/><br/>
                            <?php
                            $i = 0;
                            foreach ($special_offers->result() as $special_offer) {
                                $i++;
                                ?>
                                <div class="col-sm-4 text-center">
                                    <a href="<?php echo base_url() . 'page/special_offers/' . $special_offer->url_slug; ?>">
                                        <img src="<?php echo base_url() . "assets/images/special_offer/" . $special_offer->thumbnail; ?>" class="img-responsive" alt="Images" />
                                    </a>
                                    <a class="" href="<?php echo base_url() . 'page/special_offers/' . $special_offer->url_slug; ?>"><h3 class="home_title_small"><?php echo $special_offer->title_small; ?></h3></a>
                                    <a class="" href="<?php echo base_url() . 'page/special_offers/' . $special_offer->url_slug; ?>"><h4 class="home_title"><?php echo $special_offer->title; ?></h4></a><br/>

                                </div>
                                <?php
                                if ($i % 3 == 0) {
                                    echo '<div class="clear"></div><br/><br/>';
                                }
                            }
                            ?>

                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane " id="test2"  style="background: none;">
                        <div class="clear"></div> <br/><br/>
                        <?php
                        $i = 0;
                        foreach ($model_home->result() as $row) {
                            $i++;
                            $str_slug = url_title($row->model_name, 'dash', TRUE);
                            ?>

                            <div class="col-lg-4 col-md-4  text-center">
                                <a class="model_title_home" href="<?php echo base_url() . 'page/model/' . $row->url_slug; ?>">
                                    <img src="<?php echo base_url() . 'assets/images/model_thumbnail/' . $row->thumbnail; ?>" alt="<?php echo $row->model_name; ?>" class="image">
                                </a>

                                <span class="model_year_home">ALL-NEW </span>
                                <a class="model_title_home" href="<?php echo base_url() . 'page/model/' . $row->url_slug; ?>">
                                    <?php echo $row->model_name; ?>
                                </a>
                                <br/><br/>                                        
                            </div>
                            <?php
                            if ($i % 3 == 0) {
                                echo '<div class="clear"></div><br/>';
                            }
                        }
                        ?>

                    </div>

                    <div role="tabpanel" class="tab-pane" id="social_community" style="background: none;">
                        <div class="clear"></div> <br/><br/>
                        <a class="home_title" href="#">SOCIAL COMMUNITY</a><br/>

                        <?php
                        $i = 0;
                        foreach ($social_communities->result() as $social_community) {
                            $i++;
                            ?>
                            <div class="col-sm-4 text-center">
                                <a href="<?php echo $social_community->linkto; ?>" target="_blank">
                                    <img src="<?php echo base_url() . "assets/images/social_community/" . $social_community->thumbnail; ?>" class="img-responsive" alt="Img" />
                                </a>
                            </div>
                            <?php
                            if ($i % 3 == 0) {
                                echo '<div class="clear"></div><br/>';
                            }
                        }
                        ?>

                    </div>

                    <div role="tabpanel" class="tab-pane" id="closet_dealer" style="background: none;">
                        <div class="clear"></div> <br/><br/>
                        <div class="col-md-12">

                            <a href="" class="home_title_small" style="font-size: 25px;"> <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> Kawasaki Cambodia Dealer</a><br/>
                            <strong> Address : </strong> No 92, Confederation de la Russie (110),
                            Sangkat Tek La Ork I, Khan Toul Kork, Phnom Penh
                        </div>
                        <div class="col-md-12">
							<div class="clear"></div> <br/><br/>
                            <?php
                            foreach ($dealers->result() as $dealer) {

                                echo '<div class="col-md-4">'
                                . '<div class="clear"></div>
                                    <h2><strong><a href="' . $dealer->link . '"  target="_blank" class="kawa_txt_color" > <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> ' . $dealer->name . '</a></strong></h2>
                                    <p style="font-size: 20px;"><strong>Phone :</strong> ' . $dealer->phone . ' <strong>Address :</strong> ' . $dealer->address . '
                                     </p>';
                                echo '</div>';
                            }
                            ?>
                            <div class="clear"></div> <br/><br/>
                        </div>


                        <div class="col-md-12">
                            <div class="map-responsive">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3908.753166192106!2d104.89677671447346!3d11.569544591786329!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x310951144c564457%3A0x5b09bec1abe27a19!2sKawasaki+Motors+Cambodia!5e0!3m2!1sen!2skh!4v1512554227060" width="1200" height="500" frameborder="0" style="border:0" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clear"></div> <br/><br/>
            </div>
        </div>
    </div>

</div>
<!-- map section  class = map-home -->

<div class="map-home">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1>CONTACT US</h1>
                <h2>Kawasaki Motors Cambodia </h2>
                <strong>Email</strong> : info@kawasaki.com.kh <br/>
                <strong>Phone Number </strong>	: 	095 333 501/503 , 069 333 501<br/>
                <strong>Address </strong>	: 	No 92, Confederation de la Russie (110),<br/> Sangkat Tek La Ork I, Khan Toul Kork, Phnom Penh<br/>
                <br/><a target="_new" style="background: #69BF2A;" href="https://www.google.com.kh/maps/place/Kawasaki+Motors+Cambodia/@11.5685986,104.8980142,15.38z/data=!4m5!3m4!1s0x310951144c564457:0x5b09bec1abe27a19!8m2!3d11.5693554!4d104.8987937?hl=en"  class="btn  contact-btn">VIEW MAP</a>
            </div>
        </div>
    </div>
</div>

