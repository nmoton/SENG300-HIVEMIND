CREATE DATABASE journal;
USE journal;

-- userProfile: collecting information from user when they register 
-- user can select whether they are reviewer, editor or writer 
-- it is assumed that if one is reviewer, editor will check this manually to ensure its a valid entry 
-- it is assumed that if one is editor then another editor will perform verification
-- Options for userType: "writer", "reviewer", "editor"
DROP TABLE IF EXISTS userProfile;
CREATE TABLE userProfile
(
	email varchar(225) NOT NULL PRIMARY KEY,
    userType varchar(225) DEFAULT "writer",
	institution varchar(225) NOT NULL,
	firstName varchar(225) NOT NULL,
	lastName varchar(225) NOT NULL,
	password varchar(255) NOT NULL

);

-- adding some sample items - will remove later 
INSERT INTO userProfile (email, userType, institution, firstName, lastName, password) Values("Joe@hotmail.com", "writer", "sample institution", "Joe", "Brown", "5f4dcc3b5aa765d61d8327deb882cf99");
INSERT INTO userProfile (email, userType, institution, firstName, lastName, password) Values("pankti@gmail.com", "writer", "Univeristy of Calgary", "Pankti", "Shah", "63c38a18845e2286ba5b778e3d1308d");
INSERT INTO userProfile (email, userType, institution, firstName, lastName, password) Values("Tom@ucalgary.ca", "reviewer", "sample institution", "Tom", "Smith", "5f4dcc3b5aa765d61d8327deb882cf99");
INSERT INTO userProfile (email, userType, institution, firstName, lastName, password) Values("Ed@gmail.com", "editor", "sample institution", "Ed", "Johnson", "5f4dcc3b5aa765d61d8327deb882cf99");
INSERT INTO userProfile (email, userType, institution, firstName, lastName, password) Values("Glen@ucalgary.ca", "reviewer", "University of Calgary", "Glen", "Adams", "5f4dcc3b5aa765d61d8327deb882cf99");
INSERT INTO userProfile (email, userType, institution, firstName, lastName, password) Values("Todd@ucalgary.ca", "reviewer", "University of Calgary", "Todd", "Haines", "5f4dcc3b5aa765d61d8327deb882cf99");


-- when a writer submits a paper 
-- when writer withdraws a paper, remove its entry from this table
-- when writer resubmits a paper then simply update the pdfSubmission field and update date of submission so editor can assign a new deadline for reviewer 
-- Options for PaperStatus: "submitted", "underReview"
-- numReviewers is the Number of reviewers currently assigned to this paper
DROP TABLE IF EXISTS submissionProfile;
CREATE TABLE submissionProfile
(
	submissionId int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	paperTitle varchar(225) NOT NULL UNIQUE,
	email varchar(225) NOT NULL,
	topic varchar(225) NOT NULL,
	authors varchar(225) NOT NULL,
	pdfSubmission text NOT NULL,
	PaperStatus varchar(225) NOT NULL,
	dateOfSubmission date NOT NULL, 
	numReviewers int DEFAULT 0, 
	reviewerPreference1 varchar(225),
	reviewerPreference2 varchar(225),
	reviewerPreference3 varchar(225)
);

INSERT INTO submissionProfile (paperTitle, email, topic, pdfSubmission, PaperStatus,dateOfSubmission, reviewerPreference1, reviewerPreference2) Values("Effect of Routing Algorithms on Network Efficiency", "EduardoPicatto@UCalgary.ca", "Networking", "sample text", "submitted", "2019-2-2", "Ed Johnson", "Tom Smith");
INSERT INTO submissionProfile (paperTitle, email, topic, pdfSubmission, PaperStatus,dateOfSubmission, reviewerPreference1) Values("Algorithmic Complexity Analysis of Matrix Multiplication", "EduardoPicatto@UCalgary.ca", "Algorithmics", "sample text", "submitted", "2019-2-3", "Ed Johnson");



-- Table for reviewer and writer 
-- a reviewer can select as many papers as they want/are interested in reviewing 

DROP TABLE IF EXISTS reviewerSelection;
CREATE TABLE reviewerSelection
(
	reviewerEmail varchar(225) NOT NULL,	
	paperTitle varchar(225) NOT NULL,
	submissionId varchar(225) NOT NULL
);


-- Reviewer, writer and editor 
-- Here, 
-- Editor role: 
           -- editor will assign a paper to reviewer. Editor will need to add ID of the paper, add reviewer's name, enter their own username (assuming there can be multiple editors), 
           -- assign deadline
-- Reviewer role:
            -- Add feedback for writer
            -- update intrim status for editor (empty, accept with major revision, accept with minor revision, reject)
-- When reviewer updates the intrim status, editor will be able to assign deadline to writers for resubmission

DROP TABLE IF EXISTS reviewStatus;
CREATE TABLE reviewStatus
(
	AssignedSubmissionID int NOT NULL,
	AssignedReviewerEmail varchar(225) NOT NULL,
	AssignedDeadlineReviewer date NOT NULL,
	ReviewerFeedback text,
	InterimStatusUpdate varchar(225) NOT NULL,
	WritersResubmissionDate date NOT NULL
);

INSERT INTO reviewStatus (AssignedSubmissionID, AssignedReviewerEmail, AssignedDeadlineReviewer, ReviewerFeedback, InterimStatusUpdate, WritersResubmissionDate) Values(1, "Todd@ucalgary.ca", "2019-2-3", "review text", "submitted", "2019-2-3");
INSERT INTO reviewStatus (AssignedSubmissionID, AssignedReviewerEmail, AssignedDeadlineReviewer, ReviewerFeedback, InterimStatusUpdate, WritersResubmissionDate) Values(2, "jane@gmail.com", "2019-2-6", "review text", "submitted", "2019-2-18");
