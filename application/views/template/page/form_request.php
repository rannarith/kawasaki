<!--   banner     -->
<!--<img class="img-responsive" width="100%" src="<?php echo base_url(); ?>assets/images/accessory/1.jpg" />-->

<div class="container">  
    <div class="row">
        <div class="col-lg-12">

        </div>
        <div class="col-lg-offset-1 col-lg-8">
            <div class="clear"></div><br/><br/>
            <h2 class="content_title text-center"><span class="kawa_txt_color">GET AN UPDATE</span></h2>
            <div class="clear"></div><br/>
            
            <?php
            if(isset($_GET['status'])) {
                echo '<h3 class="text-center">Thank for submitting your information.</h3><br/>';
            }
            
            ?>
            <form class="form-horizontal contact_input" method="post" action="<?php echo base_url().'page/form_request' ?>"> 
                <div class="form-group ">
                    <label for="fullname" class="col-sm-4 control-label">Full Name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="fullname" placeholder="Full Name" name="fullname" required="">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">Email</label>
                    <div class="col-sm-8">
                        <input type="email" class="form-control" id="inputEmail3" placeholder="Email" required="" name="email">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="phone" class="col-sm-4 control-label">Phone Number</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="inputEmail3" placeholder="Phone Number" required="" name="phone">
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone" class="col-sm-4 control-label">Model</label>
                    <div class="col-sm-8">
                        <select class="form-control" name="motormodel">
                            <option value="">Please select a model</option>
                            <?php
                            foreach ($allmodel->result() as $row){
                                echo '<option = value="'.$row->model_name.'">'.$row->model_name.'</option>';
                            }
                            
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone" class="col-sm-4 control-label">Message</label>
                    <div class="col-sm-8">
                        <textarea name="message" class="form-control" placeholder="Message" rows="5"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <input type="submit" class="btn  contact-btn" name="submit" value="Send message">
                    </div>
                </div>
                <br/>
            </form>
            

        </div>
        
    </div>
</div>


