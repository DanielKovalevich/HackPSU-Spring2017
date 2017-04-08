<?php
session_start();
include("connection.php");

	if(empty($_POST["username"]) || empty($_POST["password"]))
	{
		$error = "Both fields are required";
	} else {

		$password = md5($password);

		//Add the username and password to the database
		$stmt = $db->prepare("INSERT INTO users (uid, username, password) VALUES (:uid, :username, :password)");

		$stmt->bindParam(':uid', rand(0, 30000));
		$stmt->bindParam(':username', $username);
		$stmt->bindParam(':password', $password);
		if($stmt->execute()) {
			header("Location: http://104.236.109.78/home.php");
		}

		else {
			print("Well, fuck");
		}

	
}
