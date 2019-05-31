CREATE DATABASE journal;
USE journal;

-- Table 1: collecting information from user when they register 
-- user can select whether they are reviewer, editor or writer 
-- it is assumed that if one is reviewer, editor will check this manually to ensure its a valid entry 
-- it is assumed that if one is editor then another editor will perform verification

DROP TABLE IF EXISTS Table1;
CREATE TABLE Table1
(
	
	email varchar(225) NOT NULL PRIMARY KEY,
    userType varchar(225) DEFAULT "Writer",
	institution varchar(225) NOT NULL,
	firstName varchar(225) NOT NULL,
	lastName varchar(225) NOT NULL,
	password varchar(255) NOT NULL

);

-- adding some sample items - will remove later 
INSERT INTO Table1 (email, userType, institution, firstName, lastName, password) Values("Joe@hotmail.com", "writer", "sample institution", "sample firstName", "sample lastName", "5f4dcc3b5aa765d61d8327deb882cf99");
INSERT INTO Table1 (email, userType, institution, firstName, lastName, password) Values("Tom@ucalgary.ca", "reviewer", "sample institution", "sample firstName", "sample lastName", "5f4dcc3b5aa765d61d8327deb882cf99");
INSERT INTO Table1 (email, userType, institution, firstName, lastName, password) Values("Ed@gmail.com", "editor", "sample institution", "sample firstName", "sample lastName", "5f4dcc3b5aa765d61d8327deb882cf99");


-- when a writer submits a paper 
-- when writer withdraws a paper, remove its entry from this table
-- when writer resubmits a paper then simply update the pdfSubmission field and update date of submission so editor can assign a new deadline for reviewer 

DROP TABLE IF EXISTS Table2;
CREATE TABLE Table2
(
	submissionId int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	paperTitle varchar(225) NOT NULL UNIQUE,
	email varchar(225) NOT NULL,
	FOREIGN KEY (email) REFERENCES Table1(email),
	topic varchar(225) NOT NULL,
	authors varchar(225) NOT NULL,
	pdfSubmission text NOT NULL,
	PaperStatus varchar(225) NOT NULL,
	dateOfSubmission date NOT NULL, 
	reviewerPreference1 varchar(225),
	reviewerPreference2 varchar(225),
	reviewerPreference3 varchar(225)
);


-- Table for reviewer and writer 
-- a reviewer can select as many papers as they want/are interested in reviewing 

DROP TABLE IF EXISTS Table3;
CREATE TABLE Table3
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

DROP TABLE IF EXISTS Table4;
CREATE TABLE Table4
(
	AssignedSubmissionID int NOT NULL PRIMARY KEY,
	AssignedReviewerEmail varchar(225) NOT NULL,
	AssignedEditorEmail varchar(225) NOT NULL,
	AssignedDeadlineReviewer date NOT NULL,
	ReviewerFeedback text,
	IntrimStatusUpdate varchar(225) NOT NULL,
	WritersResubDead date NOT NULL

);