<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package _tk
 */

get_header(); ?>
<div class="single_blog_content">
	<?php if ( have_posts() ) : ?>

		<header>
			<h2 class="page-title"><?php printf( __( 'Search Results for: %s', '_tk' ), '<span>' . get_search_query() . '</span>' ); ?></h2>
		</header><!-- .page-header -->

		<?php // start the loop. ?>
		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'search' ); ?>

		<?php endwhile; ?>

		<?php _tk_pagination(); ?>

	<?php else : ?>

		<?php get_template_part( 'no-results', 'search' ); ?>

	<?php endif; // end of loop. ?>
	


</div>	
<?php //get_sidebar(); ?>
<?php get_footer(); ?>