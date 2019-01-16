


<div class="container">
        <div class="row">
            <div class="col-lg-12">
                <?php $segment2 =  $this->uri->segment(2); ?>

                <ul class="nav nav-tabs nav-justified md_features" role="tablist">
                    <li class="<?php echo $segment2=='allaccessory_part'?'active':''; ?>"><a href="<?php echo base_url().'page/allaccessory_part' ?>" >ALL accessories and parts</a></li>
                    <li class="<?php echo $segment2=='accessory'?'active':''; ?>"><a href="<?php echo base_url().'page/accessory' ?>" >Accessories </a></li>
                    <li class="<?php echo $segment2=='part'?'active':''; ?>"><a href="<?php echo base_url().'page/part' ?>" >PARTs </a></li>
                    <li class="<?php echo $segment2=='merchandise'?'active':''; ?>"><a href="<?php echo base_url().'page/merchandise' ?>" >Merchandise </a></li>
                </ul>
            </div>
        </div>
</div>
<div class="clear"></div><br/>