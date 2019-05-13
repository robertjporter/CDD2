	//Canvas
	var myCanvas = document.getElementById("myCanvas");
	myCanvas.width = 500;
	myCanvas.height = 500;
	var ctx = myCanvas.getContext("2d");
	
	//MP Calculations
	function MP_update(){
		var damage_input = Number(document.getElementById("damage_input").value);
		var range_input = 1+(Number(document.getElementById("range_input").value/2)/5);
		var charge_input = Number(document.getElementById("charge_input").value);
		var spread_input = 1+(Number(document.getElementById("spread_input").value)/100);
		
		
		
		var MP_cost = (((damage_input*10)*(range_input))*spread_input)/charge_input;
		
		var MP_output = document.getElementById("MP_output");
		MP_output.innerHTML = Math.floor(MP_cost);
	}
	
	MP_update()
	
	damage_input.oninput = function() {
		MP_update()
	}
	
	//Damage Calculations
	function damage_update(){
		var damage_input = document.getElementById("damage_input").value;
		var damage_output = document.getElementById("damage_output");
		damage_output.innerHTML = damage_input*10;
	}
	
	damage_update()
	
	damage_input.oninput = function() {
		damage_update()
		MP_update()
	}
	
	//charge Calculations
	function charge_update(){
		var charge_input = document.getElementById("charge_input").value;
		var charge_output = document.getElementById("charge_output");
		charge_output.innerHTML = charge_input;
	}
	
	charge_update()
	
	charge_input.oninput = function() {
		charge_update()
		MP_update()
	}
	
	//Draw wedge
	function drawPieSlice(){
		ctx.clearRect(0, 0, 500, 500);
		
		var range_input = document.getElementById("range_input").value*10;
		var spread_input = document.getElementById("spread_input").value;
		var color_input = '#ff0000';
		var spread_start = (2-(spread_input/100))*Math.PI;
		var spread_end = (2+(spread_input/100))*Math.PI;
	
		ctx.fillStyle = color_input;
		ctx.beginPath();
		ctx.moveTo(250,250);
		ctx.arc(250, 250, range_input, spread_start, spread_end);
		ctx.closePath();
		ctx.fill();
		
		var range_output = document.getElementById("range_output");
		var spread_output = document.getElementById("spread_output");
		range_output.innerHTML = range_input/10;
		spread_output.innerHTML = Math.floor((spread_input/100)*360);
	}
	
	drawPieSlice();
	
	range_input.oninput = function() {
		drawPieSlice();
		MP_update()
	}
	
	spread_input.oninput = function() {
		drawPieSlice();
		MP_update()
	}