<!--        footer-->
<div class="menu-footer">
    
    <div class="hold-footer" >
        <div class="container">
            <div class="row">

                <div class="col-lg-5 col-md-5 col-sm-5">
                    <p class="copyright">COPYRIGHT (C) <?php echo date("Y"); ?> KAWASAKI MOTORS CAMBODIA. ALL RIGHTS RESERVED.</p>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-7 text-right">
                    <div class="pull-right " style="">
                        <span style=" float: left; margin-right: 20px;" >Follow Us</span>
                        <a href="https://www.facebook.com/kawasakimotorsKH" target="_new">
                            <img src="<?php echo base_url(); ?>assets/images/icon/facebook.png" class="img-responsive" alt="facebook" style="margin-top: 5px; height: 15px; float: left; margin-right: 20px;" />
                        </a>
                        <a href="https://www.instagram.com/kawasakimotorskh/" target="_new">
                            <img src="<?php echo base_url(); ?>assets/images/icon/instagram.png" class="img-responsive" alt="twitter" style="margin-top: 5px; height: 15px; float: left; margin-right: 20px;" />
                        </a>
                        <a href="https://www.youtube.com/channel/UCRbsFbJleFr0wiJ1MAEvyCw" target="_new">
                            <img src="<?php echo base_url(); ?>assets/images/icon/youtube.png" class="img-responsive" alt="youtube" style="margin-top: 5px; height: 15px; float: left; margin-right: 20px;" />
                        </a>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>



<div id="stop" class="scrollTop">
    <span><a href=""><img src="<?php echo base_url().'assets/images/btn-top.png'; ?>" /></a></span>
  </div>

<!--        aos scroll js 
-->
<script src="<?php echo base_url(); ?>assets/scroll/aos.js"></script>

<script>
    AOS.init({
        easing: 'ease-in-out-sine'
    });
</script>




<script>
    $(function () {
        window.prettyPrint && prettyPrint()
        $(document).on('click', '.yamm .dropdown-menu', function (e) {
            e.stopPropagation()
        })
    })
</script>
<!-- tweet and share :)-->
<script>!function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (!d.getElementById(id)) {
            js = d.createElement(s);
            js.id = id;
            js.src = "https://platform.twitter.com/widgets.js";
            fjs.parentNode.insertBefore(js, fjs);
        }
    }(document, "script", "twitter-wjs");</script>
<!--        End Sub Menu-->
<!--        slideshow homepage-->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jssor.slider.mini.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/home-slide.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/performance.js"></script>
<!--        end slideshow home page-->
<script type="text/javascript"  src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript"  src="<?php echo base_url(); ?>assets/js/custom.js"></script>
<script type="text/javascript"  src="<?php echo base_url(); ?>assets/js/main.js"></script>


</body>
</html>