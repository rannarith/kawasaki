<!--   banner     -->
<!--<img class="img-responsive" width="100%" src="<?php echo base_url(); ?>assets/images/accessory/1.jpg" />-->
<div style="background: #F6F6F6; color: #818181;">


    <div class="container">  
        <div class="row">
            <div class="col-lg-12">
                <div class="clear"></div><br/>
                <h2 class="content_title" ><span class="kawa_txt_color"> PROMOTION</span></h2>
                <div class="clear"></div><br/>
            </div>
            <?php
            if (($this->uri->segment(3) != "") && ($special_offer_detail->num_rows() > 0)) {
                $special_offer_detail_row = $special_offer_detail->row();
                $title = $special_offer_detail_row->title;
                $thumbnail = $special_offer_detail_row->thumbnail;
                $description = $special_offer_detail_row->description;
                ?>  
                <div class="col-lg-6 " >
                    <img src="<?php echo base_url() . "assets/images/special_offer/" . $thumbnail; ?>" class="img-responsive" alt="<?php echo $title; ?>" />
                </div>
                <div class="col-lg-6">
                    <h2 class="kawa_txt_color"><strong><?php echo $title; ?></strong></h2>
                    <?php echo $description; ?>

                    <!-- share on social media -->
                    <div class="clear"></div> <br/>
                    Share On Social Media
                    <a href="http://www.facebook.com/sharer.php?u=<?php echo base_url().'page/special_offers/'.$this->uri->segment(3); ?>" target="_blank">
                        <img src="<?php echo base_url() . 'images/fb.png'; ?>" alt="kawasaki social link" style="width: 40px;"/>
                    </a>
                    <a href="https://plus.google.com/share?url=<?php echo base_url().'page/special_offers/'.$this->uri->segment(3); ?>"  target="_blank">
                        <img src="<?php echo base_url() . 'images/gplus.png'; ?>" alt="kawasaki social link" style="width: 40px;"/>
                    </a>
                </div>
                <div class="clear"></div> <br/><br/>
                <?php
            }
            ?>

            <div class="clear"></div> 
            <?php
            $i = 0;
            foreach ($special_offers->result() as $special_offer) {
                $i++;
                ?>
                <div class="col-sm-4 text-center">
                    <a href="<?php echo base_url() . 'page/special_offers/' . $special_offer->url_slug; ?>">
                        <img src="<?php echo base_url() . "assets/images/special_offer/" . $special_offer->thumbnail; ?>" class="img-responsive" alt="Images" />
                    </a>
                    <br/>
                    <a class="home_title_small" href="<?php echo base_url() . 'page/special_offers/' . $special_offer->url_slug; ?>"><?php echo $special_offer->title_small; ?></a><br/>
                    <a class="home_title" href="<?php echo base_url() . 'page/special_offers/' . $special_offer->url_slug; ?>"><?php echo $special_offer->title; ?></a><br/>

                </div>
                <?php
                if ($i % 3 == 0) {
                    echo '<div class="clear"></div><br/><br/>';
                }
            }
            ?>

            <div class="clear"></div> <br/><br/>


        </div>



    </div>
</div>


