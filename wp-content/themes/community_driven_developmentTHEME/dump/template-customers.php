<?php 
/*
Template Name: Customers
*/

get_header(); ?>

<?php
	global $wpdb;
	$customers = $wpdb->get_results("SELECT * FROM customers;");
	echo "<table>";
	foreach($customers as $customer){
	echo "<tr>";
	echo "<td>".$customer->name."</td>";
	echo "<td>".$customer->email."</td>";
	echo "<td>".$customer->phone."</td>";
	echo "<td>".$customer->address."</td>";
	echo "</tr>";
	}
	echo "</table>";
?>

<?php if (is_user_logged_in()):?>

		<form type="post" action="" id="newCustomerForm">

		<label for="name">Name:</label>
		<input name="name" type="text" />

		<label for="email">Email:</label>
		<input name="email" type="text" />

		<label for="phone">Phone:</label>
		<input name="phone" type="text" />

		<label for="address">Address:</label>
		<input name="address" type="text" />

		<input type="hidden" name="action" value="addCustomer"/>
		<input class="btn btn-success" type="submit">
		</form>
		<br/><br/>
		<div id="feedback"></div>
		<br/><br/>
<?php endif ?>

<script type="text/javascript">
jQuery('#newCustomerForm').submit(ajaxSubmit);

function ajaxSubmit(){

var newCustomerForm = jQuery(this).serialize();

jQuery.ajax({
type:"POST",
url: ajax_var.url,
data: newCustomerForm,
success:function(data){
jQuery("#feedback").html(data);
}
});

return false;
}
</script>

<?php get_footer(); ?>