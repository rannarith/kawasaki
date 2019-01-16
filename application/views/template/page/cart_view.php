 <div class="breadcrumb"></div>
 <div class="container card">
    <div class="col-lg-12">
        <h1>Shopping cart</h1>
    </div>
    <div class="col-lg-9">
        
        <div class="product-single-container product-single-default cardview">
    	<div class="alert alert-danger false" role="alert" style="display: none;">
          <strong>Well done!</strong> You successfully update this card.
        </div>
            <?php if(count($list->result()) > 0 ){ ?>
            	<table>
            		<thead>
	            		<th>Product Name</th>
	            		<th width="35%">Thumbnail</th>
                        <th>Size</th>
	            		<th>Unit Price</th>
	            		<th>Qty</th>
	            		<th>Subtotal</th>
            		</thead>
            		<tbody>
                        <?php 
                            foreach ($list->result() as $key => $result) {
                                foreach($accessories->result() as $accessory){ 
                                    if($result->item_id == $accessory->acs_id){
                        ?>
                                        <tr>
                                            <td><?php echo $accessory->title ?></td>
                                            <td class="addtocardthumbnail">
                                                <img src="<?php echo site_url()."/"."assets/images/accessory/".$accessory->thumbnail?>">
                                            </td>
                                            <td><?php echo $result->item_size ?></td>
                                            <td>$ <?php echo $result->item_price ?></td>
                                            <td><input type="number" id="quantity_5c171ca58f6f0" onchange="updatecard('<?php echo $result->id ?>')" data="<?php echo $result->id ?>" class="<?php echo $result->id ?> input-text qty text" step="1" min="1" max="" name="quantity" value="<?php echo $result->item_amount ?>" title="Qty" size="4" pattern="[0-9]*" inputmode="numeric" aria-labelledby=""></td>
                                            <td>$ <?php echo $result->item_price * $result->item_amount ?></td>
                                            <td><p class="remove" onclick="clearcard('<?php echo $result->id ?>')"><i class="fa fa-times" aria-hidden="true"></i></p></td>
                                        </tr>
                        <?php 
                                    }
                                } 
                            } 
                        ?>
            		</tbody>
            	</table>
        	<?php }else{ ?>
        		<p class="empty-cart">Your cart is currently empty.</p>
        	<?php } ?>
        </div>
    </div>
    <div class="col-lg-3">

        <div class="checkout">
            <form method="POST" action="<?php echo base_url().'page/checkout/'?>">
            <table>
                    <?php 
                        $subprice = [];
                        foreach ($list->result() as $key => $result) {
                            foreach($accessories->result() as $accessory){ 
                                if($result->item_id == $accessory->acs_id){
                                   $subprice [] = $result->item_price * $result->item_amount;   
                                }
                            } 
                        } 
                    ?>

                        <tr>
                            <td>SUBTOTAL</td>
                            <td>
                                <?php
                                    $sub = 0 ;
                                    foreach ($subprice as $key => $value) {
                                      
                                        $sub+= $value;
                                    }
                                    echo "$ ".$sub;
                                 ?>
                            </td>
                        </tr>
                        <tr>
                            <td>GRAND TOTAL</td>
                            <td>
                                <?php
                                    $sub = 0 ;
                                    foreach ($subprice as $key => $value) {
                                      
                                        $sub+= $value;
                                    }
                                    echo "$ ".$sub;
                                 ?>
                            </td>
                        </tr>
            </table>
            <input type="hidden" name="grantotal" value="<?php echo $sub ?>">
            <input type="submit" name="checkout" class="btn btn-success" value="PROCEED TO CHECKOUT" <?php if($sub ==0){echo "disabled='disabled'";} ?>>
                
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">

    function updatecard(id){
        var amount = $("."+id).val();
        var url = "<?php echo site_url(); ?>";
        var id = id;
        $.ajax({
            type:"GET",
            url: url+"page/cardupdate",
            data:{amount:amount,id:id},
            success:function(data){
                if(data == "success"){
                    location. reload();
                }else{
                    $(".false").show();
                }
            }
        })
    }

    function clearcard(id){
       var url = "<?php echo site_url(); ?>";
       var id = id;
        $.ajax({
            type:"GET",
            url: url+"page/clearcard",
            data:{id:id},
            success:function(data){
                console.log(data)
                if(data == "success"){
                    location. reload();
                }else{
                    $(".false").show();
                }
            }
        })
    }
</script>