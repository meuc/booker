$('#myTabs a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
})

function tabSwitch(newTab, oldTab) {
	$("." + newTab + "-tab").attr("data-toggle", "tab");
	$("." + oldTab + "-tab").attr("aria-expanded", "false");
	$("." + newTab + "-tab").attr("aria-expanded", "true");
	
	$("." + oldTab + "-li").removeClass("active");
	$("." + newTab + "-li").addClass("active");
	
	$("#" + oldTab + "").removeClass("in active");
	$("#" + newTab + "").addClass("active in");
}

if (localStorage.getItem("savedContent")) {
	$("#booking").html(localStorage.getItem("savedContent"));
	tabSwitch("booking", "home");
}

$(".btnPick").click(function(){
	tabSwitch("booking", "flights");

	var tickets = $(this).parents(".flight").find("select").val();
	var flightId = $(this).parents(".flight").attr("data-id");

	$.ajax({
		type: "GET",
	  url: "ajax.php",
		data: {flightId: flightId, 
					 event: "getFlight"}
	})
		.done(function(flight) {
			var chosenFlight = JSON.parse(flight);
			// console.log(chosenFlight);
			
			displayFlight(chosenFlight[0], tickets);
		})
		.fail(function() {
			console.log("FAIL", arguments);
		});
});

function displayFlight(chosenFlight, tickets) {
	var flightId = chosenFlight.id;
	var flightNumber = chosenFlight.flight_number;
	var from = chosenFlight.flight_from;
	var to = chosenFlight.flight_to;
	var departure = chosenFlight.departure_time;
	var arrival = chosenFlight.arrival_time;
	var price = chosenFlight.price * tickets;
	
	var flight = '<div class="flight col-md-4" data-id="' + flightId + '"><i class="fa fa-globe"></i><div class="flight-nr"><i class="fa fa-plane"></i>' + flightNumber + '</div><p>Tickets: <span>' + tickets + '<span></p><div class="places-wrap"><span>' + from + '</span><span>&rarr;</span><span>' + to + '</span></div><div class="times-wrap"><span>' + moment(departure).format('hh:mm') + '</span> - <span>' + moment(arrival).format('hh:mm') + '</span><br><span>' + moment(departure).format('DD/MM/YYYY') + '</span></div><div class="price" style="color: #df6843">' + price + 'kr</div></div>';
	
	$(".passengers").before(flight);
	
	for(var i = 0; i < tickets; i++) {
		var passengerForm ='<h5>Passenger ' + (i+1) + ':</h5><div class="passenger"><input type="text" name="name" class="passenger-input" placeholder="Full name.." class="form-control" required><input type="text" name="age" class="passenger-input" placeholder="Age" class="form-control" required></div>';
		
		$(".passengers").append(passengerForm);
	}
}

$("#btnBuy").click(function(){
	var valid = true;
	var inputVals = $(".passenger-input").each(function() {
		var value = $(this).val();
		if (value == "") {
			var error = "<p style='color: red'>Please fill out this field!</p>";
			
			$(this).after(error);
			$(".passengers").css("border", "1px solid red");
			
			valid = false;
		}
	});
	
	if ($("html").hasClass("logged-in") && valid) {
		tabSwitch("payment", "booking");
	} else {
		var savedContent = $("#booking").html();
		localStorage.setItem("savedContent", savedContent);		
		tabSwitch("profile", "booking");
	}
	
});

$("#btnPay").click(function(){
	// var flightId = ;
	// var userId = ;
	// $.ajax({
	// 	type: "GET",
	//   url: "ajax.php",
	// 	data: {/* flight id */,
	//				/* user id */,
	// 				 event: "buyFlight"}
	// })
	// 	.done(function() {
	//
	// 	})
	// 	.fail(function() {
	// 		console.log("FAIL", arguments);
	// 	});
	
	localStorage.removeItem("savedContent");
});

$(".btnLogout").click(function(){
	$.ajax('ajax.php', {
		data: {"event": "logout"},
		method: "get"
	})
		.done(function(response){
		location.reload();
	})
		.fail(function(response){

	});
});

$(".signup form").submit(function(e) {
	e.preventDefault();
	
	$.ajax({
		type: "POST",
	  url: "ajax.php",
		data: $(this).serialize()
	})
		.done(function() {
			console.log("OK", arguments);
			location.reload();
		})
		.fail(function() {
			console.log("FAIL", arguments);
		});
});

$(".login form").submit(function(e){
	e.preventDefault();
	
	$.ajax({
		type: "POST",
	  url: "ajax.php",
		data: $(this).serialize()
	})
		.done(function(data) {
			console.log("OK", arguments);
			location.reload();
		})
		.fail(function() {
			console.log("FAIL", arguments);
	});
});
	//
	// $.ajax({
	// 	type: "POST",
	//   url: "ajax.php"
	// }).done(function() { console.log("ok", arguments) }).fail(function() { console.log("FAIL", arguments) });