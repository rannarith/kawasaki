<div class="breadcrumb"></div>
<div class="container">
    <div class="col-lg-9">
        <div class="product-single-container product-single-default">
            <div class="row">
                <?php foreach($accessory->result() as $result)?>
                <div class="col-lg-7 col-md-6 product-single-gallery">
                    <img class="product-single-image" src="<?php echo base_url() . 'assets/images/accessory/' . $result->thumbnail; ?>" data-zoom-image="">
                </div>
                <form action="<?php echo base_url().'page/addtocard/'.$result->acs_id ?>" method="POST" name="form">
                    <div class="col-lg-5 col-md-6">
                        <div class="product-single-details">
                            <h1 class="product-title"><?php echo $result->title; ?></h1>
                            <div class="ratings-container">
                                <div class="price-box">
                                    <span class="old-price">$<?php echo $result->price ?></span>
                                    <input type="hidden" name="price" value="<?php echo $result->price ?>">
                                </div>
                                <div class="description woocommerce-product-details__short-description"><p><?php echo $result->short_des ?></p></div>
                                <div class="product_meta"> <span class="sku_wrapper">SKU: <span class="sku" itemprop="sku">PT0003-2</span></span></div>
                                    <input type="hidden" name="item_code" value="PT0003">
                                <div class="col-md-6 row">
                                    <div class="sizebox">
                                        <select class="form-control" name="size" id="size" required="required">
                         
                                            <option value="s">S</option>
                                            <option value="m">M</option>
                                            <option value="l">L</option>
                                            <option value="xl">XL</option>
                                            <option value="xxl">XXL</option>
                                            <option value="xxxl">XXXL</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 row">
                                    <div class="single_variation_wrap">
                                        <div class="woocommerce-variation-add-to-cart variations_button woocommerce-variation-add-to-cart-disabled">
                                            <div class="quantity buttons_added">
                                                <input type="number" id="quantity_5c171ca58f6f0" class="input-text qty text" step="1" min="1" max="" name="quantity" value="1" title="Qty" size="4" pattern="[0-9]*" inputmode="numeric" aria-labelledby="">
                                            </div> 
                                            <button type="submit" class="single_add_to_cart_button button alt disabled wc-variation-selection-needed"><i class="fas fa-cart-plus"></i> Add to cart</button>
                                            <div class="yith-wcwl-add-to-wishlist add-to-wishlist-1336">
                                                <div class="yith-wcwl-add-button show" style="display:block"> 
                                                    <a href="" rel="nofollow" data-product-id="1336" data-product-type="variable" class="add_to_wishlist"><i class="far fa-heart"></i></a>
                                                    <span class="ajax-loading"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>