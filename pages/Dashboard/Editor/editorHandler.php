<?php

//initialize error log (use for debugging). Ex;
//error_log(mysqli_error($db)); 
//prints the last sql query error to phpError.log
ini_set("log_errors", 1);
ini_set("error_log", "writerHandlerError.log");

//create db link
$db = mysqli_connect('localhost', 'root', '', 'journal');

$paperQuery = "SELECT * FROM submissionProfile WHERE PaperStatus='Submitted'";
$result = mysqli_query($db, $paperQuery);
	
echo '
	<table>
	<tr>
		<th>Title</th>
		<th>Submitter Email</th>
		<th>Topic</th>
		<th>Status</th>
		<th>Date</th>
		<th>Reviewer Preference 1</th>
		<th>Reviewer Preference 2</th>
		<th>Reviewer Preference 3</th>
	<tr>';
	
	while ($row = mysqli_fetch_assoc($result)){
		echo '<tr>';
			echo '<td>' . $row['paperTitle'] . '</td>';
			echo '<td>' . $row['email'] . '</td>';
			echo '<td>' . $row['topic'] . '</td>';
			echo '<td>' . $row['PaperStatus'] . '</td>';
			echo '<td>' . $row['dateOfSubmission'] . '</td>';
			echo '<td>' . $row['reviewerPreference1'] . '</td>';
			echo '<td>' . $row['reviewerPreference2'] . '</td>';
			echo '<td>' . $row['reviewerPreference3'] . '</td>';
		echo '</tr>';
	}
	
	echo '<table>';
?>