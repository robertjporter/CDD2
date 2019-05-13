

var ingredients = {
	"apple": {
		"name":"apple",
		"raw_img":"apple",
		"cooked_img":"apple_cooked",
		"soup_img":"img",
		"synergy":"synergy",
		"clash":"clash",
		"spice":false,
		"spice_bonus":"spice_bonus",
		"cook_rate":"cook_rate",
		"effect":""
	},
	"egg": {
		"name":"egg",
		"raw_img":"egg",
		"cooked_img":"egg_cooked",
		"soup_img":"img",
		"synergy":"synergy",
		"clash":"clash",
		"spice":false,
		"spice_bonus":"spice_bonus",
		"cook_rate":"cook_rate",
		"effect":""
	},
	"mushroom": {
		"name":"mushroom",
		"raw_img":"mushroom",
		"cooked_img":"mushroom_cooked",
		"soup_img":"img",
		"synergy":"synergy",
		"clash":"clash",
		"spice":false,
		"spice_bonus":"spice_bonus",
		"cook_rate":"cook_rate",
		"effect":""
	},
	"carrot": {
		"name":"carrot",
		"raw_img":"carrot",
		"cooked_img":"carrot_cooked",
		"soup_img":"img",
		"synergy":"synergy",
		"clash":"clash",
		"spice":false,
		"spice_bonus":"spice_bonus",
		"cook_rate":"cook_rate",
		"effect":""
	},
	"potato": {
		"name":"potato",
		"raw_img":"potato",
		"cooked_img":"potato_cooked",
		"soup_img":"img",
		"synergy":"synergy",
		"clash":"clash",
		"spice":false,
		"spice_bonus":"spice_bonus",
		"cook_rate":"cook_rate"
	},
	"chicken": {
		"name":"chicken",
		"raw_img":"chicken",
		"cooked_img":"chicken_cooked",
		"soup_img":"img",
		"synergy":"synergy",
		"clash":"clash",
		"spice":false,
		"spice_bonus":"spice_bonus",
		"cook_rate":"cook_rate"
	},
	"beef": {
		"name":"beef",
		"raw_img":"beef",
		"cooked_img":"beef_cooked",
		"soup_img":"img",
		"synergy":"synergy",
		"clash":"clash",
		"spice":false,
		"spice_bonus":"spice_bonus",
		"cook_rate":"cook_rate"
	},
	"pepper": {
		"name":"pepper",
		"raw_img":"pepper",
		"cooked_img":"img",
		"soup_img":"img",
		"synergy":"synergy",
		"clash":"clash",
		"spice":true,
		"spice_bonus":"spice_bonus",
		"cook_rate":"cook_rate"
	}
}

var effects = {
	"carrot": {
		"name":"carrot",
		"raw_img":"carrot"
	}
}

function serve_dish(){
	console.log("serve_dish RUN");
	var c = document.getElementById("result");
	var ctx = c.getContext("2d");

	var ingredient_spice = document.getElementById('ingredient_spice').innerHTML;

	var ingredient_1 = document.getElementById('ingredient_1').innerHTML;
	var ingredient_1_cooked_img = ingredients[ingredient_1].cooked_img;
	var ingredient_1_canvas_img = new Image;
	ingredient_1_canvas_img.src = templateUrl + '/Cooking_Demonstration/img/' + ingredient_1_cooked_img + '.png';
	
	var ingredient_2 = document.getElementById('ingredient_2').innerHTML;
	var ingredient_2_cooked_img = ingredients[ingredient_2].cooked_img;
	var ingredient_2_canvas_img = new Image;
	ingredient_2_canvas_img.src = templateUrl + '/Cooking_Demonstration/img/' + ingredient_2_cooked_img + '.png';

	var ingredient_3 = document.getElementById('ingredient_3').innerHTML;
	var ingredient_3_cooked_img = ingredients[ingredient_3].cooked_img;
	var ingredient_3_canvas_img = new Image;
	ingredient_3_canvas_img.src = templateUrl + '/Cooking_Demonstration/img/' + ingredient_3_cooked_img + '.png';

	var ingredient_4 = document.getElementById('ingredient_4').innerHTML;
	var ingredient_4_cooked_img = ingredients[ingredient_4].cooked_img;
	var ingredient_4_canvas_img = new Image;
	ingredient_4_canvas_img.src = templateUrl + '/Cooking_Demonstration/img/' + ingredient_4_cooked_img + '.png';

	//'url('+ templateUrl +'/Cooking_Demonstration/img/' + ingredient_1_cooked_img + '.png)'
	//templateUrl + 'Cooking_Demonstration/img/' + ingredient_1_cooked_img + '.png'
	//'img/' + ingredient_4_cooked_img + '.png';

	var bowl_front_canvas_img = new Image;
	bowl_front_canvas_img.src = templateUrl + '/Cooking_Demonstration/img/bowl_front.png';

	var bowl_back_canvas_img = new Image;
	bowl_back_canvas_img.src = templateUrl + '/Cooking_Demonstration/img/bowl_back.png';

	bowl_back_canvas_img.onload = function(){
		ctx.drawImage(bowl_back_canvas_img,-5,12);
		ctx.drawImage(ingredient_1_canvas_img,8,0);
		ctx.drawImage(ingredient_2_canvas_img,23,4);
		ctx.drawImage(ingredient_3_canvas_img,5,8);
		ctx.drawImage(ingredient_4_canvas_img,20,12);
		ctx.drawImage(bowl_front_canvas_img,-5,12);
	}

	function calculate_name(){
		var dish_array = [
			ingredients[ingredient_1].name
		];
		 
		if (dish_array.includes(ingredients[ingredient_2].name) == false) {
			dish_array.push(ingredients[ingredient_2].name)
		}
		if (dish_array.includes(ingredients[ingredient_3].name) == false) {
			dish_array.push(ingredients[ingredient_3].name)
		}
		if (dish_array.includes(ingredients[ingredient_4].name) == false) {
			dish_array.push(ingredients[ingredient_4].name)
		}

		
		var last_ing = dish_array.slice(dish_array.length-1);
		dish_array.pop();
		var and_joiner = " and ";
		if (dish_array < 1){
			and_joiner = " ";
		};

		var dish_name = "BBQ " + ingredient_spice + "ed "+ dish_array.toString() + and_joiner + last_ing + " plate.";

		var name_textbox = document.getElementById('name');
		name_textbox.innerHTML = dish_name;
	}

	function calculate_effects(){

	}
	calculate_name()
}


function add_item(item_name){
	var ingredient_1 = document.getElementById('ingredient_1');
	var raw_img = ingredients[item_name].raw_img;

	function add_item_to_ingredient_slot(ingredient_slot){
		ingredient_slot = document.getElementById(ingredient_slot);

		ingredient_slot.style.backgroundImage = 'url('+ templateUrl +'/Cooking_Demonstration/img/' + raw_img + '.png)';
		ingredient_slot.style.backgroundRepeat = "no-repeat";
		ingredient_slot.style.backgroundPosition = "center";
		ingredient_slot.innerHTML = item_name;
	}

	if(ingredient_1.innerHTML == ""){
		add_item_to_ingredient_slot("ingredient_1");
	} else if (ingredient_2.innerHTML == ""){
		add_item_to_ingredient_slot("ingredient_2");
	} else if (ingredient_3.innerHTML == ""){
		add_item_to_ingredient_slot("ingredient_3");
	} else if (ingredient_4.innerHTML == ""){
		add_item_to_ingredient_slot("ingredient_4");
		var childDivs = document.getElementById('options').getElementsByTagName('div');
		for( i=0; i< childDivs.length; i++ )
		{
				var childDiv = childDivs[i];
				if(ingredients[childDivs[i].innerHTML].spice == true){
					document.getElementById(childDivs[i].innerHTML).style.visibility= "visible" ;
				} else if (ingredients[childDivs[i].innerHTML].spice == false){
					document.getElementById(childDivs[i].innerHTML).style.visibility= "hidden" ;
				}
		}
	} else if (ingredient_spice.innerHTML == ""){
		add_item_to_ingredient_slot("ingredient_spice");
		serve_dish();
	}
}

function populate_item(item_name,raw_img) {
	var node = document.createElement("div");
	var spice = ingredients[item_name].spice;
	var raw_img = ingredients[item_name].raw_img;

	node.setAttribute("id", item_name);
	node.className = 'item';
	node.style.backgroundImage = 'url('+ templateUrl +'/Cooking_Demonstration/img/' + raw_img + '.png)';
	node.style.backgroundRepeat = "no-repeat";
	node.style.backgroundPosition = "center";
	node.style.cursor = 'pointer';
	node.onclick = function() { add_item(item_name); };
	var textnode = document.createTextNode(item_name);
	node.appendChild(textnode);
	document.getElementById("options").appendChild(node);
	

	if (spice == false) {
		node.style.visibility = "visible";
	} else if (spice == true){
		node.style.visibility = "hidden";
	}
}

function populate_item_list(){
	for (i in ingredients) {
		populate_item(ingredients[i].name, ingredients[i].raw_img);
	}
}

populate_item_list()
