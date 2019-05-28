<?php
/*
*Template Name: Home
* Template Post Type: post, page, home
*/

get_header();
?><div style="margin:auto; background-color:black; max-width:1000px;
margin:auto;">
<?php the_custom_header_markup(); ?>
</div>

<div class="RJP-Darkback">
	<div class="row" style="max-width: 1000px; margin:auto;">
		
		<div class="col-sm-6 col-xs-12" style="max-width: 500px; margin:auto; padding: 40px; text-align: center">
			<?php
				echo get_post_field('post_content', $post_id);
			?>
		</div>

		<div class="col-sm-6 col-xs-12" style="padding:40px 0;">
				<?php 
					$getYoutubeHomeLink = get_theme_mod( 'home_youtube_link' );
					$YoutubeHomeLink =  str_replace('watch?v=', 'embed/',$getYoutubeHomeLink);
				?>
				<iframe src="<?php echo $YoutubeHomeLink; ?>" width="640" height="280" frameborder="0"></iframe>
		</div>
	</div>

<!---------------------- START RELEASE ---------------------->
<?php
$query = new WP_Query(array(
	'post_type' => 'release',
	'post_status' => 'publish',
	'posts_per_page' => 1,
	'orderby' => 'date',
	'order'   => 'DESC'
));

while ($query->have_posts()) {
  $query->the_post();
  $post_id = get_the_ID();
	$title = get_the_title($post_id);
	$excerpt = get_the_excerpt($post_id);
	$link = get_permalink($post_id);
	$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post_id) );
	//echo '<a href="'.$link.'" >';
	
	?>
	<div class="LatestRelease">
		<div class="LatestRelease_imagebox row" style="background-image: url(<?php echo $feat_image;?>);">
			<div class="LatestRelease_whiteback col-sm-5 col-xs-12" >
				<div class="LatestRelease_textbox">
					<h3 style="padding:10px 0px; text-align:center; color:black; text-align:center;  background-image: -webkit-linear-gradient(left, #9d814c 0%,#cf4f47 100%);"><?php echo $title; ?></h3>
					<?php echo $excerpt; ?><br><br>
					<a href="<?php echo $link; ?>"><button type="button" class="RJP-Lightbtn"><b>ABOUT THE RELEASE</b></button></a>
				</div>
			</div>
			<div class="LatestRelease_fadeBuffer col-sm-2 " ></div>
		</div>
	</div>
	<?php
    //echo "";
}
wp_reset_query();
?>
</div>
<!---------------------- END RELEASE ---------------------->

<!---------------------- START INDEV ---------------------->
<div class="RJP-Lightback">
<br>
<div class="features_container">
	<h2 style="padding:10px 0px; text-align:center; color:black; text-align:center;  background-image: -webkit-linear-gradient(left, #6a9d6e 0%,#a9cc41 100%);">CURRENTLY IN DEVELOPMENT</h2>
	<br>
	<p>Follow the development process with day by day updates to core features. Open and transparent</p>
</div>
<br>

<?php
$query = new WP_Query(array(
	'post_type' => 'indev',
	'post_status' => 'publish',
	'posts_per_page' => 6,
	'orderby' => 'DESC',
	'meta_query'     => [
		[
				'key'      => 'completeIndev',
				'compare' => 'NOT EXISTS',
				'value'    => '',
		]
	],
));
?>

  <div class="row" style=" max-width:850px; margin:auto;">
<?php
while ($query->have_posts()) {
    $query->the_post();
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
<?php
}
wp_reset_query();
?>
</div>

<a href="<?php 
	$pages = get_pages(array(
		'meta_key' => '_wp_page_template',
		'meta_value' => 'archive-indev.php'
	));
	foreach($pages as $page){
		$indev_archive_link = get_page_link($page->ID);
	};
	if($indev_archive_link){
		echo $indev_archive_link;
	} else {
		echo get_post_type_archive_link('indev');
	}
?>"><button type="button" class="RJP-Darkbtn">ALL ABOUT SPRITE SHARDS</button></a> 
<br>
<br>
<!---------------------- END INDEV ---------------------->
<!---------------------- START FEATURES ---------------------->
<div class="RJP-Darkback">
	<div class="features_container">
		<h2 style="padding:10px 0px; color:black; text-align:center;  background-image: -webkit-linear-gradient(left, #5875c0 0%,#45cdaf 100%);">FEATURES AWAITING YOUR APPROVAL</h2>
		<br>
		<p>
		More than just a game developers website. 
		Community Driven Development is part an open, living, design document.
		It’s part development roadmap and account of our development history.
		It’s part funding model (‘cause we already tried living off of hopes and dreams).
		But most of all Community Driven Development is a constant conversation between the developers and the Players about the direction of development!
		This is what makes us unique! We allow players to have a direct hand on the pulse of our games development as well as a direct line with which to influence development!
		</p>
		<?php
		$query = new WP_Query(array(
				'post_type' => 'feature',
				'post_status' => 'publish',
			'posts_per_page' => 6,
			'orderby' => 'DESC'
		));

		while ($query->have_posts()) {
				$query->the_post();
				$post_id = get_the_ID();
			$title = get_the_title($post_id);
			$excerpt = get_the_excerpt($post_id);
			$link = get_permalink($post_id);
			$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post_id) );
			
			$vote_count = count (get_post_meta($post_id, "supporter_id", false));
			$total = get_post_meta( $post_id, 'dev-point-requirement', true );
				$percentage = ($vote_count*100)/$total;
			//echo '<a href="'.$link.'" >';
			
			?>
			<div class="row featurePreveiw" style="margin:20px;">
				<a href="<?php echo $link;?>">
				<div class="col-sm-5 col-xs-12 indexFeatureBase" style="height:220px; ">
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
		}
		wp_reset_query();
		?>
		
		<a href="<?php 
			$pages = get_pages(array(
				'meta_key' => '_wp_page_template',
				'meta_value' => 'archive-feature.php'
			));
			foreach($pages as $page){
				$feature_archive_link = get_page_link($page->ID);
			};
			if($feature_archive_link){
				echo $feature_archive_link;
			} else {
				echo get_post_type_archive_link('feature');
			}
		?>"><button type="button" class="RJP-Darkbtn">ALL ABOUT CDD</button></a> 
		</div>
		<?php
		?>
</div>
<!---------------------- END FEATURES ---------------------->


<!---------------------- START NEWZ ---------------------->

</div>
<div class="RJP-Lightback">
	<div class="news_container">
		<h2 style="text-align:center;">LATEST NEWS</h2>
		<br>

		<?php query_posts( array(
			'posts_per_page' => 3,
		)); ?>

		<?php if( have_posts() ): while ( have_posts() ) : the_post(); ?>
		<a href="<?php echo the_permalink();?>">
			<h4><?php the_title(); ?></h4>
			<?php the_date(); the_excerpt(); ?>
			<br>
			<?php endwhile; ?>
		</a>
		
		<?php else : ?>

			<p><?php __('No News'); ?></p>

		<?php endif; ?>

		<a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>"><button type="button" class="RJP-Darkbtn">SEE ALL NEWS</button></a>
		</div>	
</div>	
<?php //get_sidebar(); ?>
<?php get_footer(); ?>