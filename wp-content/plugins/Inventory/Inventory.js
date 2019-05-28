google.charts.load("current", {packages:["corechart"]});
google.charts.setOnLoadCallback(drawChart);

var inventory_limit = 100;
var inventory = [
	];
var options = {
	title: 'Player Inventory',
	pieHole: 0.9,
	backgroundColor: 'transparent',
	pieSliceBorderColor : "transparent",
	pieSliceText: "none",
	legend: {textStyle: {color: 'black'}},
	colors: []
};

var initialInventory=[
	//NAME,		WEIGHT,	COLOR
	['IronHelmet',	5,		'#838585'],
	['BronzePlate',	10,      '#a4825d'],
	['LeatherPants',	5,		'#45361e'],
	['LeatherBoots',	2,		'#45361e'],
	['IronSword',	3,		'#838585'],
	['IronIngot',	1,      '#838585'],
	['BronzeIngot',	1,		'#a4825d'],
	['TinOre',	1,		'#888572'],
	['CopperOre',	1,		'#203831'],
	['IronOre',	1,      '#55412b'],
	['Free Space',0,	'#1e1e1e']//REQUIRED Must always be on bottom
];



function drawChart() {
	inventory[inventory.length-1][1]=0;
	total = 0;
	for (i = 0; i < inventory.length; i++) {  //loop through the array
		total += inventory[i][1];  //Do the math!
	}
	inventory[inventory.length-1][1]=inventory_limit-total;

			var data = new google.visualization.DataTable();
	data.addColumn('string', 'Browser');
	data.addColumn('number', 'Percentage');
	data.addRows(inventory);

	console.dir(inventory);
			var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
	chart.draw(data, options);
}
	
function addItem(itemName,weight){
	console.dir(inventory);
	console.log ('inventory_limit-weight ');
	console.log (inventory_limit+weight);
	console.log ('total');
	console.log (total);
	for (i = 0; i < inventory.length; i++) {  //loop through the array
		if(total+weight < inventory_limit+weight){
			
			console.log (inventory[i].indexOf(itemName));
			if ((inventory[i].indexOf(itemName)) != -1) {
				console.log (itemName+" found at "+i);
				inventory[i][1] = inventory[i][1]+weight;
				console.log(itemName+" inventory is now: "+ inventory[i][1]);
			}
		}else{console.log ('Inventory Full');}
	}
	console.dir(inventory);
	drawChart();
}

function removeItem(itemName,weight){
	console.dir(inventory);
	for (i = 0; i < inventory.length; i++) {  //loop through the array
		console.log (inventory[i].indexOf(itemName));
		if ((inventory[i].indexOf(itemName)) != -1) {
			if(inventory[i][1] != 0){
				console.log (itemName+" found at "+i);
				inventory[i][1] = inventory[i][1]-weight;
				console.log(itemName+" inventory is now: "+ inventory[i][1]);
			}
		}
	}
	console.dir(inventory);
	drawChart();
	}
	function fillInventory(){
	tempColors = [];
	for (i = 0; i < initialInventory.length; i++) { 
		console.log(initialInventory[i][0]+' '+initialInventory[i][1]+' '+initialInventory[i][2]);
		inventory.push([initialInventory[i][0], 0]);
		tempColors.push(initialInventory[i][2]); 
	}
	options.colors=tempColors;
}
fillInventory();

