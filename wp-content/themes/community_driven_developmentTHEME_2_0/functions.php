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
        update_user_meta( $user_id, 'user_points', 0 );
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
		
		
		if($dev_point_requirement < $raw_user_support){
			add_post_meta($post_id, "supporter_id", $user_id);
			update_user_meta( $user_id, "user_points", $user_dev_points-1);
			die();
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
	

//_______ _______ _______ _______ _     _  ______ _______       _____   _____  _______ _______     _______ __   __  _____  _______
//|______ |______ |_____|    |    |     | |_____/ |______      |_____] |     | |______    |    ___    |      \_/   |_____] |______
//|       |______ |     |    |    |_____| |    \_ |______      |       |_____| ______|    |           |       |    |       |______
																											  
add_action( 'init', 'create_my_post_types' );

function create_my_post_types() {
	register_post_type( 'feature', 
		array(
			'labels' => array(
				'name' => __( 'Features' ),
				'singular_name' => __( 'Feature' )
			),
			'public' => true,
			'menu_position' => 26,
			'hierarchical' => false,
			'has_archive' => true,
			'supports' => array(
				'title', 
				'editor', 
				'excerpt', 
				'custom-fields', 
				'thumbnail',
				'page-attributes',
				'comments',
				'revisions'),
			'taxonomies' => array( 'category', 'post_tag'),
		)
	);
}

//CUSTOM METABOXES
// Add the Meta Box
function add_custom_meta_box() {
    add_meta_box(
        'custom_meta_box', // $id
        'Feature Info', // $title 
        'show_custom_meta_box', // $callback
        'feature', // $page
        'normal', // $context
        'high'); // $priority
}
add_action('add_meta_boxes', 'add_custom_meta_box');

// Field Array
$prefix = 'dev-';

$custom_meta_fields = array(
    array(
        'label'=> 'Dev Points Required',
        'desc'  => 'How many Dev-points dose this feature need to start development? (anything more than 500 should be broken up into smaller parts)',
        'id'    => $prefix.'point-requirement',
        'type'  => 'point-requirement'
    ),
    
    array(
        'label'=> 'Stage',
        'desc'  => 'What stage of development is this feature for?',
        'id'    => $prefix.'Stage',
        'type'  => 'Stage',
		'capability_type' => 'post',
        'options' => array (
            'one' => array (
                'label' => 'Concepting',
                'value' => 'concepting'
            ),
            'two' => array (
                'label' => 'In-Development',
                'value' => 'indev'
            ),
            'three' => array (
                'label' => 'Polish and Feedback',
                'value' => 'polish'
            )
        )
    ),
	
	array(
        'label'=> 'Parent',
        'desc'  => 'What was the previous feature in this development chain (SET CATAGORY FIRST)',
        'id'    => $prefix.'Parent',
        'type'  => 'Parent',
		'capability_type' => 'post',
        'options' => array ($parents
        )
    )
);

// The Callback
function show_custom_meta_box() {
global $custom_meta_fields, $post;
// Use nonce for verification
echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
     
    // Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($custom_meta_fields as $field) {
        // get value of this field if it exists for this post
        $meta = get_post_meta($post->ID, $field['id'], true);
        // begin a table row with
        echo '<tr>
                <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
                <td>';
                switch($field['type']) {
                    // point-requirement
					case 'point-requirement':
						echo '<input type="number" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'"/>
							<br /><span class="description">'.$field['desc'].'</span>';
					break;
					
					
					// Stage
					case 'Stage':
						echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
						foreach ($field['options'] as $option) {
							echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
						}
						echo '</select><br /><span class="description">'.$field['desc'].'</span>';
					break;
					
					// Parent
					case 'Parent':
						$post_id = get_the_ID();
						
						$post_cats = get_the_category($post_id);
						
						$category = single_term_title("", false);
						$catid = get_cat_ID( $category );
						$parents = get_posts(
							array(
								'post_type'   => 'feature', 
								'category' => $catid, 
								'orderby' => 'date', 
								'order'       => 'ASC', 
								'numberposts' => -1 
							)
						);
						
						
						
						echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
						echo '<option'; 
						if (empty($meta)){
							echo  ' selected="selected"';
						}
						echo ' value=""></option>';
						foreach ($post_cats as $post_cat){
							$cat_id = $post_cat->cat_ID;
							$args = array( 'post_type'   => 'feature', 'posts_per_page' => 5, 'category' => $cat_id );
							$myposts = get_posts( $args );
						
							foreach ($myposts as $mypost){
								echo '<option', $meta == $mypost->ID ? ' selected="selected"' : '', ' value="'.$mypost->ID.'">'.$mypost->post_title.'</option>';
							}
						}
						echo '<option value=""></option>';
						echo '</select><br /><span class="description">'.$field['desc'].'</span>';
					break;
					
                } //end switch
        echo '</td></tr>';
    } // end foreach
    echo '</table>'; // end table
}

// Save the Data
function save_custom_meta($post_id) {
    global $custom_meta_fields;
     
    // verify nonce
    if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__))) 
        return $post_id;
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
    }
     
    // loop through fields and save the data
    foreach ($custom_meta_fields as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];
        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    } // end foreach
}
add_action('save_post', 'save_custom_meta');


//FEATURES CUSTOM COLUMNS------
// GET FEATURED IMAGE
function ST4_get_featured_image($post_ID) {
    $post_thumbnail_id = get_post_thumbnail_id($post_ID);
    if ($post_thumbnail_id) {
        $post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, 'featured_preview');
        return $post_thumbnail_img[0];
    }
}

// ADD NEW COLUMN
function ST4_columns_head($defaults) {
	$defaults['dev_stage'] = 'Stage of Development';
	$defaults['dev_parent'] = 'Parent';
    $defaults['featured_image'] = 'Featured Image';
	$defaults['dev_points'] = 'Dev-Points';
	$defaults['dev_points_req'] = 'Dev-Points Required';
	$defaults['dev_points_percent'] = 'Percent';
    return $defaults;
}
 
// SHOW THE FEATURED IMAGE
function ST4_columns_content($column_name, $post_ID) {
	$vote_count = count (get_post_meta($post_ID, "supporter_id", false));
	$dev_points_req = get_post_meta( $post_ID, 'dev-point-requirement', true );
	$percentage = "";
	if ($dev_points_req){
			$percentage = ($vote_count*100)/$dev_points_req;
		} else { 
			$percentage = "Dev point requirement not set.";
		};
	$stage = (get_post_meta($post_ID, "dev-Stage", true));
	$parent_id = (get_post_meta($post_ID, "dev-Parent", true));
	$parent_title = get_the_title($parent_id);
	
	switch ( $column_name ) {
		case 'dev_parent' :
			echo $parent_title;
		break;
		
		case 'featured_image' :
			$post_featured_image = ST4_get_featured_image($post_ID);
			if ($post_featured_image) {
				echo '<img src="' . $post_featured_image . '" />';
				//echo 'All feature images need updating!';
			} else {
				echo 'No image set';
			}
		break;

		case 'dev_points' :
			echo $vote_count;
		break;
		
		case 'dev_points_req' :
			echo $dev_points_req;
		break;
		
		case 'dev_points_percent' :
			echo $percentage . "%";
		break;
		
		case 'dev_stage' :
			echo $stage;
		break;
    }
}

add_filter('manage_feature_posts_columns', 'ST4_columns_head');
add_action('manage_feature_posts_custom_column', 'ST4_columns_content', 10, 2);

//COLUMN WIDTH FIX
add_action('admin_head', 'my_admin_column_width');
function my_admin_column_width() {
    echo '<style type="text/css">
        .column-dev_points { text-align: left; width:70px !important; overflow:hidden }
        .column-dev_points_req { text-align: left; width:70px !important; overflow:hidden }
		.column-featured_image { text-align: left; width:100px !important; overflow:hidden }
    </style>';
}

//ADD HIDDEN POST-META
add_action('wp_insert_post', 'add_history_metabox');
function add_history_metabox($post_id)
{
    if ( $_POST['post_type'] == 'feature' ) {
        add_post_meta($post_id, 'history', 'N', true);
    }
    return true;
}

//_____ __   _ ______  _______ _    _       _____   _____  _______ _______     _______ __   __  _____  _______
//	|   | \  | |     \ |______  \  /       |_____] |     | |______    |    ___    |      \_/   |_____] |______
//__|__ |  \_| |_____/ |______   \/        |       |_____| ______|    |           |       |    |       |______
																										  
add_action( 'init', 'create_indev_post_type' );

function create_indev_post_type() {
	register_post_type( 'indev', 
		array(
			'labels' => array(
				'name' => __( 'Indev' ),
				'singular_name' => __( 'indev' )
			),
			'public' => true,
			'has_archive' => true,
			'menu_position' => 27,
			'hierarchical' => false,
			'supports' => array(
				'title', 
				'editor', 
				'excerpt', 
				'custom-fields', 
				'thumbnail',
				'page-attributes',
				'comments',
				'revisions'),
			'taxonomies' => array( 'category', 'post_tag'),
		)
	);
}

//OBJECTIVE CUSTOM  METABOXES-------------------------
add_action( 'add_meta_boxes', 'dynamic_add_objectives_custom_box' );

/* Do something with the data entered */
add_action( 'save_post', 'dynamic_save_postdata' );

/* Adds a box to the main column on the Post and Page edit screens */
function dynamic_add_objectives_custom_box() {
    add_meta_box(
        'dynamic_sectionid',
        __( 'Objectives', 'myplugin_textdomain' ),
        'dynamic_inner_custom_box',
        'indev');
}

/* Prints the box content */
function dynamic_inner_custom_box() {
    global $post;
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'dynamicMeta_noncename' );
    ?>
    <div id="meta_inner">
    <?php

    //get the saved meta as an array
    $objectives = get_post_meta($post->ID,'objectives',false);

    $c = 0;
    if(is_array($objectives[0])){
        foreach( $objectives[0] as $complete ) {
            if ( isset( $complete['title'] ) || isset( $complete['complete'] ) ) {
                printf( '<p> Objective Description <input type="text" size="35" name="objectives[%1$s][title]" value="%2$s" />Not started<input type="range" min="0" max="2" name="objectives[%1$s][complete]" value="%3$s" />Complete <button  class="remove">%4$s</button></p><hr>', $c, $complete['title'], $complete['complete'], __( 'Remove' ) );
                $c = $c +1;
            }
        }
    }

    ?>
<span id="here"></span>
<button class="add"><?php _e('Add Objective'); ?></button>
<script>
    var $ =jQuery.noConflict();
    $(document).ready(function() {
        var count = <?php echo $c; ?>;
        $(".add").click(function() {
            count = count + 1;

            $('#here').append('<p> Objective Description <input type="text" size="35" name="objectives['+count+'][title]" value="" />Not started<input type="range" min="0" max="2" name="objectives['+count+'][complete]" value="0" />Complete <button  class="remove">Remove</button></p><hr>' );
            return false;
        });
        $(".remove").live('click', function() {
            $(this).parent().remove();
        });
    });
    </script>
</div><?php

}

//UPDATES CUSTOM  METABOXES-------------------------
add_action( 'add_meta_boxes', 'dynamic_add_updates_custom_box' );

/* Do something with the data entered */
add_action( 'save_post', 'dynamic_save_updates_postdata' );

/* Adds a box to the main column on the Post and Page edit screens */
function dynamic_add_updates_custom_box() {
    add_meta_box(
        'dynamic_update_sectionid',
        __( 'Updates', 'myplugin_textdomain' ),
        'dynamic_update_inner_custom_box',
        'indev');
}

/* Prints the box content */
function dynamic_update_inner_custom_box() {
    global $post;
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'dynamicUpdateMeta_noncename' );
    ?>
    <div id="meta_inner">
    <?php

    //get the saved meta as an array
    $updates = get_post_meta($post->ID,'updates',false);

    $cu = 0;
    if(is_array($updates[0])){
        foreach( $updates[0] as $date ) {
            if ( isset( $date['title'] ) || isset( $date['date'] ) ) {
                printf( '<p> Date<input type="date" name="updates[%1$s][date]" value="%3$s" /><button  class="removeUpdate">%4$s</button></p><p><textarea rows="2" cols="60" name="updates[%1$s][title]">%2$s</textarea></p><hr>', $cu, $date['title'], $date['date'], __( 'RemoveUpdate' ) );
                $cu = $cu +1;
            }
        }
    }

    ?>
<span id="hereUpdate"></span>
<button class="addUpdate"><?php _e('Add Update'); ?></button>
<script>
    var $ =jQuery.noConflict();
    $(document).ready(function() {
        var count = <?php echo $cu; ?>;
        $(".addUpdate").click(function() {
            count = count + 1;

            $('#hereUpdate').append('<p> Date <input type="date" name="updates['+count+'][date]" value="<?php echo date('Y-m-d') ?>"/> <button  class="removeUpdate">Remove Update</button></p><p><textarea rows="2" cols="60" name="updates['+count+'][title]" value="" /> </p><hr>' );
            return false;
			
        });
        $(".removeUpdate").live('click', function() {
            $(this).parent().remove();
        });
    });
    </script>
</div><?php

}

//PARENT CUSTOM METABOX-------------------------
add_action( 'add_meta_boxes', 'add_parentFeature_custom_box' );

/* Do something with the data entered */
add_action( 'save_post', 'dynamic_save_parentFeature_postdata' );

/* Adds a box to the main column on the Post and Page edit screens */
function add_parentFeature_custom_box() {
    add_meta_box(
        'parentFeature_sectionid',
        __( 'Parent Feature', 'myplugin_textdomain' ),
        'parentFeature_custom_box',
        'indev');
}

/* Prints the box content */
function parentFeature_custom_box() {
    global $post;
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'dynamicUpdateMeta_noncename' );
    ?>
    <div id="meta_inner">
    <?php

    //get the saved meta as an array
    $parentFeature = get_post_meta($post->ID,'parentFeature',false);
	
	$items = get_posts(
			array(
				'post_type'   => 'feature',
				'meta_key'   => 'history',
				'meta_value'   => 'N',
				'orderby' => 'date', 
				'order'       => 'ASC', 
				'numberposts' => -1 
			)
		);
		
	if ($parentFeature[0]){
		echo "Parent set to: <b>".get_the_title($parentFeature[0])."</b>";?>
		<select name="parentFeature" id="parentFeature"> 
				<?php   
				echo '<option value="'.$parentFeature.'"',$meta == $parentFeature ? ' selected="selected"' : '','>'.get_the_title($parentFeature[0]).'</option>'; 
				
				foreach($items as $item) {
					echo '<option value="'.$item->ID.'"',$meta == $item->ID ? ' selected="selected"' : '','>'.$item->post_title.'</option>'; 
				} // end foreach ?> 
		</select>
		<?php
	} else { print_r ($parentFeature);?>
		<select name="parentFeature" id="parentFeature"> 
					<option value="">Choose A Page</option>
					<?php   
				foreach($items as $item) {  
					echo '<option value="'.$item->ID.'"',$meta == $item->ID ? ' selected="selected"' : '','>'.$item->post_title.'</option>';   
				} // end foreach ?> 
		</select>
	<?php
	}
}

//COMPLETE INDEV CUSTOM METABOX-------------------------completeIndev
add_action( 'add_meta_boxes', 'add_completeIndev_custom_box' );

/* Do something with the data entered */
add_action( 'save_post', 'dynamic_save_completeIndev_postdata' );

/* Adds a box to the main column on the Post and Page edit screens */
function add_completeIndev_custom_box() {
    add_meta_box(
        'completeIndev_sectionid',
        __( 'Complete Indev', 'myplugin_textdomain' ),
        'completeIndev_custom_box',
        'indev');
}

/* Prints the box content */
function completeIndev_custom_box() {
    global $post;
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'dynamicUpdateMeta_noncename' );
    ?>
    <div id="meta_inner">
    <?php

    //get the saved meta as an array
	$completeIndev = get_post_meta($post->ID,'completeIndev',false);

	if ($completeIndev){
		echo 'Complete this Indev <input type="checkbox" name="complete_indev_check" checked disabled><br><b>THIS INDEV HAS BEEN COMPLETED AND IS NOW LOCKED!</b>';
	} elseif(!$completeIndev) {
		echo 'Complete this Indev <input type="hidden" name="complete_indev_check" value="0"/><input type="checkbox" name="complete_indev_check" value="1">';
	} else {
		echo "ERROR! something went wrong with retriving the metadata. Try refreshing.";
	}
		
	//echo 'Complete this Indev <input type="checkbox" name="complete_indev_check">';
}

//SAVE CUSTOM  METABOXES-------------------------
/* When the post is saved, saves our custom data */
function dynamic_save_postdata( $post_id ) {
    // verify if this is an auto save routine. 
    // If it is our form has not been submitted, so we dont want to do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
        return;

    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    if ( !isset( $_POST['dynamicMeta_noncename'] ) )
        return;

    if ( !wp_verify_nonce( $_POST['dynamicMeta_noncename'], plugin_basename( __FILE__ ) ) )
        return;

    // OK, we're authenticated: we need to find and save the data
	global $post;
    $objectives = $_POST['objectives'];
	$updates = $_POST['updates'];
	$parentFeature = $_POST['parentFeature'];
	$oldParentFeature = get_post_meta($post->ID,'parentFeature',false);
	$complete_indev_check = $_POST['complete_indev_check'];
	$current_time = current_time( 'mysql' );

	if ($complete_indev_check == 1) {
		add_post_meta($post_id,'completeIndev',$current_time,true);
	}
    update_post_meta($post_id,'objectives',$objectives);
	update_post_meta($post_id,'updates',$updates);
	if ($oldParentFeature !== $parentFeature){
		update_post_meta($oldParentFeature[0],'history','N');
		update_post_meta($parentFeature,'history','Y');
		update_post_meta($post_id,'parentFeature',$parentFeature);
	}
	
	
}
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