<?php
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

/*
function create_feature_history_post_type() {
	register_post_type( 'feature_history',
	  array(
		'labels' => array(
		  'name' => __( 'Feature Histories' ),
		  'singular_name' => __( 'Feature History' )
		),
		'public' => true,
		'has_archive' => true,
	  )
	);
  }
  add_action( 'init', 'create_feature_history_post_type' );
  
?>
*/