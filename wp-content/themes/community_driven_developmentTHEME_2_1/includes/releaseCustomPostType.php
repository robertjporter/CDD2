<?php
add_action( 'init', 'create_release_post_types' );

function create_release_post_types() {
	register_post_type( 'release', 
		array(
			'labels' => array(
				'name' => __( 'Releases' ),
				'singular_name' => __( 'Release' )
			),
			'public' => true,
			'menu_position' => 28,
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

//OBJECTIVE CUSTOM  METABOXES-------------------------
add_action( 'add_meta_boxes', 'dynamic_add_indev_feature_custom_box' );

/* Do something with the data entered */
add_action( 'save_post', 'dynamic_save_indev_postdata' );

/* Adds a box to the main column on the Post and Page edit screens */
function dynamic_add_indev_feature_custom_box() {
    add_meta_box(
        'dynamic_sectionid',
        __( 'Indev features', 'myplugin_textdomain' ),
        'dynamic_inner_release_custom_box',
        'release');
}

/* Prints the box content */
function dynamic_inner_release_custom_box() {
    global $post;
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'dynamicMeta_noncename' );
    ?>
    <div id="meta_inner">
    <?php

    //get the saved meta as an array
    $indev_feature = get_post_meta($post->ID,'indev_feature',false);

    $c = 0;
    if(is_array($indev_feature[0])){
        foreach( $indev_feature[0] as $complete ) {
            if ( isset( $complete['title'] ) || isset( $complete['complete'] ) ) {
                printf( '<p> Indev Feature Permalink <input type="text" size="35" name="indev_feature[%1$s][title]" value="%2$s" /><button  class="remove">%4$s</button></p><hr>', $c, $complete['title'], __( 'Remove' ) );
                $c = $c +1;
            }
        }
    }

    ?>
<span id="here"></span>
<button class="add"><?php _e('Add Indev Feature'); ?></button>
<script>
    var $ =jQuery.noConflict();
    $(document).ready(function() {
        var count = <?php echo $c; ?>;
        $(".add").click(function() {
            count = count + 1;

            $('#here').append('<p> Indev Feature Permalink <input type="text" size="35" name="indev_feature['+count+'][title]" value="" /><button  class="remove">Remove</button></p><hr>' );
            return false;
        });
        $(".remove").live('click', function() {
            $(this).parent().remove();
        });
    });
    </script>
</div><?php
}

//SAVE CUSTOM  METABOXES-------------------------
/* When the post is saved, saves our custom data */
function dynamic_save_indev_postdata( $post_id ) {
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
    $indev_feature = $_POST['indev_feature'];

	if ($complete_indev_check == 1) {
		add_post_meta($post_id,'completeIndev',$current_time,true);
	}
    update_post_meta($post_id,'indev_feature',$indev_feature);
	update_post_meta($post_id,'updates',$updates);
	
	
}