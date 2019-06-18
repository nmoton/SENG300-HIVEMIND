<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

//Database Config
//These tests assume that the database is configured such that:
//There is not a user with email "Norm@gmail.com" in submissionProfile
//There is a user with email "joe@ucalgary.ca" in submissionProfile

final class userHandlerTest extends TestCase
{
	//tests a valid registration and whether fields in userProfile are updated properly
    public function testValidRegister(): void
    {
		$testEmail = "Norm@gmail.com";
		$testFirstName = "Norm";
		$testLastName = "Smith";
		$testInstitution = "University of American Samoa";
		
		$testArray['register'] = "set";
		$testArray['email'] = $testEmail;
		$testArray['firstName'] = $testFirstName;
		$testArray['lastName'] = $testLastName;
		$testArray['institution'] = $testInstitution;
		
		//manually sets $_POST
		$_POST = $testArray;
		
		include 'editorHandler.php';
		
		//the "include" already initializes the database connection
		$testQuery = "SELECT * FROM userProfile WHERE email = '$testEmail'";
		$testQueryResult = mysqli_query($db,$testQuery);
		$testQueryArray = mysqli_fetch_assoc($testQueryResult);
		
		$this->assertEquals(
            $testEmail,
            $testQueryArray['email'])
        );
		
		$this->assertEquals(
            $testFirstName,
            $testQueryArray['firstName'])
        );
		
		$this->assertEquals(
            $testLastName,
            $testQueryArray['lastName'])
        );
		
		$this->assertEquals(
            $testInstitution,
            $testQueryArray['institution'])
        );
    }

	//tests that a user trying to register with the email of a user who is already registered throws an error
	public function testInvalidRegister(): void
	{
		$testEmail = "joe@ucalgary.ca"
		
		$testArray['createReviewer'] = $testEmail;
		
		//manually sets $_POST
		$_POST = $testArray;
		
		include 'editorHandler.php';
		
		$this->assertNotEquals(
            0,
			//$errors is initialized in the include
            count($errors))
        );
	}
	
	
}