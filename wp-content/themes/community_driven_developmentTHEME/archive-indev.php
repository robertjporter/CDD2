<?php
get_header();
if(have_posts()) : while(have_posts()) : the_post();


    $post_id = get_the_ID();
	$title = get_the_title($post_id);
	$excerpt = get_the_excerpt($post_id);
	$link = get_permalink($post_id);
	$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post_id) );
	$objectives = get_post_meta($post->ID,'objectives',false);
	$objectives_count = count($objectives[0]);
	$objectives_complete = 0;
	
	?>
	<a href="<?php echo $link; ?>">
	<div class="col-sm-4 " style=" padding:15px;">
	<div class="" style=" position:relative; height:320px;  background-image: url(<?php echo $feat_image;?>); background-position: center; background-size: cover;"><?php
		
		//echo $excerpt;
		?>
		<div class="indev_info" style="color:rgba(255,255,255,1); background-color:rgba(0,0,0,0.75); width:100%; height:100%; position:absolute; top:0px; padding:10px; overflow: hidden;">
			<?php
			echo "<h4>".$title."</h4>";
			if(is_array($objectives[0])){
				foreach( $objectives[0] as $complete ) {
					
					if ($complete[complete] == 0 ){
						echo " <span style='color:#006cff' class='glyphicon glyphicon-time'></span> ";
					} else if ($complete[complete] == 1) {
						echo " <span style='color:#ffc81b' class='glyphicon glyphicon-wrench'></span> ";
					} else if ($complete[complete] == 2) {
						echo " <span style='color:#39b34a' class='glyphicon glyphicon-ok'></span> ";
						$objectives_complete = $objectives_complete + 1;
					} else {
						echo " <span style='color:red' class='glyphicon glyphicon-alert'></span>";
					}
					echo $complete[title];
					echo "<br>";
				}
			}
			$objectives_percentage = floor(($objectives_complete*100)/$objectives_count);
			?>
			
		</div>
		<div style="position:absolute; bottom:-20px; width: 100%;">
			<div class="progress">
				<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $objectives_percentage;?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $objectives_percentage;?>%">
					<span class="sr-only"></span>
				</div>
			</div>
		</div>
	</div>
	</div>
	</a>
<?php
	
	
endwhile; endif;


get_sidebar();
get_footer();
?>