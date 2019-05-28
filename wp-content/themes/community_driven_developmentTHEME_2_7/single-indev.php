<?php 
/*
*Template Name: Indev
* Template Post Type: post, page, indev
*/
get_header();
	?>
	<div style=" max-width:1000px; margin:auto; padding:20px; color:black;  background-image: -webkit-linear-gradient(left, #6a9d6e 0%,#a9cc41 100%);"><h1>Currently in development</h1></div> <?php
	while ( have_posts() ) : the_post(); 
		get_template_part( 'content', 'page' ); 
	endwhile; // end of the loop. 

	$objectives = get_post_meta($post->ID,'objectives',false);
	$objectives_count = count($objectives[0]);
	$objectives_complete = 0;
	$parentFeature = get_post_meta($post->ID,'parentFeature',false);
	$parent_thumbnail_img = get_the_post_thumbnail( $parentFeature[0], 'thumbnail' );
	$feat_image = wp_get_attachment_url( get_post_thumbnail_id($parentFeature[0]) );
	?>
	<div class="single_blog_content">
		
	<!--
		<div class="progress">
			<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php //echo $objectives_percentage;?>"
			aria-valuemin="0" aria-valuemax="100" style="width:<?php //echo $objectives_percentage;?>%">
			<span class="sr-only"></span>
			<?php //echo "<span>" . $objectives_percentage . "% complete" . "</span>";?>
			</div>
		</div>
-->

		<?php
		echo "OBJECTIVES";
		if(is_array($objectives[0])){
				foreach( $objectives[0] as $complete ) {
			echo "<br>";
			if ($complete[complete] == 0 ){
				echo " <span data-toggle='tooltip' title='In queue' style='font-size: 20px; color:#006cff' class='glyphicon glyphicon-time'></span> ";
			} else if ($complete[complete] == 1) {
				echo " <span data-toggle='tooltip' title='In Progress' style='font-size: 20px; color:#ffc81b' class='glyphicon glyphicon-wrench'></span> ";
			} else if ($complete[complete] == 2) {
				echo " <span data-toggle='tooltip' title='Complete' style='font-size: 20px; color:#39b34a' class='glyphicon glyphicon-ok'></span> ";
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
		

		<?php
			if($parentFeature[0]){
				echo "<br><h1>Feature Page</h1>";
		//		echo "<a href='".get_permalink($parentFeature[0])."'>" . get_the_title($parentFeature[0])."<br>";
		//		echo $parent_thumbnail_img;
		//		echo "</a>";
		//	}
			
		?>
			<div class="row featurePreveiw" style="margin:20px; overflow: hidden; border-style: solid;">
				<a href="<?php echo get_permalink($parentFeature[0]);?>">
				<div class="col-sm-5 col-xs-12 indexFeatureBase" style="height:220px; ">
					<h3>
						<?php echo get_the_title($parentFeature[0]);?>
					</h3> 
					<?php echo get_the_excerpt($parentFeature[0]);?>
				</div>
				
				<div class="col-sm-2 hidden-xs" style="height:220px; color: black; background: linear-gradient(to right, rgba(255,255,255,1), rgba(255,255,255,0));">
					
				</div>
				
				<div class="col-sm-push-5 " style="height:220px; background-image: url(<?php echo $feat_image;?>); background-position: left center; ">
					
				</div>
				</a>
			</div>
		<?php
			}
		//Comments
		
			// If comments are open or we have at least one comment, load up the comment template
			if ( comments_open() || '0' != get_comments_number() )
				comments_template();
		
		

	//get_sidebar(); ?>
	</div>
</div>
<?php get_footer(); ?>
