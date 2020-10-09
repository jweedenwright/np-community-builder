-- DATA IMPORT
SET IDENTITY_INSERT dbo.location ON
INSERT INTO dbo.location (id,location_name,active) VALUES (1,'Murfreesboro',1);
INSERT INTO dbo.location (id,location_name,active) VALUES (2,'Shelbyville',1);
INSERT INTO dbo.location (id,location_name,active) VALUES (3,'Smyrna',1);
SET IDENTITY_INSERT dbo.location OFF

SET IDENTITY_INSERT dbo.job_type ON
INSERT INTO dbo.job_type (id,job_type,active) VALUES (1,'General',1);
INSERT INTO dbo.job_type (id,job_type,active) VALUES (2,'Web / IT',1);
SET IDENTITY_INSERT dbo.job_type OFF

SET IDENTITY_INSERT dbo.user_type ON
INSERT INTO dbo.user_type (id,user_type) VALUES (1,'admin');
INSERT INTO dbo.user_type (id,user_type) VALUES (2,'staff');
INSERT INTO dbo.user_type (id,user_type) VALUES (3,'intern');
INSERT INTO dbo.user_type (id,user_type) VALUES (4,'volunteer');
SET IDENTITY_INSERT dbo.user_type OFF

-- Setup Default volunteers
SET IDENTITY_INSERT dbo.volunteer ON
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active) VALUES(1,'Shalonda','','Brown','','Shalonda.Brown@bgcrc.net','615-111-1111','20000101','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active) VALUES(3,'Jeremiah','D','Weeden-Wright','','jeremiah.weedenwright@gmail.com','206-356-4502','19820613','','','','',1,1);
INSERT INTO dbo.volunteer (id,first_name,middle_name,last_name,suffix,email,phone,dob,skills,interests,availability,find_out_about_us,include_email_dist,active) VALUES(4,'Ian','','Wilson','','iwilson0722@gmail.com','615-111-1111','20000101','','','','',1,1);
SET IDENTITY_INSERT dbo.volunteer OFF

INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(1,'101 N 1st','','Nashville','TN','37215');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(3,'105 N 1st','','Nashville','TN','37215');
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES(4,'107 N 1st','','Nashville','TN','37215');

INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(1,'Emergency','Contact','615-333-3333');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(3,'Stephanie','Weeden-Wright','206-225-1010');
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES(4,,'Emergency','Contact','615-333-3333');

-- Setup Default admins
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('Shalonda.Brown@bgcrc.net','tester', '2020-02-20',1,1,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('jeremiah.weedenwright@gmail.com','tester', '2020-02-20',1,3,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('iwilson0722@gmail.com','tester', '2020-02-20',1,4,1);

SELECT * from dbo.location