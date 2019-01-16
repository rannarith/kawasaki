<?php
    if (isset($this->session->userdata['processing'])) {?>
        <div class="alert alert-success fade in alert-dismissible ordersuccess">
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            <strong>Success!</strong> Thank you for your order.
        </div>
    <?php } ?>
<!--         navbar-fixed-top  navbar-fixed-top-->
<div class="header-upper">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="header-links pull-right">
                    <ul>
                        <?php
                            if (isset($this->session->userdata['logged_in'])) {?>
                                <li><i class="fas fa-user"></i> <?php echo $this->session->userdata['user_data']['email'] ?></li>    
                                <li><a href="<?php echo base_url('page/logout')?>"><i class="fas fa-sign-out-alt"></i><span class="header-link-label">&nbsp;Log out</span></a></li>
                                <li>
                                    <a href="<?php echo base_url() . 'page/user_wishlist' ?>">
                                        <i class="fa fa-heart header-link-icon"></i>
                                        <span class="wishlist-label header-link-label">Wishlist</span>
                                        <span class="wishlist-qty">(0)</span>
                                    </a>
                                </li>

                        <?php }?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<nav class="navbar yamm navbar-inverse navbar-custom " role="navigation" >
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="col-md-5 col-sm-5 col-xs-7" style="padding-left: 17px; ">
                    <a  href="<?php echo base_url(); ?>">
                        <img src="<?php echo base_url(); ?>assets/images/kawasaki_logo.png" class="img-responsive" alt="logo" />
                        <div class="clear"></div>
                    </a>
                </div>
                
            </div>
        </div>
    </div>
    <!-- /.container -->
    <!-- menu -->
    <div class="clear"></div> <br/>
    <div class="container top_nav" style="padding-top: 10px;" >
        <div class="row">
            <div class="col-lg-12">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav top-menu">
                        <!-- 
                        <?php
                        //// active class
                        $segment2 =  $this->uri->segment(2);

                        $active_class = '';
                        if ($this->uri->segment(1) == "" && $this->uri->segment(2) == "" || $this->uri->segment(1) == "page" && $this->uri->segment(2) == "") {
                            $active_class = 'class="actives"';
                        }
                        ?>
                        <li <?php echo $active_class ?>>
                            <a href="<?php echo base_url(); ?>">HOME </a>
                        </li> -->


                        <?php
                        $active_class = '';
                        if ($this->uri->segment(2) == "model" || $this->uri->segment(2) == "model_detail") {
                            $active_class = 'class="actives"';
                        }
                        ?>
                        <li <?php echo $active_class; ?>>
                            <a href="#" data-toggle="dropdown" id="model_motor" class="dropdown-toggle">MOTORCYCLE <span class="caret"></span></a>
                        </li>
                        
                        <?php
                        $active_class = '';
                        if ($this->uri->segment(2) == "accessory" || $this->uri->segment(2) == "part" || $this->uri->segment(2) == "allaccessory_part") {
                            $active_class = 'actives';
                        }
                        ?>

                        <li class="<?php echo $active_class; ?>">
                            <a href="<?php echo base_url() . 'page/allaccessory_part' ?>">ACCESSORIES & APPAREL</a>
                        </li>
                      
                        <li class="<?php echo $segment2=='special_offers'?'actives':''; ?>">
                            <a href="<?php echo base_url() . 'page/special_offers' ?>">PROMOTION & EVENTS</a>
                        </li>
                        
                        <li class="<?php echo $segment2=='news_event'?'actives':''; ?>">
                            <a href="<?php echo base_url() . 'page/news_event' ?>">NEWS</a>
                        </li>

                        <li class="<?php echo $segment2=='dealer'?'actives':''; ?>">
                            <a href="<?php echo base_url() . 'page/dealer' ?>">DEALERS</a>
                        </li>
                        <?php
                        $active_class = '';
                        if ($this->uri->segment(2) == "about_us") {
                            $active_class = 'class="actives"';
                        }
                        ?>

                        <li class="dropdown dropdown-submenu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">WHO WE ARE</a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo base_url() . 'page/about_us' ?>">ABOUT COMPANY</a></li>
                                <li><a href="<?php echo base_url() . 'page/career' ?>">JOIN WITH US</a></li>
                            </ul>
                        </li>

                       
                        <li class="<?php echo $segment2=='contact_us'?'actives':''; ?>">
                            <a href="<?php echo base_url() . 'page/contact_us' ?>">CONTACT US</a>
                        </li>
                        
						<?php
                            if (isset($this->session->userdata['logged_in'])) {?>
                                <li class="cart">
                                    <a href="<?php echo base_url()."page/cart_view" ?>" class="cartbox">
                                        <i class="fas fa-cart-plus"></i>
                                        <span class="amount">
                                            <?php 
                                                if(isset($this->session->userdata['count'])){
                                                    echo $this->session->userdata['count'];
                                                }else{
                                                    echo 0;
                                                }
                                            ?>
                                        </span>
                                    </a>
                                </li>      
                       <?php  }?>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
        </div>
    </div>
    <div class="clear"></div>

</nav>



<div class="menu_model" style="background: white; ">
    <div class="container ">
        <div class="row">
            <div class="col-lg-12 model_top_menu">
                <!-- Nav tabs -->
                <ul class="nav  nav-tabs menu-tab" role="tablist">
                    <li role="presentation"><a href="<?php echo base_url().'page/all_model'; ?>" style="color: #69be28;">VIEW ALL <span class="glyphicon glyphicon-triangle-right" aria-hidden="true" style="font-size: 16px;"></span></a></li>
                    <?php
                    $i = 0;
                    foreach ($menu_category->result() as $row) {
                        $i++;
                        $active = '';
                        if ($i == 1) {
                            $active = ' class="active" ';
                        }
                        $category_id = $row->category_id;

                        echo '<li role="presentation" ' . $active . '><a href="#category' . $category_id . '" aria-controls="category' . $category_id . '" role="tab" data-toggle="tab">' . $row->category_name . '</a></li>';
                    }
                    ?>
                   
                </ul>

                <!-- Tab panes -->
                <div class="tab-content " style="">
                    <?php
                    $i = 0;
                    foreach ($menu_category->result() as $row) {
                        $i++;
                        $active = '';
                        if ($i == 1) {
                            $active = ' active ';
                        }
                        $category_id = $row->category_id;
                        ?>
                        <div role="tabpanel" class="tab-pane <?php echo $active; ?>" id="category<?php echo $category_id; ?>">
                            <div class="hold-thumb">
                                <?php
                                //// get model by category 
                                $model_menu = $this->m_page->getMenuModel($category_id);
                                $i = 0;
                                foreach ($model_menu->result() as $row) {
                                    $i++;
                                    $icon_menu = $row->icon_menu;
                                    
                                    if($row->is_available == 0){
                                        $pre_order = '<br/><span class="pre-order-text">Pre Order</span>';
                                    } else {
                                        $pre_order = ' ';
                                    }
                                    ?>
                                    <div class="col-xs-6 col-sm-2 thumb-menu">
                                        <a href="<?php echo base_url() . 'page/model/' . $row->url_slug; ?>" class="thumbnail"><img alt="<?php echo $row->model_name; ?>" src="<?php echo base_url() . 'assets/images/model_menu/' . $icon_menu; ?>"></a>
                                        <a href="<?php echo base_url() . 'page/model/' . $row->url_slug; ?>" class="model-title"><?php echo $row->model_name; ?></a>
                                        
                                        <?php echo $pre_order; ?>
                                        
                                        <p><span style="color: #7e7e7e;font-size: 18px;">Displacement: <?php echo $row->displacement; ?></span></p> 
                                    </div>
                                    <?php
                                    if($i%6 == 0){
                                        echo '<div class="clear"></div>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>


