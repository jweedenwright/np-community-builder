# Non-Profit Community Builder

The purpose of this software is to build an easy to operate and manage software solution for tracking volunteer information as well as other important metrics.

The tracking of these metrics are essential, as well as the built in dashboard, for helping non-profits to show the impact they have within the community.

## Getting Started

This documentation is to help setup the non-profit community builder application using the code in this package.

### Prerequisites

This software solution was originally built on the Microsoft Axure cloud. The application requires:
* A PHP install (at least 5.6.7)
* Email support on your PHP server
* SQL Server

### Setup on Azure
The easiest way to do setup for this project is to use the Azure Cloud. This is important if you are a non-profit as you get credits for cloud usage that could pay for your entire installation.

1. **Setup a new _App Service_**: This is the service that will run your website.
  i. When starting out, you'll want to setup a _resource group_ for this particular app/project. It is used to manage and control permissions/access in Azure.
  ii. Choose PHP as the Runtime stack.
  iii. In the SKU and Size section, remember, to save on costs you can go with a smaller size server. This is especially useful (and probably needed) for test or development environments.

2. **Setup a _SQL Server_**: This is the actual server that will house the database instances you create. You can generally have 1 server with multiple databases running on it.
  i. Choose your resource group, give your server a name, and specify the login and password (VERY important for going in and actually creating tables/querying)
  ii. Ensure the server was created (completed) by Azure before you go to the next step!

3. **Setup a _SQL Database_**: You'll need to do this for each environment that you plan to have.
  i. Choose your resource group, give your database a name (test, master, etc), choose your *_SQL Server_* (created in the last step), and configure the database.
  ii. When configuring, you can choose multiple levels (basic, standard, premium, general purpose, hyperscale, business critical). For a test database, we will use basic.

4. **_FTP_ files to the server**:
  i. Go to all resources and click on the _app service_ you created.
  ii. Search on **ftp** and click on _Deployment Center_
  iii. Scroll to manual deployment and select _FTP_. Click on _dashboard_.
  iv. Decide to use app credentials or user credentials. These are what you'll use in the FTP client of your choice to connect and upload files.
  v. Using Filezilla or an FTP product of your choice, use FTPS to connect using the credentials and the FTPS Endpoint specified in Azure on the FTP Dashboard.
  vi. Transfer over the **app, css, fonts, img, js, and pages** folders.
  vii. Transfer over the files: **footer.php, header.php, index.html, index.php, robots.txt, and web.config**
  viii. Visit your azure website and you should see the beginnings of your checkin system!

5. **Setup _Application Settings_**: These are basically server variables that allow the app to determine what connection strings to use for databases. This is more secure than saving connection settings within the code itself AND it allows for multiple environment configurations.
  i. Search on **Configuration** and click _Configuration_ in the results.
  ii. Go to the _Application Settings_ section.
  iii. Add the following variables:
```
SEND_GRID_KEY // For email - will setup later - just use xxx for now
DB_NAME // From your SQL Database setup
DB_USER // From your SQL Database setup
DB_PASSWORD // From your SQL Database setup
```
6. **_Connect_ and _Install_ the database**:
  i. Go to your **SQL Server** resource you created in step 2 above.
  ii. Search on **Security** and click _Firewalls and Virtual Networks_ in the results.
  iii. Looking at your IP Address (displayed on the page), add a new rule that allows your IP address to connect to the server. *NOTE: This step will be needed for every location in which you plan to connect to the database to query or make changes that is not the app server!!*
  iv. Save the firewall rules/updates. 
  v. Use your favorite database connection tool (such as SQL Server Management Studio or DBeaver) to connect to your database.
  vi. Open up the database you created in step 3, open a SQL editor, and run the **/future_db/table_maintenance.sql** script.
  vii. Edit the **/future_db/data_import.sql** file to include the necessary data you need to start work. Some examples are in the current file.
  viii. Run the **/future_db/data_import.sql** file on the database.

7. **Start to update files**
  i. Update images in **/img/** to be your organization's knockout logo (_knockout-logo.png_) and a banner image (_header.jpg_)
  ii. Update variables in **/app/global.php** to reflect the necessary data for your organization.
  iii. FTP the changed files up to the server.

### Setting Up A User
To setup a user in the system:
1. You will need a database admin to add the email address to the database
2. Once the email address is there, you'll need to go to the /pages/login.php page and choose 'Reset Password'
3. After recieving the password reset email, you'll need to follow the link
4. Reset your password on that page and you'll be set.