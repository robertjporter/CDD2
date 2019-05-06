<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package _tk
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header>
		<div class="entry-content-thumbnail" style="max-width:1000px; margin:auto; height: 400px; background-image: url(<?php echo get_the_post_thumbnail_url(); ?>);  background-position: center; background-size: cover;"">
		</div>
	</header><!-- .entry-header -->
	<div class="single_blog_content">
		<div>
			<h1 class="page-title"><?php the_title(); ?></h1>
			<?php the_category( ', ' ); ?>
			<?php the_content(); ?>
			<?php _tk_link_pages(); ?>
		</div><!-- .entry-content -->
	</div>
	<?php //edit_post_link( __( 'Edit', '_tk' ), '<footer class="entry-meta"><span class="edit-link">', '</span></footer>' ); ?>
</article><!-- #post-## -->
