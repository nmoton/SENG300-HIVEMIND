   <?php

    //connect to DB
    $db = mysqli_connect('localhost', 'root', '', 'journal');

        if (isset($_POST['reviewPreference'])) 
        {
               $message = $_POST['reviewPreference'];
			   list($email, $submissionId) = explode("/", $message);  //splits the input string into components based on spaces

               //create a new entry in the reviewerSelection table 
               $user_check_query = "INSERT INTO reviewerSelection (reviewerEmail, submissionId) VALUES ('$email', '$submissionId')";

			   if ($db->query($user_check_query) === TRUE) 
			   {
					//echo "New record created successfully";
					echo "<b><center>Selection was successful</center></b>";
				} 
					
				else 
				{
					echo "Error: " . $sql . "<br>" . $db->error;
				}

               
               
        }
        

        ?>



 