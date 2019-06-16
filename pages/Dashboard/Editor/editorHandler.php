<?php
$errors = array();

//initialize error log (use for debugging). Ex;
//error_log(mysqli_error($db)); 
//prints the last sql query error to editorHandlerErrorlog
ini_set("log_errors", 1);
ini_set("error_log", "editorHandlerError.log");

$db = mysqli_connect('localhost', 'root', '', 'journal');

//handles the "evaluate" button on the "To Do List" table
if (isset($_POST['evaluate'])){
	$submissionId = $_POST['evaluate'];
	
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
	
	echo '<b><h2><center> Reviewer Feedback </center></h2></b><br>';
	echo 'These reviewers have not yet submitted a review:';
	
	$reviewerQuery = "SELECT * FROM reviewStatus WHERE AssignedSubmissionId = '$submissionId' AND InterimStatusUpdate != 'reviewed'";
	$incompleteReviewers = mysqli_query($db, $reviewerQuery);
	
	while ($row = mysqli_fetch_assoc($incompleteReviewers)){
		echo $row['AssignedReviewerEmail'] . "&nbsp&nbsp";
	}
	
	echo '
	<table class = "table table-bordered">
	<tr>
		<th>&nbsp&nbspReviewer&nbsp&nbsp</th>
		<th>&nbsp&nbspReviewer Recommendation&nbsp&nbsp</th>
		<th>&nbsp&nbspFeedback for the Submitter&nbsp&nbsp</th>
		<th>&nbsp&nbspNotes to the Editor&nbsp&nbsp</th>
		<th>&nbsp&nbspWriter Resubmission Date&nbsp&nbsp</th>
	<tr>';
	
	$reviewStatus_query = "SELECT * FROM reviewStatus WHERE AssignedSubmissionId = '$submissionId' AND InterimStatusUpdate = 'reviewed'";
	$reviewStatus = mysqli_query($db, $reviewStatus_query);
	
	while ($row = mysqli_fetch_assoc($reviewStatus)){
		echo '<tr>';
			echo '<td>' . $row['AssignedReviewerEmail'] . '</td>';
			echo '<td>' . $row['ReviewerRecommendation'] . '</td>';
			echo '<td>' . $row['WriterFeedback'] . '</td>';
			echo '<td>' . $row['EditorFeedback'] . '</td>';
			echo '<td>' . $row['WritersResubmissionDate'] . '</td>';
		echo '</tr>';
	}
	
	echo '</table>';
	
	echo '<form method="post"';
	echo '<div class="input-group">
			<center>
			<button type="submit" style="width:140px; class="btn" name="accept" value = ' . $submissionId .'>Accept</button>
			<button type="submit" style="width:300px; class="btn" name="acceptMinorRevision" value = ' . $submissionId .'>Accept With Minor Revisions</button>
			<button type="submit" style="width:300px; class="btn" name="acceptMajorRevision" value = ' . $submissionId .'>Accept With Major Revisions</button>
			<button type="submit" style="width:140px; class="btn" name="reject" value = ' . $submissionId .'>Reject</button>
		</div>';
}

//handles the "accept" button on the evaluatePaper.php page
if (isset($_POST['accept'])){
	$submissionId = $_POST['accept'];
	
	$updateQuery = "UPDATE submissionProfile SET PaperStatus = 'accepted' WHERE submissionId = '$submissionId'";
	$update = mysqli_query($db,$updateQuery);
	
	header('location: editor.php');
}

//handles the "Accept With Minor Revisions" button on the evaluatePaper.php page
if (isset($_POST['acceptMinorRevision'])){
	$submissionId = $_POST['acceptMinorRevision'];
	
	$updateQuery = "UPDATE submissionProfile SET PaperStatus = 'acceptMinor' WHERE submissionId = '$submissionId'";
	$update = mysqli_query($db,$updateQuery);
	
	header('location: editor.php');
}

//handles the "Accept With Major Revisions" button on the evaluatePaper.php page
if (isset($_POST['acceptMajorRevision'])){
	$submissionId = $_POST['acceptMajorRevision'];
	
	$updateQuery = "UPDATE submissionProfile SET PaperStatus = 'acceptMajor' WHERE submissionId = '$submissionId'";
	$update = mysqli_query($db,$updateQuery);
	
	header('location: editor.php');
}

//handles the "Reject" button on the evaluatePaper.php page
if (isset($_POST['reject'])){
	$submissionId = $_POST['reject'];
	
	$updateQuery = "UPDATE submissionProfile SET PaperStatus = 'rejected' WHERE submissionId = '$submissionId'";
	$update = mysqli_query($db,$updateQuery);
	
	header('location: editor.php');
}

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

//handles the create a reviewer field on the editor page.
if (isset($_POST['createReviewer'])){
	$enteredEmail = $_POST['enteredEmail'];

	$valid_email_query = "SELECT * FROM userProfile WHERE email = '$enteredEmail'";
	$valid_email = mysqli_query($db, $valid_email_query);
	
	if (mysqli_num_rows($valid_email) == 0){
		array_push($errors, "This user does not exist");
	} else {
		$userProfile = mysqli_fetch_assoc($valid_email);
		if ($userProfile['userType'] == 'writer'){
			$update_type_query = "UPDATE userProfile SET userType = 'reviewer' WHERE email = '$enteredEmail'";
			$result = mysqli_query($db, $update_type_query);
			
			echo 'Succesfully assigned privileges';
		} else {
			array_push($errors, "This user already has reviewer privileges");
		}
	}
	
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
	
		$query = "INSERT INTO reviewStatus (AssignedSubmissionID, AssignedReviewerEmail, AssignedDeadlineReviewer, InterimStatusUpdate,WritersResubmissionDate) 
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