<?php 
/*
*Template Name: Indev
* Template Post Type: post, page, indev
*/

get_header();
	while ( have_posts() ) : the_post(); 
		get_template_part( 'content', 'page' ); 
	endwhile; // end of the loop. 

$objectives = get_post_meta($post->ID,'objectives',false);
$objectives_count = count($objectives[0]);
$objectives_complete = 0;
$parentFeature = get_post_meta($post->ID,'parentFeature',false);

	
	if($parentFeature[0]){
		echo "<b>Feature Page</b><br>";
		echo "<a href='".get_permalink($parentFeature[0])."'>".get_the_title($parentFeature[0])."</a>";
	}
	
	echo "<br><br>OBJECTIVES";
	if(is_array($objectives[0])){
        foreach( $objectives[0] as $complete ) {
			echo "<br>";
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
        }
    }
	
	$objectives_percentage = floor(($objectives_complete*100)/$objectives_count);

$updates = get_post_meta($post->ID,'updates',false);
if($updates[0]){
	$updates_count = count($updates[0]);
	echo "<br><br><br>";
	echo "UPDATES LOG";
	if(is_array($updates[0])){
        foreach( $updates[0] as $complete ) {
			echo "<br>" . $complete[date] . "<br>" . $complete[title] . "<br>";
        }
    }
	
	echo "<br>";
}

	?>
	<h1>Progress</h1>
	<div class="progress">
	  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $objectives_percentage;?>"
	  aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $objectives_percentage;?>%">
		<span class="sr-only"></span>
		<?php echo "<span>" . $objectives_percentage . "% complete" . "</span>";?>
	  </div>
	</div>
	<?php
	//Comments
	
		// If comments are open or we have at least one comment, load up the comment template
		if ( comments_open() || '0' != get_comments_number() )
			comments_template();
	
	

get_sidebar(); ?>

<?php get_footer(); ?>
