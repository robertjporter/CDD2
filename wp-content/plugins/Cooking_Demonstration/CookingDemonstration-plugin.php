<?php
/*
Plugin Name: Cooking Demonstration
Description: It's on the tin
* Version: 0.0
* Author: RJP
* Author URI: www.robertjporter.com
*/
add_action('wp_head', 'your_function_name');
function your_function_name(){
	?>
	<script type="text/javascript">
		var templateUrl = '<?php echo plugins_url(); ?>';
	</script>
	<?php
};

function wp_cookingDemo_shortcode(){
	

	wp_register_style('cook_style', plugins_url('cook.css',__FILE__ ));
	wp_enqueue_style('cook_style');
	wp_register_script('cook_script', plugins_url('cook.js',__FILE__ ));
  	wp_enqueue_script('cook_script');
	add_action( 'wp_footer', 'my_header_scripts' );

	echo "
		<div class='options' id='options'>
		</div>
		<div class='output'>
			<div id='ingredient_1' class='item'></div>
			<div id='ingredient_2' class='item'></div>
			<div id='ingredient_3' class='item'></div>
			<div id='ingredient_4' class='item'></div>
			<div id='ingredient_spice' class='item'></div>
			<div class='item'>=</div>
			<div class='result'>
				<canvas id='result' width='128' height='64'>
				</canvas>
			</div>
		</div>
		<div class='name' id='name'>
		<div class='effects' id='effects'>

		<div>
	";

	
}
add_shortcode('cookingDemo', 'wp_cookingDemo_shortcode');
?>