<?php
/* 
Template Name: Features Archives
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
		<h1>All Features Current and Past</h1>
	</div>
<?php }?>

<div class="single_blog_content">
	<?php
	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	$args = array(
	'posts_per_page' => 6,
	'post_type' => 'feature',
	'paged' => $paged
	);
	$custom_query = new WP_Query( $args );
	?>
			<!----start-------->
	<main id="main" class="site-main" role="main">
	
	<?php
	while($custom_query->have_posts()) :
		$custom_query->the_post();

		$post_id = get_the_ID();
		$title = get_the_title($post_id);
		$excerpt = get_the_excerpt($post_id);
		$link = get_permalink($post_id);
		$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post_id) );
		$is_history = get_post_meta( $post_id, 'history', true );
		$vote_count = count (get_post_meta($post_id, "supporter_id", false));
		$total = get_post_meta( $post_id, 'dev-point-requirement', true );
			$percentage = ($vote_count*100)/$total;
		//echo '<a href="'.$link.'" >';
		
		?>
		<div class="row featurePreveiw" style="margin:20px;">
		
			<a href="<?php echo $link;?>">
			<div class="col-sm-5 col-xs-12 indexFeatureBase" style="height:220px; ">
				<?php if($is_history === "Y") { ?>
					<div class="history">Funded</div>
				<?php }; ?>
				<h3>
					<?php echo $title;?>
				</h3> 
				<?php echo $excerpt;?>
			</div>
			
			<div class="col-sm-2 hidden-xs" style="height:220px; color: black; background: linear-gradient(to right, rgba(255,255,255,1), rgba(255,255,255,0));">
				
			</div>
			
			<div class="col-sm-push-5 " style="height:220px; background-image: url(<?php echo $feat_image;?>); background-position: left center; background-size: cover;">
			
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
			echo "";

		endwhile; ?>
		<?php if (function_exists("pagination")) {
			pagination($custom_query->max_num_pages);
		} ?>
	</main><!-- #main -->
</div>
<?php


get_footer();
?>