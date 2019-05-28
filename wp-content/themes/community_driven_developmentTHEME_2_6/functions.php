<?php
/**
 * _tk functions and definitions
 *
 * @package _tk
 */
 
 /**
  * Store the theme's directory path and uri in constants
  */
 define('THEME_DIR_PATH', get_template_directory());
 define('THEME_DIR_URI', get_template_directory_uri());

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 750; /* pixels */

if ( ! function_exists( '_tk_setup' ) ) :
/**
 * Set up theme defaults and register support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function _tk_setup() {
	global $cap, $content_width;

	// Add html5 behavior for some theme elements
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

    // This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	/**
	 * Add default posts and comments RSS feed links to head
	*/
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails on posts and pages
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	*/
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1000, 400 );

	/**
	 * Enable support for Post Formats
	*/
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	/**
	 * Setup the WordPress core custom background feature.
	*/
	add_theme_support( 'custom-background', apply_filters( '_tk_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
		) ) );
	
	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on _tk, use a find and replace
	 * to change '_tk' to the name of your theme in all the template files
	*/
	load_theme_textdomain( '_tk', THEME_DIR_PATH . '/languages' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	*/
	register_nav_menus( array(
		'primary'  => __( 'Header bottom menu', '_tk' ),
		) );

}
endif; // _tk_setup
add_action( 'after_setup_theme', '_tk_setup' );

//INCLUDES
require_once( __DIR__ . '/includes/featureCustomPostType.php');
require_once( __DIR__ . '/includes/indevCustomPostType.php');
require_once( __DIR__ . '/includes/releaseCustomPostType.php');

//CUSTOMISER OPTIONS
function CDD_customize_register( $wp_customize ) {
	
	$wp_customize->add_setting( 'home_youtube_link' , array(
		'default'   => '',
		'transport' => 'refresh'
	) );
	$wp_customize->add_control(
		'home_youtube_link', 
		array(
			'label'    => __( 'Home Page Youtube Link', 'CDD' ),
			'section'  => 'static_front_page',
			'settings' => 'home_youtube_link',
			'type'     => 'text'
		)
	);

	$wp_customize->add_setting( 'footer_facebook_link' , array(
		'default'   => '',
		'transport' => 'refresh'
	) );
	$wp_customize->add_control(
		'footer_facebook_link', 
		array(
			'label'    => __( 'Footer Facebook page link', 'CDD' ),
			'section'  => 'title_tagline',
			'settings' => 'footer_facebook_link',
			'type'     => 'text'
		)
	);

	$wp_customize->add_setting( 'footer_youtube_link' , array(
		'default'   => '',
		'transport' => 'refresh'
	) );
	$wp_customize->add_control(
		'footer_youtube_link', 
		array(
			'label'    => __( 'Footer Youtube channel link', 'CDD' ),
			'section'  => 'title_tagline',
			'settings' => 'footer_youtube_link',
			'type'     => 'text'
		)
	);

	$wp_customize->add_setting( 'footer_twitter_link' , array(
		'default'   => '',
		'transport' => 'refresh'
	) );
	$wp_customize->add_control(
		'footer_twitter_link', 
		array(
			'label'    => __( 'Footer Twitter link', 'CDD' ),
			'section'  => 'title_tagline',
			'settings' => 'footer_twitter_link',
			'type'     => 'text'
		)
	);

	$wp_customize->add_setting( 'footer_discord_link' , array(
		'default'   => '',
		'transport' => 'refresh'
	) );
	$wp_customize->add_control(
		'footer_discord_link', 
		array(
			'label'    => __( 'Footer Discord channel link', 'CDD' ),
			'section'  => 'title_tagline',
			'settings' => 'footer_discord_link',
			'type'     => 'text'
		)
	);

	$wp_customize->add_setting( 'footer_instagram_link' , array(
		'default'   => '',
		'transport' => 'refresh'
	) );
	$wp_customize->add_control(
		'footer_instagram_link', 
		array(
			'label'    => __( 'Footer instagram channel link', 'CDD' ),
			'section'  => 'title_tagline',
			'settings' => 'footer_instagram_link',
			'type'     => 'text'
		)
	);
 }
 add_action( 'customize_register', 'CDD_customize_register' );

//Video header
function prefix_custom_header_setup() {
    add_theme_support( 'custom-header', array(
        'video' => true
    ) );
}
add_action( 'after_setup_theme', 'prefix_custom_header_setup' );

add_filter( 'is_header_video_active', 'custom_video_header_pages' );

function custom_video_header_pages( $active ) {
  if( is_home() || is_page() ) {
    return true;
  }

  return false;
}

/**
 * Register widgetized area and update sidebar with default widgets
 */
function _tk_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', '_tk' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
		) );
}
add_action( 'widgets_init', '_tk_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function _tk_scripts() {

	// Import the necessary TK Bootstrap WP CSS additions
	wp_enqueue_style( '_tk-bootstrap-wp', THEME_DIR_URI . '/includes/css/bootstrap-wp.css' );

	// load bootstrap css
	wp_enqueue_style( '_tk-bootstrap', THEME_DIR_URI . '/includes/resources/bootstrap/css/bootstrap.min.css' );

	// load Font Awesome css
	wp_enqueue_style( '_tk-font-awesome', THEME_DIR_URI . '/includes/css/font-awesome.min.css', false, '4.1.0' );

	// load _tk styles
	wp_enqueue_style( '_tk-style', get_stylesheet_uri() );

	// load bootstrap js
	wp_enqueue_script('_tk-bootstrapjs', THEME_DIR_URI . '/includes/resources/bootstrap/js/bootstrap.min.js', array('jquery') );

	// load bootstrap wp js
	wp_enqueue_script( '_tk-bootstrapwp', THEME_DIR_URI . '/includes/js/bootstrap-wp.js', array('jquery') );

	wp_enqueue_script( '_tk-skip-link-focus-fix', THEME_DIR_URI . '/includes/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( '_tk-keyboard-image-navigation', THEME_DIR_URI . '/includes/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}

}
add_action( 'wp_enqueue_scripts', '_tk_scripts' );

/**
 * Implement the Custom Header feature.
 */
require THEME_DIR_PATH . '/includes/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require THEME_DIR_PATH . '/includes/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require THEME_DIR_PATH . '/includes/extras.php';

/**
 * Customizer additions.
 */
require THEME_DIR_PATH . '/includes/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require THEME_DIR_PATH . '/includes/jetpack.php';

/**
 * Load custom WordPress nav walker.
 */
require THEME_DIR_PATH . '/includes/bootstrap-wp-navwalker.php';

/**
 * Adds WooCommerce support
 */
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
	add_theme_support( 'woocommerce' );
}
//THUMBNAIL SUPPORT
//add_theme_support('post-thumbnails');

add_image_size('featured_preview', 55, 55, true);
add_image_size('featured_link_img', 256, 256, true);

/* CUSTOM LOGIN STYLE */
function my_custom_login()
{
echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('stylesheet_directory') . '/login/custom-login-style.css" />';
}
add_action('login_head', 'my_custom_login');



/* POINTS FUNCTIOALITY*/
    //Save points extra registration user meta.
    add_action( 'user_register', 'myplugin_user_register' );
    function myplugin_user_register( $user_id ) {
        update_user_meta( $user_id, 'user_points', 5 );
    }
	
	//Add points to admin pannel
	function theme_add_user_points_column( $columns ) {
		$columns['user_points'] = __( 'Dev Points', 'theme' );
		return $columns;
	}
	add_filter( 'manage_users_columns', 'theme_add_user_points_column' );
	
	//Show user points data
	function theme_show_user_points_data( $value, $column_name, $user_id ) {
		if( 'user_points' == $column_name ) {
			return get_user_meta( $user_id, 'user_points', true );
		}
	}
	add_action( 'manage_users_custom_column', 'theme_show_user_points_data', 10, 3 );

	
	//MINE
	wp_enqueue_script('jquery');
	//Add points
	function dev_vote_add(){
		$post_id = $_POST['post_id'];
		$user_id = $_POST['user_id'];
		$user_dev_points = get_user_meta($user_id, 'user_points', true);
		$vote_count = count (get_post_meta($post_id, "supporter_id", false));
		$raw_user_support = array_count_values(get_post_meta($post_id, "supporter_id", false));
		$user_support = $raw_user_support[$user_id];
		$press_count = $_POST['press_count'];
		$dev_point_requirement = get_post_meta( $post_id, 'dev-point-requirement', true );
		$is_history = get_post_meta( $post_id, 'history', true );
		
		if($is_history === 'N'){
			if($dev_point_requirement-1 <= $vote_count){
				add_post_meta($post_id, "supporter_id", $user_id);
				update_user_meta( $user_id, "user_points", $user_dev_points-1);
				update_post_meta( $post_id, "history", "Y");
				die();
			} elseif ($dev_point_requirement > $vote_count){
				add_post_meta($post_id, "supporter_id", $user_id);
				update_user_meta( $user_id, "user_points", $user_dev_points-1);
				die();
			} else {
				die();
			}
		} else {
			die();
		}
	}
	add_action('wp_ajax_dev-vote-add', 'dev_vote_add');
	add_action('wp_ajax_nopriv_dev-vote-add', 'dev_vote_add');
	
	//remove point
	function dev_vote_remove(){
		$post_id = $_POST['post_id'];
		$user_id = $_POST['user_id'];
		$user_dev_points = get_user_meta($user_id, 'user_points', true);
		$vote_count = count (get_post_meta($post_id, "supporter_id", false));
		$raw_user_support = array_count_values(get_post_meta($post_id, "supporter_id", false));
		$user_support = $raw_user_support[$user_id];
		
		delete_post_meta($post_id, "supporter_id", $user_id);
		update_user_meta( $user_id, "user_points", $user_dev_points+$user_support);
		die();
	}
	add_action('wp_ajax_dev-vote-remove', 'dev_vote_remove');
	add_action('wp_ajax_nopriv_dev-remove', 'dev_vote_remove');


//EXCERPT FUNTIONALITY--------------------------------------------------------------
function wpdocs_custom_excerpt_length( $length ) {
    return 30;
}
add_filter( 'excerpt_length', 'wpdocs_custom_excerpt_length', 999 );

//HIDE WP-ADMIN BAR FOR SUBS--------------------------------------------------------------
add_filter( 'show_admin_bar' , 'handle_admin_bar');

function handle_admin_bar($content) {
     // 'manage_options' is a capability assigned only to administrators
     // here, the check for the admin dashboard is not necessary
     if (!current_user_can('manage_options')) {
         return false;
     }
}

//LOGIN REDIRECT--------------------------------------------------------------
function admin_default_page() {
	return get_home_url();
  }
  
  add_filter('login_redirect', 'admin_default_page');
//REGISTRATION FIX--------------------------------------------------------------
function RJP_new_item_register_form() {

	$password1 = ( ! empty( $_POST['password1'] ) ) ? trim( $_POST['password1'] ) : '';
	$password2 = ( ! empty( $_POST['password2'] ) ) ? trim( $_POST['password2'] ) : '';
	?>
	<p>
		<label for="password1"><?php _e( 'Password:') ?>
		<input type="password" name="password1" id="password1" class="input" value="<?php echo esc_attr( wp_unslash( $password1 ) ); ?>" size="25" /></label><br>
		<label for="password2"><?php _e( 'Confirm Password:') ?>
		<input type="password" name="password2" id="password2" class="input" value="<?php echo esc_attr( wp_unslash( $password2 ) ); ?>" size="25" /></label><br>
	</p>
	<?php

}
add_action('register_form', 'RJP_new_item_register_form');
//---

function RJP_register_form_errors( $errors, $sanitized_user_login, $user_email ) {
	if ( empty( $_POST['password1'] ) || ! empty( $_POST['password1'] ) && trim( $_POST['password1'] ) == '' ) {
		$errors->add( 'password1_error', __( '<strong>ERROR</strong>: Password field is required.' ) );
	}
	if ( empty( $_POST['password2'] ) || ! empty( $_POST['password2'] ) && trim( $_POST['password2'] ) == '' ) {
		$errors->add( 'password2_error', __( '<strong>ERROR</strong>: Confirm Password field is required.' ) );
	}
	if ( $_POST['password1'] != $_POST['password2'] ) {
		$errors->add( 'password12_error', __( '<strong>ERROR</strong>: Password field and Confirm Password field do not match.' ) );
	}
	
    return $errors;
}
add_filter( 'registration_errors', 'RJP_register_form_errors', 10, 3 );
//----

function RJP_auto_login_new_user_after_registration( $user_id ) {
	
		wp_set_password( $_POST['password1'], $user_id ); //Password previously checked in add_filter > registration_errors
	

        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id);

		$redirect = "";

		if ($redirect == "") {
			global $_POST;
			if ($_POST['redirect_to'] == "") {
				$redirect = get_home_url();			
			} else {
				$redirect = $_POST['redirect_to'];
			}
		}

		wp_redirect($redirect);

		wp_new_user_notification($user_id, null, 'both'); //'admin' or blank sends admin notification email only. Anything else will send admin email and user email

		exit;
}
add_action( 'user_register', 'RJP_auto_login_new_user_after_registration' );

//Skip logout confermation screen and set destination
add_action('check_admin_referer', 'logout_without_confirm', 10, 2);
function logout_without_confirm($action, $result)
{
    /**
     * Allow logout without confirmation
     */
    if ($action == "log-out" && !isset($_GET['_wpnonce'])) {
        $redirect_to = isset($_REQUEST['redirect_to']) ? $_REQUEST['redirect_to'] : site_url();
        $location = str_replace('&amp;', '&', wp_logout_url($redirect_to));
        header("Location: $location");
        die;
    }
}

//PAGEINATION--------------------------------------------------------------
function pagination($pages = '', $range = 4)
{
    $showitems = ($range * 2)+1;
 
    global $paged;
    if(empty($paged)) $paged = 1;
 
    if($pages == '')
    {
        global $wp_query;
        $pages = $wp_query->max_num_pages;
        if(!$pages)
        {
            $pages = 1;
        }
    }
 
    if(1 != $pages)
    {
        echo "<div class=\"pagination\"><span>Page ".$paged." of ".$pages." </span>";
        if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo; First</a>";
        if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo; Previous</a>";
 
        for ($i=1; $i <= $pages; $i++)
        {
            if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
            {
                echo ($paged == $i)? " <span class=\"btn btn-primary current\">".$i."</span> ":" <a href='".get_pagenum_link($i)."' class=\"btn btn-default inactive\">".$i."</a> ";
            }
        }
 
        if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">Next &rsaquo;</a>";
        if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>Last &raquo;</a>";
        echo "</div>\n";
    }
}