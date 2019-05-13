<?php
/* 
Template Name: Indev Archives
*/
get_header();
?>
<div style="max-width:1000px; margin:auto; padding:20px; color:black;  background-image: -webkit-linear-gradient(left, #5875c0 0%,#45cdaf 100%);">
	<h1>
		<?php
			if ( have_posts() ) the_post();
			the_title();
		?>
	</h1>
</div>

<?php if( $paged === 0 ) { ?>
	<div class="single_blog_content">
		
			<p>
				<?php
					the_content();
				?>
			</p>
		
	</div>

	<div style="max-width:1000px; margin:auto; padding:20px; color:black;  background-image: -webkit-linear-gradient(left, #5875c0 0%,#45cdaf 100%);">
		<h1>All Indevelopment Logs</h1>
	</div>
<?php }?>

<div class="single_blog_content" style="">
		<?php
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		$args = array(
		'posts_per_page' => 6,
		'post_type' => 'indev',
		'paged' => $paged
		);
		$custom_query = new WP_Query( $args );
		?>
		
		<?php
		while($custom_query->have_posts()) :
			$custom_query->the_post();
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
					<div class="indev_container" style=" position:relative; height:320px; background-image: url(<?php echo $feat_image;?>); background-position: center; background-size: cover;"><?php
					
					//echo $excerpt;
					?>
					<div class="indev_info">
						<?php
						echo "<br><div class='indev_title'><h4>".$title."</h4></div>";
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
					<div style="position:absolute; top:0px; width: 100%;">
						<div class="progress">
							<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $objectives_percentage;?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $objectives_percentage;?>%">
								<span class="sr-only"></span>
							</div>
						</div>
					</div>
					</div>
				</div>
			</a>
		<?php endwhile; ?>
	
	<?php if (function_exists("pagination")) {
			pagination($custom_query->max_num_pages);
		} ?>
	<div style="width:100%; height:10px; display:inline-block"></div>
</div>
<?php


get_footer();
?>