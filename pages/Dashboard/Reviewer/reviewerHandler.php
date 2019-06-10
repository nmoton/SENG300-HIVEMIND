<?php
//initialize a session 
session_start();

$email = "";

//prints the last sql query error to phpError.log
ini_set("log_errors", 1);
ini_set("error_log", "phpError.log");

$errors = array();

//create db link
$db = mysqli_connect('localhost', 'root', '', 'journal');

if (isset($_POST['register']))
{
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$institution = $_POST['institution'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$confirmPassword = $_POST['confirmPassword'];
	
	$user_check_query = "SELECT * FROM userProfile WHERE email='$email' LIMIT 1";
	$result = mysqli_query($db, $user_check_query);
	$user = mysqli_fetch_assoc($result);
	
	//doing error checks 
	if ($password !== $confirmPassword)
	{
		array_push($errors, "Passwords do not match");
	}
	
	if ($user) 
	{
		if ($user['email'] === $email) 
		{
		  array_push($errors, "E-mail already exists");
		}
	}
	
	//Register the user if there are no errors
	if (count($errors) == 0) 
	{
		$password = md5($password);//encrypt the password

		$query = "INSERT INTO userProfile (email, password, firstName, lastName, institution) 
				  VALUES('$email', '$password', '$firstName', '$lastName', '$institution')";
		$result = mysqli_query($db, $query);
		
		$_SESSION['email'] = $email;
  	    $_SESSION['success'] = "You are now registered and logged-in. Welcome!";
		header('location: dashboard.php');

	}
}





//for logging in users 
if (isset($_POST['login'])) 
{
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  //adding error checks
  if (empty($email)) 
  {
  	array_push($errors, "email is required");
  }
  
  if (empty($password)) 
  {
  	array_push($errors, "Password is required");
  }

  if (count($errors) == 0) 
  {
  	$password = md5($password);
  	$query = "SELECT * FROM userProfile WHERE email='$email' AND password='$password'";
  	$results = mysqli_query($db, $query);
   
  	if (mysqli_num_rows($results) == 1) 
   {
  	  $_SESSION['email'] = $email;
  	  $_SESSION['success'] = "You are now logged in";
  	  header('location: dashboard.php');
  	}
     
   else 
   {
  		array_push($errors, "Wrong email/password combination");
  	}
  }

}



//feature 3: Backend Stuff
//	getting all the information from feature 2 and adding to the submissionProfile Table --> 


if (isset($_POST['reviewSubmission'])) 
		{
			
			$email = $_SESSION['email'];
			$submissionID = $_POST['paperID'];
			$decision = $_POST['decision'];

					
			$writerComments = $_POST['writerComments'];
			
			$editorComments = $_POST['editorComments'];

			
			
			//error checking if user forgot to add anything
			if (empty($email) || empty($submissionID) || empty($decision) || empty($writerComments) || empty($editorComments)) 
			{
				array_push($errors, "<b><center>One or more required fields is missing. Please ensure all relevant information has been entered.</center></b>");
			}
			
			
			$review_check_query = "SELECT * FROM reviewStatus WHERE AssignedSubmissionID='$submissionID' AND AssignedReviewerEmail='$email' LIMIT 1";
			$result = mysqli_query($db, $review_check_query);
			$reviewedPaper = mysqli_fetch_assoc($result);
	
			//doing error checks
			if ($reviewedPaper) 
			{
				if ($reviewedPaper['ReviewerFeedback']) 
				{
					array_push($errors, "This paper already has a review.");
				}

			}
			
			

			//if there are no errors then write all the info to an XML string, and store in the table reviewStatus
			if (count($errors) == 0) 
			{
				
				$xmlReview = "A great review!";

				$sql = "UPDATE reviewStatus SET ReviewerFeedback = '$xmlReview' WHERE AssignedSubmissionID = '$submissionID' AND AssignedReviewerEmail = '$email'";		
				
					if ($db->query($sql) === TRUE) 
					{
						//echo "New record created successfully";
						echo "<b><center>Submitted!</center></b>";
					} 
					
					else 
					{
						echo "Error: " . $sql . "<br>" . $db->error;
					}


			}

			

		}


?>