<?php
/* 
Template Name: Features Archives
*/
get_header();
?>
<div style="max-width:1000px; margin:auto; padding:20px; color:black;  background-image: -webkit-linear-gradient(left, #5875c0 0%,#45cdaf 100%);"><h1>All about community driven development</h1></div>
<div class="single_blog_content">
		
	GAMES FOR GAMERS, NOT SHAREHOLDERS
	<br>
	<br>
	More than just a game developers website. 
	Community Driven Development is part an open, living, design document.
	It’s part development roadmap and account of our development history.
	It’s part funding model (‘cause we already tried living off of hopes and dreams).
	But most of all Community Driven Development is a constant conversation between the developers and the Players about the direction of development!
	This is what makes us unique! We allow players to have a direct hand on the pulse of our games development as well as a direct line with which to influence development!
	<br>
	<br>
	What is CDD
	Although i’d like to think it’s some elaborate innovation in game development it’s actually quite simple. It’s a crowdfunding subscription service through wich in exchange for their support users get direct input into the projects direction! 
	The point is to make the line of communication between players and developers not only beneficial but vital to the development progress and to make us beholden only to the players during the entirety of development and not just at the outset and not to shareholders or publishers.
	<br>
	<br>
	How it works
	As simply as possible! As development continues the developers will post potential features to the site towards which subscribers will spend “Dev-Points” to fund the feature. Each feature has a required number of dev-points which represents the number of hours the feature is expected to require to complete. Users get Dev-Points and a number of other perks every month depending on their subscription level.
	Eventually users will also be encouraged to submit features to be voted on via polls in the forums with developers estimating the amount of development points required to complete.
	Once funded a feature gets added to the development stack and a page is created detailing the feature, logging regular development updates and providing a platform for Users to comment on the progress!
</div>
<div class="single_blog_content">

<ul class="nav nav-pills">
  <li class="active"><a data-toggle="pill" href="#home">Features Awaiting Approval</a></li>
  <li><a data-toggle="pill" href="#menu1">Features History</a></li>
</ul>

<div class="tab-content">
  <div id="home" class="tab-pane fade in active">
    <h3>HOME</h3>
    <p>Some content.</p>
  </div>
  <div id="menu1" class="tab-pane fade">
    <h3>Menu 1</h3>
    <p>Some content in menu 1.</p>
  </div>
</div>

<?php
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
?>
</div>
<?php


get_footer();
?>