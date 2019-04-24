<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package _tk
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title><?php wp_title( '|', true, 'right' ); ?></title>

	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>  >
	<?php do_action( 'before' ); ?>

<header id="masthead" class="site-header" role="banner">
<?php // substitute the class "container-fluid" below if you want a wider content area ?>

</header><!-- #masthead -->



<!-- My Navbar -->
<nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <!-- The WordPress Menu goes here -->
		<?php wp_nav_menu(
			array(
				'theme_location' 	=> 'primary',
				'depth'             => 2,
				'container'         => 'nav',
				'container_id'      => 'navbar-collapse',
				'container_class'   => 'nav navbar-nav',
				'menu_class' 		=> 'nav navbar-nav',
				'fallback_cb' 		=> 'wp_bootstrap_navwalker::fallback',
				'menu_id'			=> 'main-menu',
				'walker' 			=> new wp_bootstrap_navwalker()
			)
		); ?>
      <ul class="nav navbar-nav navbar-right">
		
		<?php if ( is_user_logged_in() ) { 
			$current_user = wp_get_current_user();?>
			
			<li><a href="<?php echo wp_logout_url( $redirect ); ?>"><span class="glyphicon glyphicon-log-in"></span> Log Out</a></li>
		<?php } else { ?>
			<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>/wp-login.php?action=register"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
			<li><a href="<?php echo wp_login_url( get_permalink() ); ?>" title="Login"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
			
			
		<?php } ?>
      </ul>
    </div>
  </div>
</nav>


<div class="main-content">
<?php // substitute the class "container-fluid" below if you want a wider content area ?>
	<div class="container-fluid">
		<div class="row">
			<div id="content" class="main-content-inner">

