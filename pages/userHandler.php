<?php
session_start();

$email = "";

//initialize error log (use for debugging). Ex;
//error_log(mysqli_error($db)); 
//prints the last sql query error to phpError.log
ini_set("log_errors", 1);
ini_set("error_log", "phpError.log");

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
	
	//Register the user if there are no errors
	if (count($errors) == 0) 
	{
		$password = md5($password);//encrypt the password

		$query = "INSERT INTO Table1 (email, password, firstName, lastName, institution) 
				  VALUES('$email', '$password', '$firstName', '$lastName', '$institution')";
		$result = mysqli_query($db, $query);
		
		header('location: Dashboard/dashboard.php');

	}
}

if (isset($_POST['login'])){
	$password = mysqli_real_escape_string($db, $_POST['password']);
	$email = mysqli_real_escape_string($db,$_POST['email']);

	$password = md5($password);
	
	$query = "SELECT * FROM Table1 WHERE email='$email' AND password='$password'";
	$result = mysqli_query($db, $query);
	
	if (mysqli_num_rows($result) == 1){
		header('location: Dashboard/dashboard.php');
	}
}

?>
