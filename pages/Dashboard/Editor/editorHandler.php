<?php
$errors = array();



//initialize error log (use for debugging). Ex;
//error_log(mysqli_error($db)); 
//prints the last sql query error to editorHandlerErrorlog
ini_set("log_errors", 1);
ini_set("error_log", "editorHandlerError.log");

$db = mysqli_connect('localhost', 'root', '', 'journal');

//handles the add reviewer button
if (isset($_POST['addReviewer']))
{
	$submissionId = $_POST['submissionId'];
	$email = $_POST['email'];
	
	//check if the submission Id is a valid paper waiting to be assigned a reviewer
	$valid_submission_query = "SELECT * FROM submissionProfile WHERE submissionId = '$submissionId' AND PaperStatus = 'submitted'";
	$valid_submission_Id = mysqli_query($db, $valid_submission_query);
	
	//check if the email belongs to a reviewer
	$valid_email_query = "SELECT * FROM userProfile WHERE email = '$email' AND userType = 'reviewer'";
	$valid_email = mysqli_query($db, $valid_email_query);
	
	error_log(mysqli_num_rows($valid_email));
	error_log(mysqli_num_rows($valid_submission_Id));
	

	
	if (mysqli_num_rows($valid_submission_Id) && mysqli_num_rows($valid_email)){
		error_log("here");
			
		$assignedDeadlineReviewer = $_POST['reviewDeadline'];
		$writerResubmissionDate = $_POST['resubmissionDeadline'];
	
		$query = "INSERT INTO reviewStatus (AssignedSubmissionID, AssignedReviewerEmail, AssignedDeadlineReviewer, IntrimStatusUpdate,WritersResubmissionDate) 
		 VALUES('$submissionId', '$email', '$assignedDeadlineReviewer', 'Empty', '$writerResubmissionDate')";
		$result = mysqli_query($db,$query);
		
		$update = "UPDATE submissionProfile SET PaperStatus = 'underReview' WHERE submissionId = '$submissionId'";
		mysqli_query($db,$update);
		
		//reload the page
		header('location: editor.php');
		 
	} else {
		array_push($errors, "Please enter a valid submission Id and reviewer E-mail");
	}

}
?>