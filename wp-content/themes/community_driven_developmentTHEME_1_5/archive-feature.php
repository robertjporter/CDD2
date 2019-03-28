<?php
get_header();
if(have_posts()) : while(have_posts()) : the_post();

    $post_id = get_the_ID();
	$title = get_the_title($post_id);
	$excerpt = get_the_excerpt($post_id);
	$link = get_permalink($post_id);
	$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post_id) );
	$isHistory = get_post_meta( $post_id, 'history', true );
	$vote_count = count (get_post_meta($post_id, "supporter_id", false));
	$total = get_post_meta( $post_id, 'dev-point-requirement', true );
		$percentage = ($vote_count*100)/$total;
	//echo '<a href="'.$link.'" >';
	?>
	<div class="row featurePreveiw" style="margin:20px;">
		
		<a href="<?php echo $link;?>">
		<div class="col-sm-5 col-xs-12 indexFeatureBase" style="height:220px; ">
		<?php if($isHistory === 'Y'){
			echo "<div class='history'>HISTORY</div>";
		} else {
			
		}
		?>
			<h3>
				<?php echo $title;?>
			</h3> 
			<?php echo $excerpt;?>
		</div>
		
		<div class="col-sm-2 hidden-xs" style="height:220px; color: black; background: linear-gradient(to right, rgba(255,255,255,1), rgba(255,255,255,0));">
			
		</div>
		
		<div class="col-sm-push-5 " style="height:220px; background-image: url(<?php echo $feat_image;?>); background-position: left center; ">
			
		</div>
		
		<div class="progress">
		  <div class="progress-bar<?php 
			if($percentage <=50){echo "-info";}
			else if($percentage <= 70){echo "-warning";}
			else if($percentage >= 100){echo "-success";}
			else {echo "-danger";} ?> " 
		  role="progressbar" 
		  style="text-align: center; width: <?php echo $percentage;?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" >
			<?php echo floor($percentage);?>%
		  </div>
		</div>
		</a>
	</div>
<?php
	
	
endwhile; endif;


get_sidebar();
get_footer();
?>