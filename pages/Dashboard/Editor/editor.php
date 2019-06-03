<!DOCTYPE html>

<html lang="en">
	<head>
		<title>Dashboard</title>
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="description" content="Registration Page for Hive Mind">
		<meta name="author" content="Nathan Moton">

    	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    	<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    	<link href="https://fonts.googleapis.com/css?family=Montserrat:500&display=swap" rel="stylesheet">
    	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    	<link href="../css/global.css" rel="stylesheet" media="screen">
    	<link href="../css/signup.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" href="stylesheet.css">
	</head>


  <body> 
  <!-- add a logo --> 
  <div class = "logo"><a href = ""><img src = """ style="width:5%"></a>
  </div>
  
  <!-- Navigation -->
  <div class="topnav">
    <div class="topnav-right">
      <a href="dashboard.php">Dashboard</a>
      <a href="writer.php">Writer</a>
      <a href="reviewer.php">Reviewer</a>
      <a href="editor.php">Editor</a>
      <a href="login.php">Sign-out</a>
    </div>
  </div>
 
 	<!--Generate columns -->
  	<table>
	<tr>
		<th>Submission ID</th>
		<th>Title</th>
		<th>Submitter Email</th>
		<th>Topic</th>
		<th>Status</th>
		<th>Date</th>
		<th>Reviewer Preference 1</th>
		<th>Reviewer Preference 2</th>
		<th>Reviewer Preference 3</th>
		<th></th>
	<tr>
	<!--Generate cells -->
	<?php 
		include 'tableGenerator.php';
	?>
	
	
	<br>
		<b><h2><center> Assign a Reviewer </center></h2></b>
	<br>	
	
	<form method="post">
	  	<?php 
			include 'editorHandler.php';
			include '../../../errors/errors.php';
		?>
		<div class="input-group">
			<label>Enter the submission ID of the paper you want to assign a reviewer to</label>
			<input type="text" name="submissionId">
		</div>
		<div class="input-group">
			<label>Enter the E-mail of the reviewer</label>
			<input type="text" name="email">
		</div>
			<div class="input-group">
			<label>Enter the review deadline</label>
			<input type="date" name="reviewDeadline">
		</div>
			</div>
			<div class="input-group">
			<label>Enter the resubmission deadline</label>
			<input type="date" name="resubmissionDeadline">
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="addReviewer">Add</button>
		</div>
	</form>

  
	
		<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="crossorigin="anonymous"></script>
    	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
	</body>