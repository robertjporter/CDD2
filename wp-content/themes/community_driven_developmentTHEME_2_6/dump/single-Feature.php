<?php 
/*
*Template Name: Concept
* Template Post Type: post, page, product, Concept, Development
*/

get_header();
	
	while ( have_posts() ) : the_post(); 
		get_template_part( 'content', 'page' ); 
	endwhile; // end of the loop. 
	
	

//Show Parent-------------
$post_id = get_the_ID();
$parent_id = get_post_meta($post_id, "dev-Parent", true);
$parent = get_post($parent_id);
$parent_thumb_id = get_post_thumbnail_id($parent_id);
$parent_thumbnail_img = wp_get_attachment_image_src($parent_thumb_id, 'featured_link_img');
$parent_stage = get_post_meta($post_id, "dev-Stage", true);

//Show Parent-------------
if (get_the_title() !== $parent -> post_title){
	echo "<a href='".$parent->guid."'>".$parent->post_title."<br><img src='" . $parent_thumbnail_img[0] . "' /></a>";
}

function get_parent_excess ($post_id,$parent_id){
	$parent_dev_point_requirement = get_post_meta($parent_id,'dev-point-requirement',true);
	$parent_vote_count = count (get_post_meta($parent_id, "supporter_id", false));
	echo "<br>parent_dev_point_requirement= ";
	echo $parent_dev_point_requirement ;
	echo "<br>parent_vote_count= ";
	echo $parent_vote_count ;
	if ($parent_vote_count > $parent_dev_point_requirement){
		$parent_vote_difference = $parent_vote_count - $parent_dev_point_requirement;
		 echo "<br>parent_vote_difference= ";
		echo $parent_vote_difference ;
	} else {echo "<br>not enough parent votes ";}
}

get_parent_excess($post_id,$parent_id);
//DEV VOTING SYSTEM-------------------

	$user_ID = get_current_user_id();
	$user_dev_points = get_user_meta($user_ID, 'user_points', true);
	$post_id = get_the_ID();
	$vote_count = count (get_post_meta($post_id, "supporter_id", false));
	$raw_user_support = array_count_values(get_post_meta($post_id, "supporter_id", false));
	$user_support = $raw_user_support[$user_ID];
	
	//Just fxing a bug (blank user support wreaks buttons data passing over to AJAX)
	if (empty($user_support)) {
		$user_support=0;
	}
		//Convert to a percentage for progress bar
		$total = get_post_meta( $post_id, 'dev-point-requirement', true );
		$percentage = ($vote_count*100)/$total;
		
		
	?>
	
	<div class="progress">
	  <div class="progress-bar<?php 
		if($percentage <=70){echo "-info";}
		else if($percentage <= 99){echo "-warning";}
		else if($percentage >= 100){echo "-success";}
		else {echo "-danger";} ?> " 
	  role="progressbar" 
	  style="width: <?php echo $percentage;?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
		<?php echo floor($percentage);?>%
	  </div>
	</div>
	
	<br>Feature has <span class='vote_count'><?php echo $vote_count;?></span> Dev-points and needs <?php echo get_post_meta( $post_id, 'dev-point-requirement', true );?> to start development.<br>
	<?php
	if($user_ID){?>
		You are user <?php echo $user_ID; ?> and you have <span class='user_dev_points'><?php echo $user_dev_points; ?></span> Dev-points. <span class='user_support'><?php echo $user_support; ?></span> of this posts points were added by you.
		
		<button id="dev-vote-add-one" type='button' 
		class='dev-vote btn btn-success <?php if ($user_support > 0){echo ' hidden';}?>'
		data-post_id=<?php echo $post_id; ?> 
		data-user_id=<?php echo $user_ID; ?> 
		data-user_dev_points=<?php echo $user_dev_points; ?> 
		data-vote_count=<?php echo $vote_count; ?>
		data-user_support=<?php echo $user_support; ?>
		data-press_type="add">
			Add One of Your Dev-Points!
		</button>
		
		<button id="dev-vote-add-another" type='button' 
		class='dev-vote btn btn-info <?php if ($user_support < 1){echo ' hidden';}
		if ($user_dev_points < 1){echo ' hidden';}?>'
		data-post_id=<?php echo $post_id; ?> 
		data-user_id=<?php echo $user_ID; ?> 
		data-user_dev_points=<?php echo $user_dev_points; ?> 
		data-vote_count=<?php echo $vote_count; ?>
		data-user_support=<?php echo $user_support; ?>
		data-press_type="add">
			Add Another Dev-Point.
		</button>
		
		<button id="dev-vote-remove" type='button' 
		class='dev-vote btn btn-danger <?php if ($user_support < 1){echo ' hidden';}
		if ($user_support < 1){echo ' hidden';}?>'
		data-post_id=<?php echo $post_id; ?> 
		data-user_id=<?php echo $user_ID; ?> 
		data-user_dev_points=<?php echo $user_dev_points; ?> 
		data-vote_count=<?php echo $vote_count; ?>
		data-user_support=<?php echo $user_support; ?>
		data-press_type="remove">
			Take Back All Dev-Points.
		</button>
		
		<br><br><button id="test_button" type='button' class='dev-vote btn btn-warning'>
			Get Dev Points
		</button>
		
		
		
	<?php 
	//Comments
	
		// If comments are open or we have at least one comment, load up the comment template
		if ( comments_open() || '0' != get_comments_number() )
			comments_template();
	
	
	} else { ?>
		"Please Login or Signup to vote."
	<?php } ?>

	<script type="text/javascript">
	
		press_count = 0;
		
		post_id = 0;
		user_id = 0;
		user_dev_points = 0;
		vote_count = 0;
		
		jQuery(".dev-vote").click(function(){
			heart = jQuery(this);
			
			test_data = "hey you!";
			
			post_id = heart.data("post_id");
			user_id = heart.data("user_id");
			user_dev_points = heart.data("user_dev_points");
			vote_count = heart.data("vote_count");
			user_support = heart.data("user_support");
			press_type = heart.data("press_type");
			
			console.log("--NEW PRESS--");
			console.log("post_id: "+post_id);
			console.log("user_id: "+user_id);
			console.log("user_dev_points: "+user_dev_points);
			console.log("vote_count: "+vote_count);
			console.log("user_support: "+user_support);
			console.log("press_type: "+press_type);
			
			console.log("press_counto: "+press_type);
			press_count++;
			console.log("PRESS COUNT "+press_count);
			console.log("press_count updated to: "+press_type);
			
			
			
			if (press_type == "add"){
				if (user_dev_points > 0){
					console.log("User has dev points");
					jQuery.ajax({
						type:"POST",
						url: "<?php echo admin_url('admin-ajax.php'); ?>",
						data: "action=dev-vote-add&post_id="+post_id+"&user_id="+user_id+"&user_dev_points="+user_dev_points+"&vote_count="+vote_count+"&press_type="+press_type+"&press_count="+press_count,
						success:function(data){
							console.log("ajax send-off to add successful");
							console.log("press_count "+press_count);
							//update status bar
							jQuery('.vote_count').text(vote_count+press_count);
							jQuery('.user_dev_points').text(user_dev_points-press_count);
							jQuery('.user_support').text(user_support+press_count);
							
							console.log("press_count after edit"+press_count);
							console.log("HELLO "+(user_dev_points-press_count));
							//switch hide class if needed
							if ((user_dev_points-press_count) == 1){
								jQuery( "#dev-vote-add-one" ).addClass( "hidden" );
								jQuery( "#dev-vote-add-another" ).addClass( "hidden" );
							}
							
							jQuery( "#dev-vote-add-one" ).addClass( "hidden" );
							jQuery( "#dev-vote-add-another" ).removeClass( "hidden" );
							jQuery( "#dev-vote-remove" ).removeClass( "hidden" );
							
							console.log("add_post_meta post_id:"+post_id+" key:suporter_id meta:"+user_id);
							console.log("update_user_meta user_id:"+user_id+" key:user_points meta:"+(user_dev_points-press_count));
						},
						error: function(data){
							console.log("ajax send-off to add FAILED");
							press_count--;
						}
					});
				} else {
					console.log("WARNNING: User does NOT have dev points");
					jQuery( "#dev-vote-add-one" ).addClass( "hidden" );
					jQuery( "#dev-vote-add-another" ).addClass( "hidden" );
				}
			} else if (press_type == "remove"){
				press_count--;
				jQuery.ajax({
					type:"POST",
					url: "<?php echo admin_url('admin-ajax.php'); ?>",
					data: "action=dev-vote-remove&post_id="+post_id+"&user_id="+user_id+"&user_dev_points="+user_dev_points+"&vote_count="+vote_count+"&press_type="+press_type+"&press_count="+press_count,
					success:function(data){
						console.log("ajax send-off to remove sucess");
						console.log("press_count "+press_count);
						
						//update status bar
						jQuery('.vote_count').text(vote_count-user_support);
						jQuery('.user_dev_points').text(user_dev_points+user_support);
						jQuery('.user_support').text(0);
						//step up press_count
						press_count = 1;
						console.log("press_count after edit "+press_count);
						//reset button hide classes
						jQuery( "#dev-vote-add-one" ).removeClass( "hidden" );
						jQuery( "#dev-vote-add-another" ).addClass( "hidden" );
						jQuery( "#dev-vote-remove" ).addClass( "hidden" );
						console.log("delete_post_meta post_id:"+post_id+" key:suporter_id meta:"+user_id);
						console.log("update_user_meta user_id:"+user_id+" key:user_points meta:"+(user_dev_points+user_support));
					}
				});
			} else {
				//ERROR!
				console.log("Error: Button press invalid");
			}
			
		})
	</script>
<?php get_sidebar(); ?>
<?php get_footer(); ?>




















