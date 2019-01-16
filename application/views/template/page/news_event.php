
<div class="blog" style="background: #F6F6F6; color: #7e7e7e;">
    <div class="container">

        <div class="row">
            <div class="col-lg-12">  
                
                <h2 class="content_title"><span class="kawa_txt_color"> &nbsp;&nbsp;NEWS AND EVENT</span></h2>
                <div class="clear"></div><br/>
                
            </div> 
        </div>  

        <div class="row">

            <?php
            $i = 0;
            foreach ($news_info->result() as $row) {
                $i++;
                ?>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" data-aos="fade-right" style="margin-bottom: 30px;">
                    <div class="col-lg-6 col-xs-12">
                        <img src="<?php echo base_url() . 'assets/images/news/' . $row->thumbnail; ?>" alt="<?php echo $row->title; ?>" width="100%">
                    </div>

                    <div class="col-lg-6 col-xs-12">
                        <div class="blog-column">
                            <span class="title"><?php echo $row->title; ?></span>
                            <br/><small><?php echo $row->news_date; ?></small><br/>
                            <p><?php echo $row->short_des; ?></p>
                            <a href="<?php echo base_url() . 'page/news_detail/' . $row->url_slug; ?>">Read More</a>
                        </div>
                        <br/>
                    </div>
                    <br/>
                </div>

            <?php 
            if($i%2 == 0){
                echo '<div style="clear: both;"></div>';
            }
            }
            ?>

            

        </div>

        <div class="row">
            <div class="col-lg-12 text-center" style="padding-left: 30px;">
                <div class="clear"></div><br/><br/>
                <?php echo $links_pagination; ?>
                <div class="clear"></div><br/>
            </div>
            
        </div>
    </div>
</div>
