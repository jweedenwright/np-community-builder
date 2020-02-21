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
INSERT INTO dbo.volunteer (first_name,middle_name,last_name,suffix,email,phone,dob,address_id,emergency_contact_id,active) VALUES();
INSERT INTO dbo.volunteer (first_name,middle_name,last_name,suffix,email,phone,dob,address_id,emergency_contact_id,active) VALUES();
INSERT INTO dbo.volunteer (first_name,middle_name,last_name,suffix,email,phone,dob,address_id,emergency_contact_id,active) VALUES();
INSERT INTO dbo.volunteer (first_name,middle_name,last_name,suffix,email,phone,dob,address_id,emergency_contact_id,active) VALUES();
SET IDENTITY_INSERT dbo.volunteer OFF

INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES();
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES();
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES();
INSERT INTO dbo.address (volunteer_id, street_one,street_two,city,state,zip) VALUES();

INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES();
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES();
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES();
INSERT INTO dbo.emergency_contact (volunteer_id, first_name,last_name,phone) VALUES();

-- Setup Default admins
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('jeremiah.weedenwright@gmail.com','tester', '2020-02-20',1,1,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('iwilson0722@gmail.com','tester', '2020-02-20',1,2,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('Shalonda.Brown@bgcrc.net','tester', '2020-02-20',1,3,1);
INSERT INTO dbo.app_user (username, password, date_added, user_type_id, volunteer_id, active) VALUES ('recruitment@bgcrc.net','tester','2020-02-20',1,4,1);

SELECT * from dbo.location