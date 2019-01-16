
<div class="box" style="background: #F6F6F6; ">
    <div class="container">
    <div class="row">
            <div class="col-lg-12">  
                
                <h2 class="content_title"><span class="kawa_txt_color"> &nbsp;&nbsp;OUR DEALERS</span></h2>
                <div class="clear"></div><br/>
                
            </div> 
        </div> 
    </div>
    <div class="container">
        <div class="row">
			
						<?php
							$i = 0;
                            foreach ($dealers->result() as $dealer) {
								$i++;
								?>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
									<div class="box-part text-center">
										<i class="fa fa-behance fa-3x" aria-hidden="true"></i>
										<div class="title">
											<h3><?php echo $dealer->name; ?> </h3>
											<h3> <?php echo $dealer->phone; ?></h3>
										</div>
										<div class="text">
											<span><?php echo $dealer->address; ?></span>
										</div>
										
									</div>
								</div>
								<?php
								if($i%3 == 0){
									echo '<div class="clear"></div>';
								}

                                
                            }
                            ?>
			
            
        </div>		
    </div>
</div>