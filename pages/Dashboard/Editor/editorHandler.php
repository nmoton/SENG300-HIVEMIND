<?php
$errors = array();

//initialize error log (use for debugging). Ex;
//error_log(mysqli_error($db)); 
//prints the last sql query error to editorHandlerErrorlog
ini_set("log_errors", 1);
ini_set("error_log", "editorHandlerError.log");

$db = mysqli_connect('localhost', 'root', '', 'journal');

//handles the "Add Reviewer" button on the "Papers Awaiting a Reviewer" table
if (isset($_POST['addReviewer']))
{
	$submissionId = $_POST['addReviewer'];
	
	$submissionQuery = "SELECT * FROM submissionProfile WHERE submissionId = '$submissionId'";
	$submission = mysqli_query($db, $submissionQuery);
	
	while ($row = mysqli_fetch_assoc($submission)){
		echo '<tr>';
			echo '<td>' . $row['submissionId'] . '</td>';
			echo '<td>' . $row['paperTitle'] . '</td>';
			echo '<td>' . $row['email'] . '</td>';
			echo '<td>' . $row['topic'] . '</td>';
			echo '<td>' . $row['PaperStatus'] . '</td>';
			echo '<td>' . $row['dateOfSubmission'] . '</td>';
		echo '</tr>';
	}
	echo '</table>';
	echo '<br \><br>';
	
	$reviewerQuery = "SELECT * FROM reviewStatus WHERE AssignedSubmissionID = '$submissionId'";
	$reviewers = mysqli_query($db, $reviewerQuery);
	
	if (mysqli_num_rows($reviewers) == 0){
		echo "There are no reviewers currently assigned to this submission";
	} else {
		echo "These are the reviewers currently assigned to this submission:";
		while ($row = mysqli_fetch_assoc($reviewers)){
			echo $row['AssignedReviewerEmail'] . "&nbsp&nbsp";
		}
	}
	
	echo '<br \><br>';
	
	echo "The submitter has requested these reviewers: ";
	$submissionQuery = "SELECT * FROM submissionProfile WHERE submissionId = '$submissionId'";
	$submission = mysqli_query($db, $submissionQuery);
	while ($row = mysqli_fetch_assoc($submission)){
		echo $row['reviewerPreference1'] . "&nbsp&nbsp";
		echo $row['reviewerPreference2'] . "&nbsp&nbsp";
		echo $row['reviewerPreference3'];
	}
	
	echo "<br \><br>These reviewers have requested to review this paper: ";
	//will add when the functionality for a reviewer to request a paper is implemented
	
	echo '<br \><br><br>';
	echo '<form method="post">
		<div class="input-group">
			<label>Enter the E-mail of the reviewer you would like to assign to this paper</label>
			<input type="text" name="email"" required>
		</div>
			<div class="input-group">
			<label>Enter the review deadline</label>
			<input type="date" name="reviewDeadline" required>
		</div>
			</div>
			<div class="input-group">
			<label>Enter the resubmission deadline</label>
			<input type="date" name="resubmissionDeadline" required>
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="add" value = ' . $submissionId .'>Add</button>
		</div>
	</form>	';
	
}

//handles the add button the addReviewer page
if (isset($_POST['add']))
{
	$email = $_POST['email'];
	$submissionId = $_POST['add'];

	//check if the email belongs to a reviewer
	$valid_email_query = "SELECT * FROM userProfile WHERE email = '$email' AND userType = 'reviewer'";
	$valid_email = mysqli_query($db, $valid_email_query);
	
	$already_assigned_query = "SELECT * FROM reviewStatus WHERE AssignedreviewerEmail = '$email' AND AssignedSubmissionID = '$submissionId'";
	$already_assigned = mysqli_query($db, $already_assigned_query);
	
	
	if (mysqli_num_rows($already_assigned) > 0){
		array_push($errors, "This reviewer is already assigned to this paper");
	}
	else if (mysqli_num_rows($valid_email)){

		$assignedDeadlineReviewer = $_POST['reviewDeadline'];
		$writerResubmissionDate = $_POST['resubmissionDeadline'];
	
		$query = "INSERT INTO reviewStatus (AssignedSubmissionID, AssignedReviewerEmail, AssignedDeadlineReviewer, IntrimStatusUpdate,WritersResubmissionDate) 
		 VALUES('$submissionId', '$email', '$assignedDeadlineReviewer', 'Empty', '$writerResubmissionDate')";
		$result = mysqli_query($db,$query);
		
		$updateSubmission = "UPDATE submissionProfile SET PaperStatus = 'underReview' WHERE submissionId = '$submissionId'";
		mysqli_query($db,$updateSubmission);
		
		$updateNumReviewers = "UPDATE submissionProfile SET numReviewers = numReviewers + 1 WHERE submissionId = '$submissionId'";
		mysqli_query($db,$updateNumReviewers);
		
	} else {
		array_push($errors, "Please enter a valid reviewer E-mail");
	}
}
?>