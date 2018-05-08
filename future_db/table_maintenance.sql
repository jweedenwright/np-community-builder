-- Drop Tables to Start
IF OBJECT_ID('dbo.volunteer_period', 'U') IS NOT NULL DROP TABLE dbo.volunteer_period
IF OBJECT_ID('dbo.feedback', 'U') IS NOT NULL DROP TABLE dbo.feedback
IF OBJECT_ID('dbo.volunteer', 'U') IS NOT NULL DROP TABLE dbo.volunteer
IF OBJECT_ID('dbo.metric', 'U') IS NOT NULL DROP TABLE dbo.metric
IF OBJECT_ID('dbo.app_user', 'U') IS NOT NULL DROP TABLE dbo.app_user
IF OBJECT_ID('dbo.program', 'U') IS NOT NULL DROP TABLE dbo.program
IF OBJECT_ID('dbo.metric_category', 'U') IS NOT NULL DROP TABLE dbo.metric_category
IF OBJECT_ID('dbo.metric_name', 'U') IS NOT NULL DROP TABLE dbo.metric_name
IF OBJECT_ID('dbo.measure_type', 'U') IS NOT NULL DROP TABLE dbo.measure_type
IF OBJECT_ID('dbo.job_type', 'U') IS NOT NULL DROP TABLE dbo.job_type
IF OBJECT_ID('dbo.location', 'U') IS NOT NULL DROP TABLE dbo.location

-- Create Tables
CREATE TABLE dbo.job_type (
	id int NOT NULL IDENTITY(1,1),
	job_type varchar(100) NOT NULL,
	active bit NOT NULL DEFAULT(1),
	CONSTRAINT PK_job_type PRIMARY KEY (id)
)
CREATE UNIQUE INDEX UQ_job_type ON dbo.job_type (job_type)

CREATE TABLE dbo.location (
	id int NOT NULL IDENTITY(1,1),
	location_name varchar(100) NOT NULL,
	delivery BIT NOT NULL DEFAULT(0),
	internal BIT NOT NULL DEFAULT(0),
	active bit NOT NULL DEFAULT(1),
	CONSTRAINT PK_location PRIMARY KEY (id)
)
CREATE UNIQUE INDEX UQ_location_name ON dbo.location (location_name)

CREATE TABLE dbo.volunteer (
	id int NOT NULL IDENTITY(1,1),
	first_name varchar(100) NOT NULL,
	last_name varchar(100) NOT NULL,
	email varchar(255) NOT NULL,
	skills varchar(8000) NULL,
	emergency_contact_phone varchar(45) NULL,
	interests varchar(8000) NULL,
	availability varchar(255) NULL,
	find_out_about_us varchar(255) NULL,
	include_email_dist bit NULL,
	active bit NOT NULL DEFAULT(1),
	CONSTRAINT PK_volunteer PRIMARY KEY (id)
)
CREATE UNIQUE INDEX UQ_volunteer_email ON dbo.volunteer (email)

CREATE TABLE dbo.feedback (
	id int NOT NULL IDENTITY(1,1),
	volunteer_id int NULL,
	feedback varchar(8000) NULL,
	CONSTRAINT PK_feedback PRIMARY KEY (id),
	CONSTRAINT FK_feedback_volunteer FOREIGN KEY (volunteer_id) REFERENCES dbo.volunteer(id) ON DELETE NO ACTION ON UPDATE NO ACTION
)

CREATE TABLE dbo.volunteer_period (
	id int NOT NULL IDENTITY(1,1),
	check_in_time datetime NOT NULL,
	check_out_time datetime NULL DEFAULT (NULL),
	hours decimal(3,1) NULL DEFAULT (NULL),
	affiliation varchar(100) NULL DEFAULT (NULL),
	health_release int NOT NULL,
	photo_release int NOT NULL,
	liability_release int NOT NULL,
	first_time int NOT NULL,
	job_type_id int NOT NULL,
	location_id int NOT NULL,
	community_service_hours int NULL DEFAULT (NULL),
	volunteer_id int NOT NULL,
	feedback_id int NULL,
	CONSTRAINT PK_volunteer_period PRIMARY KEY (id),
	CONSTRAINT FK_volunteer_period_jobtype FOREIGN KEY (job_type_id) REFERENCES dbo.job_type(id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT FK_volunteer_period_location FOREIGN KEY (location_id) REFERENCES dbo.location(id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT FK_volunteer_period_volunteer FOREIGN KEY (volunteer_id) REFERENCES dbo.volunteer(id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT FK_volunteer_period_feedback FOREIGN KEY (feedback_id) REFERENCES dbo.feedback(id) ON DELETE CASCADE ON UPDATE CASCADE
)

-- NEW TABLES
CREATE TABLE dbo.metric_category (
	id int NOT NULL IDENTITY(1,1),
	metric_category varchar(100) NOT NULL,
	CONSTRAINT PK_metric_category PRIMARY KEY (id)
)
CREATE UNIQUE INDEX UQ_metric_category ON dbo.metric_category (metric_category)

CREATE TABLE dbo.measure_type (
	id int NOT NULL IDENTITY(1,1),
	measure_type varchar(100) NOT NULL,
	measure_data_type varchar(50) NOT NULL,
	CONSTRAINT PK_measure_type PRIMARY KEY (id)
)
CREATE UNIQUE INDEX UQ_measure_type ON dbo.measure_type (measure_type)

CREATE TABLE dbo.metric (
	id int NOT NULL IDENTITY(1,1),
	metric_name varchar(100) NOT NULL,
	metric_category_id int NOT NULL,
	measure_type_id int NOT NULL,
	CONSTRAINT FK_metric_metric_category FOREIGN KEY (metric_category_id) REFERENCES dbo.metric_category(id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT FK_metric_measure_type FOREIGN KEY (measure_type_id) REFERENCES dbo.measure_type(id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT PK_metric PRIMARY KEY (id)
)
CREATE UNIQUE INDEX UQ_metric ON dbo.metric (metric_name)

CREATE TABLE dbo.program (
	id int NOT NULL IDENTITY(1,1),
	program varchar(100) NOT NULL,
	active bit NOT NULL DEFAULT(1),
	CONSTRAINT PK_program PRIMARY KEY (id)
)
CREATE UNIQUE INDEX UQ_program ON dbo.program (program)

-- USER TABLE
CREATE TABLE dbo.app_user (
	id int NOT NULL IDENTITY(1,1),
	username varchar(200) NOT NULL,
	password varchar(200) NOT NULL,
	date_added datetime NOT NULL,
	reset_id varchar(200) NULL,
	is_admin bit NOT NULL,
	active bit NOT NULL DEFAULT(1),
	CONSTRAINT PK_app_user PRIMARY KEY(id)
)
CREATE UNIQUE INDEX UQ_users ON dbo.app_user (username)

-- NEW METRIC ENTRY TABLE TO HANDLE LOGGED METRICS
CREATE TABLE dbo.metric_entry (
	id int NOT NULL IDENTITY(1,1),
	timestamp datetime NOT NULL,
	metric_id int NOT NULL,
	location_id int NULL,
	program_id int NULL,
	app_user_id int NOT NULL,
	value varchar(200) NOT NULL,
	CONSTRAINT PK_metric_entry PRIMARY KEY (id),
	CONSTRAINT FK_metric_entry_metric FOREIGN KEY (metric_id) REFERENCES dbo.metric(id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT FK_metric_entry_location FOREIGN KEY (location_id) REFERENCES dbo.location(id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT FK_metric_entry_program FOREIGN KEY (program_id) REFERENCES dbo.program(id) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT FK_metric_entry_app_user FOREIGN KEY (app_user_id) REFERENCES dbo.app_user(id) ON DELETE CASCADE ON UPDATE CASCADE
) 

-- DATA IMPORT
INSERT INTO dbo.app_user (username, password, date_added, is_admin, active) VALUES ('jeremiah.weedenwright@gmail.com','tester', '2016-12-05',1, 1);
INSERT INTO dbo.app_user (username, password, date_added, is_admin, active) VALUES ('mcallaro88@gmail.com','tester', '2018-04-12',1, 1);
INSERT INTO dbo.app_user (username, password, date_added, is_admin, active) VALUES ('divya.guntu@hcahealthcare.com','tester', '2018-04-12',1, 1);
INSERT INTO dbo.app_user (username, password, date_added, is_admin, active) VALUES ('teri@thenashvillefoodproject.org','tester','2018-04-12',1, 1);
INSERT INTO dbo.app_user (username, password, date_added, is_admin, active) VALUES ('munderwood@c3-consult.com','tester','2018-04-12',1, 1);
INSERT INTO dbo.app_user (username, password, date_added, is_admin, active) VALUES ('justin.threlkeld@gmail.com','tester','2018-04-12',1, 1);
INSERT INTO dbo.app_user (username, password, date_added, is_admin, active) VALUES ('joyce.pfeffer@hcahealthcare.com','tester','2018-04-12',1, 1);
INSERT INTO dbo.app_user (username, password, date_added, is_admin, active) VALUES ('mariah@thenashvillefoodproject.org','tester','2018-04-12',1, 1);
INSERT INTO dbo.app_user (username, password, date_added, is_admin, active) VALUES ('malinda@thenashvillefoodproject.org','tester','2018-04-12',1, 1);

SET IDENTITY_INSERT dbo.location ON
INSERT INTO dbo.location (id,location_name,delivery,internal,active) VALUES (1,'Blackman Road Garden',0,0,1);
INSERT INTO dbo.location (id,location_name,delivery,internal,active) VALUES (2,'Haywood Lane Garden',0,0,1);
INSERT INTO dbo.location (id,location_name,delivery,internal,active) VALUES (5,'McGruder Garden',0,0,1);
INSERT INTO dbo.location (id,location_name,delivery,internal,active) VALUES (4,'South Hall Kitchen',0,0,1);
INSERT INTO dbo.location (id,location_name,delivery,internal,active) VALUES (6,'St Luke''s Kitchen',0,0,1);
INSERT INTO dbo.location (id,location_name,delivery,internal,active) VALUES (7,'Wedgewood Garden',0,0,1);
INSERT INTO dbo.location (id,location_name,delivery,internal,active) VALUES (3,'Woodmont Garden',0,0,1);
INSERT INTO dbo.location (id,location_name,delivery,internal,active) VALUES (9,'Fall Hamilton',0,1,1);
INSERT INTO dbo.location (id,location_name,delivery,internal,active) VALUES (10,'Cottage Cove',0,1,1);
INSERT INTO dbo.location (id,location_name,delivery,internal,active) VALUES (11,'Harvest Hands',0,1,1);
INSERT INTO dbo.location (id,location_name,delivery,internal,active) VALUES (12,'Wedgewood Garden Neighbors',0,1,1);
SET IDENTITY_INSERT dbo.location OFF

SET IDENTITY_INSERT dbo.job_type ON
INSERT INTO dbo.job_type (id,job_type,active) VALUES (1,'Cook',1);
INSERT INTO dbo.job_type (id,job_type,active) VALUES (3,'Delivery',1);
INSERT INTO dbo.job_type (id,job_type,active) VALUES (4,'Garden',1);
INSERT INTO dbo.job_type (id,job_type,active) VALUES (11,'Gleaning',1);
INSERT INTO dbo.job_type (id,job_type,active) VALUES (2,'Meal Prep',1);
INSERT INTO dbo.job_type (id,job_type,active) VALUES (5,'Other',1);
INSERT INTO dbo.job_type (id,job_type,active) VALUES (21,'Web / IT',1);
SET IDENTITY_INSERT dbo.job_type OFF

SET IDENTITY_INSERT dbo.metric_category ON
INSERT INTO dbo.metric_category (id,metric_category) VALUES (1,'Meals')
INSERT INTO dbo.metric_category (id,metric_category) VALUES (2,'Garden')
SET IDENTITY_INSERT dbo.metric_category OFF

SET IDENTITY_INSERT dbo.measure_type ON
INSERT INTO dbo.measure_type (id,measure_type,measure_data_type) VALUES (1,'Harvested in Lbs','decimal')
INSERT INTO dbo.measure_type (id,measure_type,measure_data_type) VALUES (2,'Number','number')
INSERT INTO dbo.measure_type (id,measure_type,measure_data_type) VALUES (3,'Currency','decimal')
INSERT INTO dbo.measure_type (id,measure_type,measure_data_type) VALUES (4,'Servings','number')
INSERT INTO dbo.measure_type (id,measure_type,measure_data_type) VALUES (5,'Donated in Lbs','decimal')
INSERT INTO dbo.measure_type (id,measure_type,measure_data_type) VALUES (6,'Lbs','decimal')
SET IDENTITY_INSERT dbo.measure_type OFF

SET IDENTITY_INSERT dbo.metric ON
INSERT INTO dbo.metric (id,metric_name,metric_category_id,measure_type_id) VALUES (1,'Total Meals Shared',1,2)
INSERT INTO dbo.metric (id,metric_name,metric_category_id,measure_type_id) VALUES (2,'Total Meals Reported',1,2)
INSERT INTO dbo.metric (id,metric_name,metric_category_id,measure_type_id) VALUES (3,'Total Non-Program Meals',1,2)
INSERT INTO dbo.metric (id,metric_name,metric_category_id,measure_type_id) VALUES (4,'Food Costs',1,3)
INSERT INTO dbo.metric (id,metric_name,metric_category_id,measure_type_id) VALUES (5,'Local Farm Investment',1,3)
INSERT INTO dbo.metric (id,metric_name,metric_category_id,measure_type_id) VALUES (6,'Meal Distribution Partners',1,2)
INSERT INTO dbo.metric (id,metric_name,metric_category_id,measure_type_id) VALUES (7,'Program Participants - Meals',1,2)
INSERT INTO dbo.metric (id,metric_name,metric_category_id,measure_type_id) VALUES (8,'Grocery Store',1,5)
INSERT INTO dbo.metric (id,metric_name,metric_category_id,measure_type_id) VALUES (9,'Farm/Garden',1,5)
INSERT INTO dbo.metric (id,metric_name,metric_category_id,measure_type_id) VALUES (10,'Restaurant',1,5)
INSERT INTO dbo.metric (id,metric_name,metric_category_id,measure_type_id) VALUES (11,'Caterer',1,5)
INSERT INTO dbo.metric (id,metric_name,metric_category_id,measure_type_id) VALUES (12,'Individual',1,5)
INSERT INTO dbo.metric (id,metric_name,metric_category_id,measure_type_id) VALUES (13,'School',1,5)
INSERT INTO dbo.metric (id,metric_name,metric_category_id,measure_type_id) VALUES (14,'Other - Food Donations',1,5)
INSERT INTO dbo.metric (id,metric_name,metric_category_id,measure_type_id) VALUES (15,'Shared with Others',1,5)
INSERT INTO dbo.metric (id,metric_name,metric_category_id,measure_type_id) VALUES (16,'Compost',1,6)
INSERT INTO dbo.metric (id,metric_name,metric_category_id,measure_type_id) VALUES (17,'Fruit',2,1)
INSERT INTO dbo.metric (id,metric_name,metric_category_id,measure_type_id) VALUES (18,'Greens',2,1)
INSERT INTO dbo.metric (id,metric_name,metric_category_id,measure_type_id) VALUES (19,'Salad',2,1)
INSERT INTO dbo.metric (id,metric_name,metric_category_id,measure_type_id) VALUES (20,'Herbs',2,1)
INSERT INTO dbo.metric (id,metric_name,metric_category_id,measure_type_id) VALUES (21,'Eggs',2,1)
INSERT INTO dbo.metric (id,metric_name,metric_category_id,measure_type_id) VALUES (22,'Other - Food Harvested',2,1)
INSERT INTO dbo.metric (id,metric_name,metric_category_id,measure_type_id) VALUES (23,'Roots',2,1)
INSERT INTO dbo.metric (id,metric_name,metric_category_id,measure_type_id) VALUES (24,'Program Participants - Gardens',2,2)
SET IDENTITY_INSERT dbo.metric OFF

SET IDENTITY_INSERT dbo.program ON
INSERT INTO dbo.program (id,program,active) VALUES (1,'Nashville CARES',1)
INSERT INTO dbo.program (id,program,active) VALUES (2,'Community Garden',1)
INSERT INTO dbo.program (id,program,active) VALUES (3,'Market Gardens',1)
INSERT INTO dbo.program (id,program,active) VALUES (4,'Garden Education',1)
SET IDENTITY_INSERT dbo.program OFF

SELECT * from dbo.metric