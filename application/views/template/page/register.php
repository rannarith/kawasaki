

<div class="container">
  <div class="row">
    <h2 class="loginlabel">Register </h2>
    <div class="login">
      <div class="col-sm-12">
        <form action="<?php echo base_url().'page/insertuser/'?>" class="checkout-section" method="post" name="checkout">
        <div class="row">
            <div class="form-group col-md-12"> 
                  <?php
                if (isset($this->session->userdata['checkuser'])) {
              ?>
                <div class="alert alert-danger" role="alert">
                  <strong>Oh snap!</strong> User already exist! Please try again.
                </div>
              <?php }?>
            </div>
            <div class="form-group col-md-6 facebooklogin">
                <a href="<?php echo site_url('page/facebooklogin')?>">
                  <img src="<?php echo site_url('assets/images/login/fa.PNG') ?>">
                </a>
            </div>
            <div class="form-group col-md-6 facebooklogin">
                <a href="<?php echo site_url('page/googlelogin') ?>">
                  <img src="<?php echo site_url('assets/images/login/gl.PNG') ?>">
                </a>
            </div>
            <div class="form-group col-md-12" style="text-align: center;">
                <label>Or</label>
            </div>
            <div class="form-group col-md-6">   
                <label class="title">First Name *</label> 
                <input type="text" class="form-control" id="inputfname" placeholder="First Name" required="required" name="fname">
            </div>
            <div class="form-group col-md-6">   
                <label class="title">Last Name *</label>
                <input type="text" class="form-control" id="inputlname" placeholder="Last Name" required="required" name="lname">
            </div>
            <div class="form-group col-md-6">
                <label class="title">Email Addreess *</label>
                <input type="text" class="form-control" id="inputemail" placeholder="Email Address" required="required" name="email">
            </div>
            <div class="form-group col-md-6">
                <label class="title">Phone numbber *</label>
                <input type="text" class="form-control" id="inputphone" placeholder="Phone Number" required="required" name="phone">
            </div>
            <div class="form-group col-md-6">
                <label class="title">Address *</label>
                <input type="text" class="form-control" id="inputaddress" placeholder="Address" required="required" name="address">
            </div>
            <div class="form-group col-md-6">
                <label class="title">Country *</label>
                <input type="text" class="form-control" id="inputcountry" placeholder="Country" required="required" name="country" value="Cambodia">
            </div>
            <div class="form-group col-md-6">
                <label class="title">Town / City *</label>
                <select class="form-control town" name="town" style="height: 40px;font-size: 19px;">
                    <?php foreach ($towns->result() as $key => $town) {?>
                        <option value="<?php echo $town->state_name ?>"><?php echo $town->state_name ?></option>
                    <?php } ?>
                </select>
                <!-- <input type="text" class="form-control" id="inputtown" placeholder="Town / City" required="required" name="town"> -->
            </div>
            <div class="form-group col-md-6">
                <label class="title">Postcode / ZIP *</label>
                <input type="text" class="form-control" id="inputpost" placeholder="Postcode / ZIP" required="required" name="post">
            </div>
            <div class="form-group col-md-12">
                <label class="title">Password *</label>
                <input type="password" class="form-control" id="inputtown" placeholder="Password" required="required" name="password">
            </div>
             <div class="form-group col-md-6"></div>
            <div class="form-group col-md-12">
                <button type="submit" class="btn-order register">Register</button>
            </div>
            
        </div>
    </form>
      </div>
      <div style="clear: both;"></div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
      $(".town").on("change", function(){
        var town = $(".town").val();
        var url = "<?php echo site_url(); ?>";
        $.ajax({
            type:"GET",
            url: url+"page/getpostcode",
            data:{town:town},
            success:function(data){
               $("#inputpost").val(data);         
            }
        })
      })
  })
</script>