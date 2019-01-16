<div style="background: #F6F6F6; color: #000;">
<!--   banner     -->
<!--<img class="img-responsive" width="100%" src="<?php echo base_url(); ?>assets/images/accessory/1.jpg" />-->

<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5528.0762367795705!2d104.85682292390305!3d11.556145189075623!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x310951144c564457%3A0x5b09bec1abe27a19!2sKawasaki+Motors+Cambodia!5e0!3m2!1sen!2skh!4v1493280022911" width="100%" height="500" frameborder="0" style="border:0" allowfullscreen></iframe>
<div class="clear"></div>

<div class="container">  
    <div class="row">
        <div class="col-lg-12">

        </div>
        <div class="col-lg-6">
            <div class="clear"></div><br/><br/>
            <h2 class="content_title text-center"><span class="kawa_txt_color"> CONTACT US</span></h2>
            <div class="clear"></div><br/>

            <?php
            if (isset($_GET['status'])) {
                echo '<h3 class="text-center">Thank for submitting your information.</h3><br/>';
            }
            ?>

            <form class="form-horizontal contact_input" method="post" action="<?php echo base_url() . 'page/contact_us' ?>">
                <div class="form-group ">
                    <label for="fullname" class="col-sm-3 control-label">Full Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="fullname" placeholder="Full Name" name="full_name" required="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" id="inputEmail3" placeholder="Email" name="email" required="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone" class="col-sm-3 control-label">Phone Number</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="phone" placeholder="Phone Number" name="phone" required="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="message" class="col-sm-3 control-label">Message</label>
                    <div class="col-sm-9">
                        <textarea name="message" class="form-control" id="message" placeholder="Message" rows="5"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <input type="submit" class="btn contact-btn" name="submit_contact" value="Send message" style="color: #000">
                    </div>
                </div>
                <br/>
            </form>

        </div>
        <div class="col-lg-6">
            <div class="clear"></div><br/><br/>
            <h3 class="title_kawa text-center"><span class="kawa_txt_color"> Kawasaki Motors Cambodia</span></h3>
            <br/>
            <table style="width: 100%;" class="contact_table">
                <tr>
                    <td style="width: 25%;"><strong class="kawa_txt_color"> Address </strong></td>
                    <td style="width: 5%;"> : </td>
                    <td> No 92, Confederation de la Russie (110), Sangkat Tek La Ork I, Khan Toul Kork, Phnom Penh</td>
                </tr>
                <tr>
                    <td><strong class="kawa_txt_color">Phone Number </strong></td>
                    <td> : </td>
                    <td> 095 333 501/503 , 069 333 501</td>
                </tr>
                <tr>
                    <td><strong class="kawa_txt_color"> Email </strong></td>
                    <td> : </td>
                    <td> info@kawasaki.com.kh</td>
                </tr>

            </table>




        </div>
    </div>
</div>


</div>