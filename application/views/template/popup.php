
<script>
jQuery(function(){
   jQuery('.btn-modal').click();
});
</script>


<!-- Large modal -->
<button class="btn btn-primary btn-modal" data-toggle="modal" data-target=".bd-example-modal-lg" style="display: none;">Large modal</button>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <center><img src="<?php echo base_url(); ?>assets/images/popup.jpg" class="img-responsive" alt="hgb" /></center>
    </div>
  </div>
</div>