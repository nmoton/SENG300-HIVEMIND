<?php
session_start();

$email = "";

//initialize error log
ini_set("log_errors", 1);
ini_set("error_log", "php-error.log");

$errors = array();

//create db link
$db = mysqli_connect('localhost', 'root', '', 'journal');

if (isset($_POST['register'])){
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$institution = $_POST['institution'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$confirmPassword = $_POST['confirmPassword'];
	
	$user_check_query = "SELECT * FROM Table1 WHERE email='$email' LIMIT 1";
	$result = mysqli_query($db, $user_check_query);
	$user = mysqli_fetch_assoc($result);
	
	if ($password !== $confirmPassword){
		array_push($errors, "Passwords do not match");
	}
	
	if ($user) {
		if ($user['email'] === $email) {
		  array_push($errors, "E-mail already exists");
		}
	}
	
	// Finally, register user if there are no errors in the form
	if (count($errors) == 0) 
	{
		$password = md5($password);//encrypt (hashing) the password before saving in the database

		$query = "INSERT INTO Table1 (email, password, firstName, lastName, institution) 
				  VALUES('$email', '$password', '$firstName', '$lastName', '$institution')";
		mysqli_query($db, $query);
		
		// Enter user session 
		$_SESSION['email'] = $email;
	}
	
}


?>
