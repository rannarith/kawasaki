<!--        Home slideshow-->
<div class="h-slide" >
    <div id="jssor_1" style="position: relative; margin: 0 auto; top: 0px; left: 0px; width: 1920px; height: 650px; overflow: hidden; visibility: hidden;">
        <!-- Loading Screen -->
        <div data-u="loading" style="position: absolute; top: 0px; left: 0px;">
            <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
            <div style="position:absolute;display:block;background:url('<?php echo base_url(); ?>assets/images/loading.gif') no-repeat center center;top:0px;left:0px;width:100%;height:100%;"></div>
        </div>
        <div data-u="slides" style="cursor: default; position: relative; top: 0px; left: 0px; width: 1920px; height: 650px; overflow: hidden;">
            <?php
            foreach ($homeslide->result() as $row){
                $image = $row->image;
                ?>
                <div>
                    <a href="<?php echo $row->linkto; ?>" alt="<?php echo $row->name; ?>">
						<img u="image" src="<?php echo base_url().'assets/images/slideshow/'.$image; ?>" alt="<?php echo $row->name; ?>" />
					</a>
                </div>
            <?php
            }
            ?>
        </div>
        <!-- Bullet Navigator -->
        <div data-u="navigator" class="jssorb05" style="bottom:16px;right:16px;" data-autocenter="1">
            <!-- bullet navigator item prototype -->
            <div data-u="prototype" style="width:16px;height:16px;"></div>
        </div>
        <!-- Arrow Navigator -->
        <span data-u="arrowleft" class="jssora22l" style="top:0px;left:12px;width:40px;height:58px;" data-autocenter="2"></span>
        <span data-u="arrowright" class="jssora22r" style="top:0px;right:12px;width:40px;height:58px;" data-autocenter="2"></span>

    </div>
</div>
<div class="clear"></div>
