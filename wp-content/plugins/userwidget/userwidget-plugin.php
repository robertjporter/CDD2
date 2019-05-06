<?php
/*
Plugin Name: User Widget
Description: Widget for displaying user info
*/
/* Start Adding Functions Below this Line */
  
  // Register and load the widget
function wpb_load_widget() {
    register_widget( 'wpb_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );
 
// Creating the widget 
class wpb_widget extends WP_Widget {
 
	function __construct() {
	parent::__construct(
	 
	// Base ID of your widget
	'user_widget', 
	 
	// Widget name will appear in UI
	__('User Widget', 'RJP'), 
	 
	// Widget description
	array( 'description' => __( 'Widget for displaying user info', 'RJP' ), ) 
	);
	}
	 
	// Creating widget front-end
	public function widget( $args, $instance ) {
		if (is_user_logged_in() && !wp_is_mobile()) {
			$user_ID = get_current_user_id();
			$user_dev_points = get_user_meta($user_ID, 'user_points', true);
			$current_user = wp_get_current_user();
			$blogtime = current_time( 'mysql' ); 
			
			?> 
				<?php get_search_form(); ?> 
				<div class="row" style="margin-bottom:20px;">
					<div class="col-sm-4">
						<img src="<?php echo esc_url( get_avatar_url( $user_ID ) ); ?>" height="80" width="80"/>
					</div>
					<div class="col-sm-8">
						<?php
						echo $current_user->display_name . '<br />';
						echo 'DevPts.  ' . $user_dev_points . '<br />';
						echo '<a href="' , site_url() , '/wp-admin/profile.php" target="_blank">User settings</a>';
						?>
					</div>
				</div>
				
				
				
				<?php
				$args = array(
					'posts_per_page' => -1,
					'post_type'  => 'feature',
					'meta_query' => array(
						array(
							'key'   => 'supporter_id',
							'value' => '1',
						)
					)
				);
				$featurelist = get_posts( $args );
				
				foreach($featurelist as $feature) {
					$post_id = $feature->ID;
					$title = get_the_title($post_id);
					$excerpt = get_the_excerpt($post_id);
					$link = get_permalink($post_id);
					$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post_id) );
					
					$vote_count = count (get_post_meta($post_id, "supporter_id", false));
					$total = get_post_meta( $post_id, 'dev-point-requirement', true );
					$percentage = ($vote_count*100)/$total;
					?>
				
					
					<div class="featurePreveiw" >
					<a href="<?php echo $link;?>">
					
					<div style=" background-image: url(<?php echo $feat_image;?>); background-position: left center; ">
						<div style="padding: 5px; background-color: rgba(255,255,255,.25)">
							<h3>
								<?php echo $title;?>
							</h3> 
							<?php echo $excerpt;?>
						</div>
					</div>
					
					<div class="progress">
					  <div class="progress-bar<?php 
						if($percentage <=70){echo "-info";}
						else if($percentage <= 99){echo "-warning";}
						else if($percentage >= 100){echo "-success";}
						else {echo "-danger";} ?> " 
					  role="progressbar" 
					  style="text-align: center; width: <?php echo $percentage;?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
						<?php echo floor($percentage);?>%
					  </div>
					</div>
					</a>
					</div>
				<?php }
		}//END is_user_logged_in
		else {
			echo "Get involved";
			?><a href="#"> <?php get_search_form(); ?> </a><?php
		}
	}//END widget function
} // Class wpb_widget ends here

/* Stop Adding Functions Below this Line */
?>






