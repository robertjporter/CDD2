<?php
/*
Plugin Name: PreAlpha PopUp
Description: It's on the tin
* Version: 0.0
* Author: RJP
* Author URI: www.robertjporter.com
*/

add_action('wp_footer', 'wpshout_action_example'); 
function wpshout_action_example() { ?>
	<script>
		jQuery(window).load(function()
			{
				jQuery('#myModal').modal('show');
			});
	</script>


	<div class="container">
  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" style="margin:auto; text-align:center; color:black;">About Pre-Alpha</button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content" style="color:black;">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Community Driven Development is still in Pre-Alpha!</h4>
        </div>
        <div class="modal-body">
          <p>Please note that this site is still in the testing phase and that all dev-points applied will not contribute towards developing the stated features just yet and some will be not actually be available for approval for some time.</p>
		  <br>
		  <p>For this Pre-Alpha phase everyone will start with 5 proto dev-points and get 5 more per day just for this testing phase which will be removed after the testing phase.</p>
		  <br>
		  <p>Also I want to take a moment to thank you so much for helping me with bug proofing this site. I am enormously grateful for you taking the time to help make the public launch the best it can be.</p>
		  <br>
		  <p>(This pop-up will no longer appear when we go live and dev-points start being counted)</p>
		  <br>
		  <p>Thank you again for joining me on this adventure,</p>
		  <p style="text-align:center;">-The Sleepy Fox-</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>
<?php
}