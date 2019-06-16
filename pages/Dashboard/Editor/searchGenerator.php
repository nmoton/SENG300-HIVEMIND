<?php
//This class generates a the cells for the search results in editor.php

$db = mysqli_connect('localhost', 'root', '', 'journal');

if (isset($_POST['searchButton'])){
	$search_value = $_POST['search'];
	
	error_log($search_value);

	$searchQuery = "SELECT * FROM submissionProfile WHERE paperTitle LIKE '%$search_value%' OR email LIKE '%$search_value%' OR topic LIKE '%$search_value%' OR authors LIKE '%$search_value%'";
	$result = mysqli_query($db, $searchQuery);

	//generate cell information from DB
	while ($row = mysqli_fetch_assoc($result)){
		echo '<tr>';
			echo '<td>' . $row['submissionId'] . '</td>';
			echo '<td>' . $row['paperTitle'] . '</td>';
			echo '<td>' . $row['email'] . '</td>';
			echo '<td>' . $row['topic'] . '</td>';
			echo '<td>' . $row['PaperStatus'] . '</td>';
			echo '<td>' . $row['dateOfSubmission'] . '</td>';
			echo '<td><button type="submit" style="width:130px;" name= "viewPaper" value =' . $row['submissionId'] . '">View Paper</button></td>';
		echo '</tr>';
	}
	echo '<table>';
}
?>