<div class="">
    
    <ul class="about-list">
        <?php
            $active = "";
            if($this->uri->segment(2) == "about_us"){
                $active = "active";
            }
        ?>
        <li class=""><a href="<?php echo base_url()."page/about_us"; ?>" class="<?php echo $active; ?>">WHO WE ARE</a></li>
        <?php
            $active = "";
            if($this->uri->segment(2) == "career"){
                $active = "active";
            }
        ?>
        <li class=""><a href="<?php echo base_url()."page/career"; ?>" class="<?php echo $active; ?>">JOIN WITH US</a></li>
    </ul>
</div>