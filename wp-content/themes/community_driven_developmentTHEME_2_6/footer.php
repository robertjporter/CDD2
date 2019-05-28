<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package _tk
 */
?>
			</div><!-- close .*-inner (main-content or sidebar, depending if sidebar is used) -->
		</div><!-- close .row -->
	</div><!-- close .container -->
</div><!-- close .main-content -->

<footer id="colophon" class="site-footer" role="contentinfo">
<?php // substitute the class "container-fluid" below if you want a wider content area ?>
	<div class="container">
		<div class="row">
			<div class="site-footer-inner col-sm-12" style="max-width:1000px;">

				<div class="site-info">
					<?php 
						if( get_theme_mod( 'footer_youtube_link' )){
							$YT_link = get_theme_mod( 'footer_youtube_link' );
							$YT_icon = get_template_directory_uri().'\includes\resources\icons\YT.png';
							echo "<a href='".$YT_link."' data-toggle='tooltip' title='YouTube'><img class='footer-icon' width='60px' height='60px' alt='Facebook' src='".$YT_icon."'></a>";
						}
						if( get_theme_mod( 'footer_facebook_link' )){
							$FB_link = get_theme_mod( 'footer_facebook_link' );
							$FB_icon = get_template_directory_uri().'\includes\resources\icons\FB.png';
							echo "<a href='".$FB_link."' data-toggle='tooltip' title='Facebook'><img class='footer-icon' width='60px' height='60px' alt='Facebook' src='".$FB_icon."'></a>";
						}
						if( get_theme_mod( 'footer_twitter_link' )){
							$TW_link = get_theme_mod( 'footer_twitter_link' );
							$TW_icon = get_template_directory_uri().'\includes\resources\icons\TW.png';
							echo "<a href='".$TW_link."' data-toggle='tooltip' title='Twitter'><img class='footer-icon' width='60px' height='60px' alt='Facebook' src='".$TW_icon."'></a>";
						}
						if( get_theme_mod( 'footer_discord_link' )){
							$DC_link = get_theme_mod( 'footer_discord_link' );
							$DC_icon = get_template_directory_uri().'\includes\resources\icons\DC.png';
							echo "<a href='".$DC_link."' data-toggle='tooltip' title='Discord'><img class='footer-icon' width='60px' height='60px' alt='Facebook' src='".$DC_icon."'></a>";
						}
						if( get_theme_mod( 'footer_instagram_link' )){
							$IN_link = get_theme_mod( 'footer_instagram_link' );
							$IN_icon = get_template_directory_uri().'\includes\resources\icons\IN.png';
							echo "<a href='".$IN_link."' data-toggle='tooltip' title='Instagram'><img class='footer-icon' width='60px' height='60px' alt='Facebook' src='".$IN_icon."'></a>";
						}
					?>
				</div><!-- close .site-info -->

			</div>
		</div>
	</div><!-- close .container -->
</footer><!-- close #colophon -->

<?php wp_footer(); ?>

</body>
</html>