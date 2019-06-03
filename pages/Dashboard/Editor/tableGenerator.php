<?php
//This class generates a the cells for the table in editor.php

$db = mysqli_connect('localhost', 'root', '', 'journal');

$paperQuery = "SELECT * FROM submissionProfile WHERE PaperStatus='Submitted'";
$result = mysqli_query($db, $paperQuery);
	
	//generate cell information from DB
	while ($row = mysqli_fetch_assoc($result)){
		echo '<tr>';
			echo '<td>' . $row['submissionId'] . '</td>';
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