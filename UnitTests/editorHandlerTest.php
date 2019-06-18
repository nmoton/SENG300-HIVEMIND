<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

//Database Config
//These tests assume that the database is configured such that:
//There is a submission with submissionId 1 in the database
//"joe@ucalgary.ca" is a the email of a user in submissionProfile 
//"paul@ucalgary.ca is not the email of a user in submissionProfile

final class editorHandlerTest extends TestCase
{
	//These tests test thisQuarter() in editorHandler
    public function testThisQuarter1(): void
    {
        $this->assertEquals(
            'false',
            thisQuarter(1))
        );
    }

    public function testThisQuarter2(): void
    {
        $this->assertEquals(
            'false',
            thisQuarter(3))
        );
    }
	
	public function testThisQuarter3(): void
    {
        $this->assertEquals(
            'true',
            thisQuarter(4))
        );
    }
	
	public function testThisQuarter4(): void
    {
        $this->assertEquals(
            'true',
            thisQuarter(5))
        );
    }
	
	public function testThisQuarter5(): void
    {
        $this->assertEquals(
            'true',
            thisQuarter(6))
        );
    }
	
	public function testThisQuarter6(): void
    {
        $this->assertEquals(
            'false',
            thisQuarter(8))
        );
    }
	
	public function testThisQuarter7(): void
    {
        $this->assertEquals(
            'false',
            thisQuarter(10))
        );
    }
	
	public function testThisQuarter8(): void
    {
        $this->assertEquals(
            'false',
            thisQuarter(12))
        );
    }
	
	
	
	
	//Tests valid/invalid input for the editor assigning reviewer status

	//Tests if the userType in userProfile is assigned properly to "reviewer" on a valid input
	public function testCreateReviewer(): void
	{
		$testEmail = "joe@ucalgary.ca"
		
		$testArray['createReviewer'] = $testEmail;
		
		//manually sets $_POST
		$_POST = $testArray;
		
		include 'editorHandler.php';
		
		//the "include" already initializes the database connection
		$testQuery = "SELECT * FROM userProfile WHERE email = '$testEmail'";
		$testQueryResult = mysqli_query($db,$testQuery);
		$testQueryArray = mysqli_fetch_assoc($testQueryResult);
		$userType = $testQueryArray['userType'];
		
		$this->assertEquals(
            'reviewer',
            $usertype)
        );
	}
	
	//Tests if there is a mysqli error thrown when an invalid input is entered
	public function testCreateInvalidReviewer(): void
	{
		$testEmail = "paul@ucalgary.ca"
		
		$testArray['createReviewer'] = $testEmail;
		
		//manually sets $_POST
		$_POST = $testArray;
		
		include 'editorHandler.php';
		
		//the "include" already initializes the database connection
		$testQuery = "SELECT * FROM userProfile WHERE email = '$testEmail'";
		$testQueryResult = mysqli_query($db,$testQuery);
		
		$this->assertEquals(
            0,
            $testQueryResult)
        );
	}
	
	
	
	
	
	//These tests test whether editor evaluations are assigned properly in the database
	
	//Tests accept
	public function testAccept(): void
	{
		$testID = "1"
		
		$testArray['accept'] = $testID;
		
		//manually sets $_POST
		$_POST = $testArray;
		
		include 'editorHandler.php';
		
		//the "include" already initializes the database connection
		$testQuery = "SELECT * FROM submissionProfile WHERE submissonId = '$testID'";
		$testQueryResult = mysqli_query($db,$testQuery);
		$testQueryArray = mysqli_fetch_assoc($testQueryResult);
		$paperStatus = $testQueryArray['PaperStatus'];
		
		$this->assertEquals(
            'accepted',
            $paperStatus)
        );
	}
	
	
	//Tests accept with minor revisions
	public function testMinorRevisions(): void
	{
		$testID = "1"
		
		$testArray['acceptMinorRevision'] = $testID;
		
		//manually sets $_POST
		$_POST = $testArray;
		
		include 'editorHandler.php';
		
		//the "include" already initializes the database connection
		$testQuery = "SELECT * FROM submissionProfile WHERE submissonId = '$testID'";
		$testQueryResult = mysqli_query($db,$testQuery);
		$testQueryArray = mysqli_fetch_assoc($testQueryResult);
		$paperStatus = $testQueryArray['PaperStatus'];
		
		$this->assertEquals(
            'acceptMinor',
            $paperStatus)
        );
	}
	
	//Tests accept with major revisions
	public function testMajorRevisions(): void
	{
		$testID = "1"
		
		$testArray['acceptMajorRevision'] = $testID;
		
		//manually sets $_POST
		$_POST = $testArray;
		
		include 'editorHandler.php';
		
		//the "include" already initializes the database connection
		$testQuery = "SELECT * FROM submissionProfile WHERE submissonId = '$testID'";
		$testQueryResult = mysqli_query($db,$testQuery);
		$testQueryArray = mysqli_fetch_assoc($testQueryResult);
		$paperStatus = $testQueryArray['PaperStatus'];
		
		$this->assertEquals(
            'acceptMajor',
            $paperStatus)
        );
	}
	
	//Tests reject
	public function testReject(): void
	{
		$testID = "1"
		
		$testArray['reject'] = $testID;
		
		//manually sets $_POST
		$_POST = $testArray;
		
		include 'editorHandler.php';
		
		//the "include" already initializes the database connection
		$testQuery = "SELECT * FROM submissionProfile WHERE submissonId = '$testID'";
		$testQueryResult = mysqli_query($db,$testQuery);
		$testQueryArray = mysqli_fetch_assoc($testQueryResult);
		$paperStatus = $testQueryArray['PaperStatus'];
		
		$this->assertEquals(
            'reject',
            $paperStatus)
        );
	}
	
}
