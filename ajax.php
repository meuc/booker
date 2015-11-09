<?php

require("conn.php");
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

function fail_with_error() {
	http_response_code(400);
	die();
}

$event = null;
if (isset($_GET["event"])) {
	$event = $_GET['event'];
}
if (isset($_POST["event"])) {
	$event = $_POST['event'];
}

// TODO: Implement this
function hash_and_salt($password) {
	return $password;
}

if ($event == 'register') {
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$gender = $_POST['gender'];
	$birthday = $_POST['birthday'];
	$password = $_POST['password'];

	if ( $firstname != ""
		&& $lastname  != ""
		&& $email  		!= ""
		&& $phone			!= ""
		&& $birthday	!= ""
		&& $password	!= "") {
			
			// TODO: More validation stuff

			// create user in database
		$statement = $db->query("INSERT INTO users (firstname, lastname, email, phone, gender, birthday, password) VALUES ('$firstname', '$lastname', '$email', '$phone', '$gender', '$birthday', '".hash_and_salt($password)."')");
		$success = $statement->execute();

		if ($success) {
			$id = $db->lastInsertId();

			// sign in user
			$response = "Welcome " . $firstname;
			$_SESSION["user_id"] = $id;
		} else {
			$response = "Whoops, something went wrong. Try again!";
			fail_with_error();
		}
	} else {
		$response = "Please fill out the whole form.";
		fail_with_error();
	}

	// echo $response;
	
} else if ($event == 'login') {
	$email = $_POST['email'];
	$password = $_POST['password'];
		
	$result = $db->query("SELECT * FROM users WHERE email = '$email' AND password = '$password'");
	$user = $result->fetchAll(PDO::FETCH_ASSOC);

	if ($user) {
		$user = $user[0];

		$_SESSION["user_id"] = $user['id'];

		$response = "Welcome! Good to see you, " . $user['firstname'] . "!";
	} else {
		$response = "Password and email do not match";
		fail_with_error();
	}
} else if ($event == 'getFlight') {
	$flightId = $_GET['flightId'];
	
  $result = $db->query("SELECT * FROM flights WHERE id = $flightId");
  $flights = $result->fetchAll(PDO::FETCH_ASSOC);
	
	echo json_encode($flights);
} else if ($event == 'buyFlight') {
	
	//Form validation
	// if(  != ""
	// 	&&  != ""
	// 	&&  != ""
	// 	&&  != ""
	// 	&& )
	//save in database
	
	echo "we'll get there....";
	

	
	
	
	
} else if ($event == 'logout') {
		unset($_SESSION['user_id']);
		$response = "Logged out. Buy, buy!";
} else {
	$response = "Unknown event";
	fail_with_error()
}
