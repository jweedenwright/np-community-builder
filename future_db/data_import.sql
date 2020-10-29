-- DATA IMPORT
SET IDENTITY_INSERT dbo.location ON
INSERT INTO dbo.location (id,location_name,active) VALUES (1,'Murfreesboro',1);
INSERT INTO dbo.location (id,location_name,active) VALUES (2,'Shelbyville',1);
INSERT INTO dbo.location (id,location_name,active) VALUES (3,'Smyrna',1);
SET IDENTITY_INSERT dbo.location OFF

SET IDENTITY_INSERT dbo.job_type ON
INSERT INTO dbo.job_type (id,job_type,active) VALUES (1,'General',1);
INSERT INTO dbo.job_type (id,job_type,active) VALUES (2,'Web / IT',1);
INSERT INTO dbo.job_type (id,job_type,active) VALUES (3,'One-Time Special Event',1);
INSERT INTO dbo.job_type (id,job_type,active) VALUES (4,'LRC (Learning Resource Center)',1);
INSERT INTO dbo.job_type (id,job_type,active) VALUES (5,'Kid&#39;s Cafe',1);
INSERT INTO dbo.job_type (id,job_type,active) VALUES (6,'Internship',1);
INSERT INTO dbo.job_type (id,job_type,active) VALUES (7,'Fundraiser',1);
INSERT INTO dbo.job_type (id,job_type,active) VALUES (8,'Teen Center',1);
INSERT INTO dbo.job_type (id,job_type,active) VALUES (9,'Gamesroom',1);
INSERT INTO dbo.job_type (id,job_type,active) VALUES (10,'Arts',1);
SET IDENTITY_INSERT dbo.job_type OFF

SET IDENTITY_INSERT dbo.user_type ON
INSERT INTO dbo.user_type (id,user_type) VALUES (1,'admin');
INSERT INTO dbo.user_type (id,user_type) VALUES (2,'staff');
INSERT INTO dbo.user_type (id,user_type) VALUES (3,'intern');
INSERT INTO dbo.user_type (id,user_type) VALUES (4,'volunteer');
SET IDENTITY_INSERT dbo.user_type OFF

-- Default Event for all regular volunteers
SET IDENTITY_INSERT dbo.event ON
INSERT INTO dbo.event (id,event_name,event_date) VALUES (1,'General','2020-01-01')
SET IDENTITY_INSERT dbo.event OFF

-- Setup Default volunteers
SET IDENTITY_INSERT dbo.volunteer ON
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active) VALUES(1,'Shalonda','','Brown','','Shalonda.Brown@bgcrc.net','615-111-1111','20000101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active) VALUES(2,'Chelsey','','Curtis','','recruitment@bgcrc.net','615-111-1111','20000101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active) VALUES(3,'Jeremiah','D','Weeden-Wright','','jeremiah.weedenwright@gmail.com','615-111-1111','20000101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active) VALUES(4,'Carson','','Kuhl','','Carson.Kuhl@hcahealthcare.com','615-111-1111','20000101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active) VALUES(5,'Emily','','Collins','','emily.collins@infoworks-tn.com','615-111-1111','20000101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active) VALUES(6,'Raja','','Karnati','','raja.karnati@hcahealthcare','615-111-1111','20000101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active) VALUES(7,'Adam','','Alvis','','aalvis@deloitte','615-111-1111','20000101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active) VALUES(8,'Kishan','','Patel','','kpatel@genospace','615-111-1111','20000101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active) VALUES(9,'Karla','','Ramirez','','kramirezmal@gmail','615-111-1111','20000101','','','','',1,1);
SET IDENTITY_INSERT dbo.volunteer OFF

-- Setup Addresses
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(1,'101 N 1st','','Nashville','TN','37215');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(2,'105 N 1st','','Nashville','TN','37215');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(3,'105 N 1st','','Nashville','TN','37215');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(4,'107 N 1st','','Nashville','TN','37215');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(5,'101 N 1st','','Nashville','TN','37215');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(6,'105 N 1st','','Nashville','TN','37215');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(7,'105 N 1st','','Nashville','TN','37215');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(8,'107 N 1st','','Nashville','TN','37215');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(9,'101 N 1st','','Nashville','TN','37215');

-- Setup Emergency Contacts
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(1,'Emergency','Contact','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(2,'Emergency','Contact','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(3,'Emergency','Contact','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(4,'Emergency','Contact','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(5,'Emergency','Contact','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(6,'Emergency','Contact','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(7,'Emergency','Contact','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(8,'Emergency','Contact','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(9,'Emergency','Contact','615-333-3333');

-- Setup Default admins
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('Shalonda.Brown@bgcrc.net','tester', '2020-10-16',1,1,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('recruitment@bgcrc.net','tester', '2020-10-16',1,2,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('jeremiah.weedenwright@gmail.com','tester', '2020-10-16',1,3,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('Carson.Kuhl@hcahealthcare.com','tester', '2020-10-16',1,4,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('emily.collins@infoworks-tn.com','tester', '2020-10-16',1,5,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('raja.karnati@hcahealthcare.com','tester', '2020-10-16',1,6,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('aalvis@deloitte.com','tester', '2020-10-16',1,7,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('kpatel@genospace.com','tester', '2020-10-16',1,8,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('kramirezmal@gmail.com','tester', '2020-10-16',1,9,1);
SELECT * from dbo.location

-- Insert Vol and Intern Data
SET IDENTITY_INSERT dbo.volunteer ON
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active) 
	VALUES(21,'Intern','','VonTern','','jeremiah.weedenwright+1@gmail.com','615-111-1111','20000101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active) 
	VALUES(22,'Volunteer','','McVol','','jeremiah.weedenwright+2@gmail.com','615-111-1111','20000101','','','','',1,1);
SET IDENTITY_INSERT dbo.volunteer OFF

-- Setup Addresses
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(21,'101 N 1st','','Nashville','TN','37215');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(22,'105 N 1st','','Nashville','TN','37215');

-- Setup Emergency Contacts
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(21,'Emergency','Contact','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(22,'Emergency','Contact','615-333-3333');

-- Setup Default admins
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('jeremiah.weedenwright+1@gmail.com','tester', '2020-10-16',3,21,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('jeremiah.weedenwright+2@gmail.com','tester', '2020-10-16',4,22,1);

-- Setup Volunteer Periods
-- 'Intern' Periods - 10/12 - 10/26
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-12 00:12:00.0', '2020-10-12 00:16:00.0', 4, NULL, 1, 1, 1, 0, 4, 1, 1, NULL, 21, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-13 00:11:30.0', '2020-10-12 00:16:00.0', 5.5, NULL, 1, 1, 1, 0, 4, 2, 1, NULL, 21, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-14 00:11:00.0', '2020-10-12 00:14:00.0', 3, NULL, 1, 1, 1, 0, 6, 2, 1, NULL, 21, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-15 00:12:30.0', '2020-10-12 00:14:30.0', 4, NULL, 1, 1, 1, 0, 6, 3, 1, NULL, 21, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-16 00:10:00.0', '2020-10-12 00:12:00.0', 2, NULL, 1, 1, 1, 0, 10, 3, 1, NULL, 21, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-17 00:12:00.0', '2020-10-12 00:16:00.0', 4, NULL, 1, 1, 1, 0, 4, 1, 1, NULL, 21, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-18 00:11:30.0', '2020-10-12 00:16:00.0', 5.5, NULL, 1, 1, 1, 0, 4, 2, 1, NULL, 21, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-19 00:11:00.0', '2020-10-12 00:14:00.0', 3, NULL, 1, 1, 1, 0, 6, 2, 1, NULL, 21, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-20 00:12:30.0', '2020-10-12 00:14:30.0', 4, NULL, 1, 1, 1, 0, 6, 3, 1, NULL, 21, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-21 00:10:00.0', '2020-10-12 00:12:00.0', 2, NULL, 1, 1, 1, 0, 10, 3, 1, NULL, 21, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-22 00:10:00.0', '2020-10-12 00:12:00.0', 2, NULL, 1, 1, 1, 0, 10, 3, 1, NULL, 21, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-23 00:11:30.0', '2020-10-12 00:16:00.0', 5.5, NULL, 1, 1, 1, 0, 4, 2, 1, NULL, 21, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-24 00:11:00.0', '2020-10-12 00:14:00.0', 3, NULL, 1, 1, 1, 0, 6, 2, 1, NULL, 21, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-25 00:12:30.0', '2020-10-12 00:14:30.0', 4, NULL, 1, 1, 1, 0, 6, 3, 1, NULL, 21, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-26 00:10:00.0', '2020-10-12 00:12:00.0', 2, NULL, 1, 1, 1, 0, 10, 3, 1, NULL, 21, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-27 00:10:00.0', '2020-10-12 00:12:00.0', 2, NULL, 1, 1, 1, 0, 10, 3, 1, NULL, 21, NULL);

-- 'Volunteer' Periods - 10/14 - 10/28
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-14 00:11:00.0', '2020-10-12 00:14:00.0', 3, NULL, 1, 1, 1, 0, 5, 1, 1, NULL, 22, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-15 00:12:30.0', '2020-10-12 00:14:30.0', 4, NULL, 1, 1, 1, 0, 5, 1, 1, NULL, 22, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-16 00:10:00.0', '2020-10-12 00:12:00.0', 2, NULL, 1, 1, 1, 0, 2, 1, 1, NULL, 22, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-17 00:12:00.0', '2020-10-12 00:16:00.0', 4, NULL, 1, 1, 1, 0, 2, 3, 1, NULL, 22, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-18 00:11:30.0', '2020-10-12 00:16:00.0', 5.5, NULL, 1, 1, 1, 0, 5, 1, 1, NULL, 22, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-19 00:11:00.0', '2020-10-12 00:14:00.0', 3, NULL, 1, 1, 1, 0, 5, 3, 1, NULL, 22, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-20 00:12:30.0', '2020-10-12 00:14:30.0', 4, NULL, 1, 1, 1, 0, 2, 2, 1, NULL, 22, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-21 00:10:00.0', '2020-10-12 00:12:00.0', 2, NULL, 1, 1, 1, 0, 2, 1, 1, NULL, 22, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-22 00:10:00.0', '2020-10-12 00:12:00.0', 2, NULL, 1, 1, 1, 0, 6, 1, 1, NULL, 22, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-23 00:11:30.0', '2020-10-12 00:16:00.0', 5.5, NULL, 1, 1, 1, 0, 6, 3, 1, NULL, 22, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-24 00:11:00.0', '2020-10-12 00:14:00.0', 3, NULL, 1, 1, 1, 0, 6, 3, 1, NULL, 22, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-25 00:12:30.0', '2020-10-12 00:14:30.0', 4, NULL, 1, 1, 1, 0, 2, 1, 1, NULL, 22, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-26 00:10:00.0', '2020-10-12 00:12:00.0', 2, NULL, 1, 1, 1, 0, 10, 1, 1, NULL, 22, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-27 00:10:00.0', '2020-10-12 00:12:00.0', 2, NULL, 1, 1, 1, 0, 10, 2, 1, NULL, 22, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-28 00:12:00.0', '2020-10-12 00:16:00.0', 4, NULL, 1, 1, 1, 0, 3, 2, 1, NULL, 22, NULL);
INSERT INTO dbo.volunteer_period
(check_in_time, check_out_time, hours, affiliation, health_release, photo_release, liability_release, first_time, job_type_id, location_id, event_id, community_service_hours, volunteer_id, feedback_id)
	VALUES('2020-10-29 00:11:30.0', '2020-10-12 00:16:00.0', 5.5, NULL, 1, 1, 1, 0, 3, 1, 1, NULL, 22, NULL);