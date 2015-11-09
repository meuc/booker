<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$gender = $_POST['gender'];
	$birthday = $_POST['birthday'];
	$password = $_POST['password'];
		
	// print_r($_POST);
	
	if ( $firstname != ""
		&& $lastname  != ""
		&& $email  		!= ""
		&& $phone			!= ""
		&& $birthday	!= ""
		&& $password	!= "") {
		$response "whatever";
	} else {
		$response = "Please fill out the whole form.";
	}
	
	echo $response;

	
	
	
	
	
	
	
?>