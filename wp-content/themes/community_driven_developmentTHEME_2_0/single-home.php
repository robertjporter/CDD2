<?php
/*
*Template Name: Home
* Template Post Type: post, page, home
*/

get_header();?>

<!---------------------- START TEST BAR ---------------------->
<?php
$query = new WP_Query(array(
    'post_type' => 'feature',
    'post_status' => 'publish',
	'posts_per_page' => 3,
	'orderby' => 'rand'
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
	<div class="LatestRelease">
		<div class="LatestRelease_imagebox row" style="background-image: url(<?php echo $feat_image;?>);">
			<div class="LatestRelease_whiteback col-sm-5 col-xs-12" >
				<div class="LatestRelease_textbox">
					<h3>LATEST RELEASE</h3>
					It is not known exactly when the text obtained its current standard form; it may have been as late as the 1960s.<br><br>
					<a href="<?php echo get_post_type_archive_link('indev'); ?>"><button type="button" class="RJP-Lightbtn">SEE FULL RELEASE</button></a>
				</div>
			</div>
			<div class="LatestRelease_fadeBuffer col-sm-2 " ></div>
		</div>
	</div>
	<?php
    echo "";
}
wp_reset_query();
?>

<!---------------------- END TEST BAR ---------------------->

<div class="RJP-Lightback">
<?php
	while ( have_posts() ) : the_post(); 
		get_template_part( 'content', 'page' ); 
	endwhile; // end of the loop. 
?>

<br>
</div>
<div class="RJP-Darkback">
<h1>Just funded</h1>
</div>
<div class="RJP-Lightback">
	<h1>Latest completed feature</h1>
	<?php
$query = new WP_Query(array(
    'post_type' => 'indev',
    'post_status' => 'publish',
		'posts_per_page' => 1,
		'orderby' => 'rand',
		'meta_query'     => [
			[
					'key'      => 'completeIndev',
					'compare' => 'EXISTS',
			]
	],
));
?>

  <div class="row">
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
		<div class="" style=" padding:15px;">
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
	</div>
	</a>
<?php
}
wp_reset_query();
//End latest completed feature ?>
</div>
<div class="RJP-Darkback">
<h2 style="text-align:center;">AVAILABLE FEATURES</h2>

<?php
$query = new WP_Query(array(
    'post_type' => 'feature',
    'post_status' => 'publish',
	'posts_per_page' => 3,
	'orderby' => 'rand'
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
    echo "";
}
wp_reset_query();
?>
<a href="<?php echo get_post_type_archive_link('feature'); ?>"><button type="button" class="RJP-Darkbtn">SEE ALL</button></a> 
</div>
<div class="RJP-Lightback">
<h2 style="text-align:center;">INDEV FEATURES</h2>
<br>

<?php
$query = new WP_Query(array(
    'post_type' => 'indev',
    'post_status' => 'publish',
		'posts_per_page' => 3,
		'orderby' => 'rand',
		'meta_query'     => [
			[
					'key'      => 'completeIndev',
					'compare' => 'NOT EXISTS',
					'value'    => '',
			]
	],
));
?>

  <div class="row">
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
}
wp_reset_query();
?>
</div>
  
  
<a href="<?php echo get_post_type_archive_link('indev'); ?>"><button type="button" class="RJP-Lightbtn">SEE ALL</button></a>
</div>
<div class="RJP-Darkback">
<h2 style="text-align:center;">LATEST NEWS!</h2>
<br>

<?php query_posts( array(
   'posts_per_page' => 3,
)); ?>

<?php if( have_posts() ): while ( have_posts() ) : the_post(); ?>
<a href="<?php echo the_permalink();?>">
	<?php the_title(); ?>
   <?php the_excerpt(); ?>
   <?php endwhile; ?>
</a>
<?php else : ?>

   <p><?php __('No News'); ?></p>

<?php endif; ?>

<a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>"><button type="button" class="RJP-Darkbtn">SEE ALL</button></a>
</div>	
<?php //get_sidebar(); ?>
<?php get_footer(); ?>