<?php
/*
Plugin Name: Inventory Demo
Description: It's on the tin
* Version: 0.0
* Author: RJP
* Author URI: www.robertjporter.com
*/
add_action('wp_head', 'insert_head');
function insert_head(){
	?>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<?php
};

function wp_InventoryDemo_shortcode(){
	

	wp_register_style('inv_style', plugins_url('Inventory.css',__FILE__ ));
	wp_enqueue_style('inv_style');
	wp_register_script('inv_script', plugins_url('Inventory.js',__FILE__ ));
  	wp_enqueue_script('inv_script');
	add_action( 'wp_footer', 'my_header_scripts' );

	?>
		<h1>Inventory Example</h1>
		<p>ADD</p>
		<input id="IronHelmet" type="button" value="Iron Helmet" onclick="addItem('IronHelmet',5);" />
		<input id="BronzePlate" type="button" value="Bronze Plate" onclick="addItem('BronzePlate',10);" />
		<input id="LeatherPants" type="button" value="Leather Pants" onclick="addItem('LeatherPants',5);" />
		<input id="LeatherBoots" type="button" value="Leather Boots" onclick="addItem('LeatherBoots',2);" />
		<input id="IronSword" type="button" value="Iron Sword" onclick="addItem('IronSword',3);" />
		<input id="IronIngot" type="button" value="Iron Ingot" onclick="addItem('IronIngot',1);" />
		<input id="BronzeIngot" type="button" value="Bronze Ingot" onclick="addItem('BronzeIngot',1);" />
		<input id="TinOre" type="button" value="Tin Ore" onclick="addItem('TinOre',1);" />
		<input id="CopperOre" type="button" value="Copper Ore" onclick="addItem('CopperOre',1);" />
		<input id="IronOre" type="button" value="Iron Ore" onclick="addItem('IronOre',1);" />
		<br><br>
		<p>REMOVE</p>
		<input id="IronHelmet" type="button" value="Iron Helmet" onclick="removeItem('IronHelmet',5);" />
		<input id="BronzePlate" type="button" value="Bronze Plate" onclick="removeItem('BronzePlate',10);" />
		<input id="LeatherPants" type="button" value="Leather Pants" onclick="removeItem('LeatherPants',5);" />
		<input id="LeatherBoots" type="button" value="Leather Boots" onclick="removeItem('LeatherBoots',2);" />
		<input id="IronSword" type="button" value="Iron Sword" onclick="removeItem('IronSword',3);" />
		<input id="IronIngot" type="button" value="Iron Ingot" onclick="removeItem('IronIngot',1);" />
		<input id="BronzeIngot" type="button" value="Bronze Ingot" onclick="removeItem('BronzeIngot',1);" />
		<input id="TinOre" type="button" value="Tin Ore" onclick="removeItem('TinOre',1);" />
		<input id="CopperOre" type="button" value="Copper Ore" onclick="removeItem('CopperOre',1);" />
		<input id="IronOre" type="button" value="Iron Ore" onclick="removeItem('IronOre',1);" />
	
		
		
		<div id='donutchart' style='width: 900px; height: 500px;'></div>
	<?php
}
add_shortcode('InventoryDemo', 'wp_InventoryDemo_shortcode');
?>