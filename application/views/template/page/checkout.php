<div class="container">
    <form action="<?php echo base_url('page/checkoutprocess') ?>" class="checkout-section" method="post" name="checkout">
        <h4 class="title-checkout">Biiling Address</h4>
        <div class="row">
                <div class="form-group col-md-6">   
                    <label class="title">First Name: <?php echo $userdatas[0]['first_name'] ?></label> 
                </div>
                <div class="form-group col-md-6">   
                    <label class="title">Last Name : <?php echo $userdatas[0]['last_name'] ?></label> 
                </div>
                <div class="form-group col-md-6">
                    <label class="title">Email Addreess: <?php echo $userdatas[0]['email'] ?></label>
                </div>
                <div class="form-group col-md-6">
                    <label class="title">Phone numbber: <?php echo $userdatas[0]['phone_number'] ?></label>
                </div>
                <div class="form-group col-md-6">
                    <label class="title">Address: <?php echo $userdatas[0]['address'] ?></label>
                </div>
                <div class="form-group col-md-6">
                    <label class="title">Country: <?php echo $userdatas[0]['country'] ?></label>
                </div>
                <div class="form-group col-md-6">
                    <label class="title">Postcode / ZIP: <?php echo $userdatas[0]['post_code'] ?></label>
                </div>
                <div class="form-group col-md-6">
                    <label class="title">Town / City: <?php echo $userdatas[0]['town'] ?></label>
                </div>
            <div class="form-group payment col-md-12">
                <h4 class="title-checkout">Payment Method</h4>
                <ul>
                    <li><label class="inline"><input type="checkbox" checked="checked"><span class="input"></span>Cash on Hand</label></li>
                </ul>
                <span class="grand-total">Grand Total<span>$ <?php echo $grandtotal ?></span></span>
                <div class="">
                  <button type="submit" class="btn-order">Place Order Now</button>
                </div>
            </div>
        </div>
    </form>
</div>