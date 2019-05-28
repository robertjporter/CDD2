<?php 
/*
*Template Name: release
* Template Post Type: post, page, product, Concept, Development, release
*/

get_header();
?>
<div style=" max-width:1000px; margin:auto; padding:20px; color:black;  background-image: -webkit-linear-gradient(left, #cf4f47 0%,#9d814c 100%);"><h1>Latest Release</h1></div> <?php
	while ( have_posts() ) : the_post(); 
		get_template_part( 'content', 'page' ); 
	endwhile; // end of the loop. 
?><div class="single_blog_content">
	<h1 style="text-align:center;">The Indevelopment Logs For This Release</h1>
	<?php
	//Get feature array-------------
	$indev_feature = get_post_meta($post->ID,'indev_feature',false);

	if(is_array($indev_feature[0])){
		?><div class="row" style=" max-width:850px; margin:auto;"><?php
		foreach( $indev_feature[0] as $complete ) {
			//echo $complete['title'];

			$post_id = url_to_postid($complete['title']);
			$title = get_the_title($post_id);
			$excerpt = get_the_excerpt($post_id);
			$link = get_permalink($post_id);
			$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post_id) );
			$objectives = get_post_meta($post_id,'objectives',false);
			$objectives_count = count($objectives[0]);
			$objectives_complete = 0;
		
			?>
			<a href="<?php echo $link; ?>">
			<div class="col-sm-4 " style=" padding:15px;">
				<div class="indev_container" style=" position:relative; height:320px; background-image: url(<?php echo $feat_image;?>); background-position: center; background-size: cover;"><?php
			
				//echo $excerpt;
				?>
				<div class="indev_info">
					<?php
					echo "<div class='indev_title'><h4>".$title."</h4></div>";
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
			</div>
		</div><?php
		}
	}
	//Comments
			
	
?> 
	</div> 
<?php
// If comments are open or we have at least one comment, load up the comment template
if ( comments_open() || '0' != get_comments_number() )
comments_template();

?> 
</div> 
<?php

get_footer(); ?>