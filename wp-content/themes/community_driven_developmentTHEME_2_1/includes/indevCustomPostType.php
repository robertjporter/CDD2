<?php
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