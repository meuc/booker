<?php

require("conn.php");

function isLoggedIn() {
	return isset($_SESSION["user_id"]);
}

function db() {
	$servername = "localhost";
	$username = "root";
	$password = "root";
	$dbname = "mandatory2";

	$db = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
	return $db;
}

function currentUser() {
	if (isLoggedIn()) {
		$statement = db()->query("SELECT * FROM users WHERE id = ".$_SESSION["user_id"]);
		return $statement->fetch(PDO::FETCH_ASSOC);
	} else {
		return null;
	}
}