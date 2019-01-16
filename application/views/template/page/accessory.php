<!--   banner  #7e7e7e   -->
<div style="background: #F6F6F6; color: #7e7e7e;">
    <img class="img-responsive" width="100%" src="<?php echo base_url(); ?>assets/images/accessory/1.jpg"  />
    <div class="clear"></div>
    <div class="container">  
        <div class="row">

            <div class="clear"></div><br/>
            <h2 class="content_title" >Accessories & <span class="kawa_txt_color"> Apparel</span></h2>
            <div class="clear"></div><br/>

            <?php include_once("menu_accessory.php"); ?>

            <?php
            $i = 0;
            foreach ($accessory->result() as $row) {
                $i++;
                ?>
                
            <div class="col-md-3">
                <div class="product-item">
                    <div class="pi-img-wrapper">
                        <a href="<?php echo base_url().'page/accessory_detail/'.$row->acs_id; ?>">
                            <img src="<?php echo base_url() . 'assets/images/accessory/' . $row->thumbnail; ?>" class="img-responsive" alt="<?php echo $row->title; ?>">
                        </a>
                    </div>
                    <h3><a href="<?php echo base_url().'page/accessory_detail/'.$row->acs_id; ?>"><?php echo $row->title; ?></a></h3>
                    <div class="pi-price">Price : $<?php echo $row->price; ?></div>
                    <div class="clear"></div>
                    <?php echo $row->short_des; ?>
                    <?php 
                    if($row->is_new == 1){
                        echo '<div class="sticker sticker-new"></div>';
                    }
                    ?>
                </div>
            </div>

                <?php
                if (($i % 4) == 0) {
                    echo '<div class="clear"></div>';
                }
            }
            ?>
            <div class="clear"></div><br/>
            <center><?php echo $links_accessory; ?></center>
            <div class="clear"></div><br/><br/>
        </div>
    </div>

    <!-- new style -->


</div>

<style>
    .mySlides {
        margin-bottom: -6px;
    }
</style>
<!-- Modal 1   -->

<script>
    function openModal() {
        document.getElementById('myModal').style.display = "block";
    }

    function closeModal() {
        document.getElementById('myModal').style.display = "none";
    }

    var slideIndex = 1;
    showDivs(slideIndex);

    function plusDivs(n) {
        showDivs(slideIndex += n);
    }

    function currentDiv(n) {
        showDivs(slideIndex = n);
    }

    function showDivs(n) {
        var i;
        var x = document.getElementsByClassName("mySlides");
        var dots = document.getElementsByClassName("demo");
        var captionText = document.getElementById("caption");
        if (n > x.length) {
            slideIndex = 1
        }
        if (n < 1) {
            slideIndex = x.length
        }
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }


        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" w3-opacity-off", "");
        }
        x[slideIndex - 1].style.display = "block";
        dots[slideIndex - 1].className += " w3-opacity-off";
        captionText.innerHTML = dots[slideIndex - 1].innerHTML;

        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace("w3-opacity-off", "");
        }
        var captionText = document.getElementById("caption");
        if (n > x.length) {
            slideIndex = 1;
        }
        if (n < 1) {
            slideIndex = x.length;
        }
    }

</script>