<?php
/*
Plugin Name: Spell Calculator
Description: It's on the tin
* Version: 0.0
* Author: RJP
* Author URI: www.robertjporter.com
*/

function SpCalc_shortcode(){
	wp_register_style('SpCalc_style', plugins_url('SpCalc.css',__FILE__ ));
	wp_enqueue_style('SpCalc_style');
	wp_register_script('SpCalc_script', plugins_url('SpCalc.js',__FILE__ ));
  wp_enqueue_script('SpCalc_script');
	add_action( 'wp_footer', 'my_header_scripts' );

	echo "
		<br>
		Damage:<input type='range' min='1' max='100' step='1' value='1' class='slider' id='damage_input'>
		<span id='damage_output'></span> HP
		<br><br>
		Range:<input type='range' min='1' max='20' step='.5' value='1' class='slider' id='range_input'>
		<span id='range_output'></span> meters
		<br><br>
		Spread:<input type='range' min='1' max='100' step='1' value='1' class='slider' id='spread_input'>
		<span id='spread_output'></span> degrees
		<br><br>
		Charge:<input type='range' min='1' max='10' step='0.25' value='1' class='slider' id='charge_input'>
		<span id='charge_output'></span> sec
		<br><br>
		<p class='output'>Mana Cost: <span id='MP_output'></span>MP</p>
	";

	if ( wp_is_mobile() ) {
		echo "Sorry, canvas visualisation not available for mobile";
		echo "<canvas class='hidden' id='myCanvas'></canvas>";
	} else {
		echo "<canvas id='myCanvas'></canvas>";
	}
	
}
add_shortcode('SpCalc', 'SpCalc_shortcode');
?>