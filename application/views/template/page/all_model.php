
<div class="blog" style="background: #F6F6F6; color: #7e7e7e; line-height: 100%;">
    <div class="container">

        <div class="row">
            <div class="col-lg-offset-1 col-lg-10 ">  
                <h2 class="content_title kawa_txt_color" >ALL MODELS </h2>
                <div class="clear"></div><br/>

            </div> 
        </div>  

        <div class="row">
            <div class="col-lg-offset-1 col-lg-10 ">
                <?php
                foreach ($all_categories->result() as $category) {
                    echo '<h2 class="title_kawa" >' . $category->category_name . '</h2>';

                    $category_id = $category->category_id;

                    //// get model by category 
                    $model_menu = $this->m_page->getMenuModel($category_id);
                    $i = 0;
                    foreach ($model_menu->result() as $row) {
                        $i++;
                        $icon_menu = $row->icon_menu;
                        
                        if ($row->is_available == 0) {
                            $pre_order = '<br/><span class="pre-order-text">Pre Order</span>';
                        } else {
                            $pre_order = ' ';
                        }
                        ?>
                        <div class="col-xs-6 col-sm-3 thumb-menu text-center">
                            <a href="<?php echo base_url() . 'page/model/' . $row->url_slug; ?>" class="thumbnail">
                                <img alt="<?php echo $row->model_name; ?>" src="<?php echo base_url() . 'assets/images/model_menu/' . $icon_menu; ?>">
                            </a>
                             <!--<span class="model-title kawa_txt_color" style="font-size: 18px;">Displacement:<?php echo $row->displacement; ?></span><br/> -->
                            <a href="<?php echo base_url() . 'page/model/' . $row->url_slug; ?>" class="model-title2">
                                <?php echo $row->model_name; ?>
                            </a>
                            <br/><span class="model-year-text">Displacement: <?php echo $row->displacement; ?></span><br/> 
                            <span class="model-year-text"> Year: <span><?php echo $row->model_year; ?></span></span>
                            <?php echo $pre_order; ?>
                        </div>
                        <?php
                        if ($i % 4 == 0) {
                            echo '<div class="clear"></div>';
                        }
                    }
                    echo '<div class="clear"></div>';
                    echo '<hr class="style-two"/>';
                }
                ?>
            </div>
        </div>        
    </div>
</div>
