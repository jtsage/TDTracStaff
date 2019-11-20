# TDTracStaff

### A Theater Oriented Staff and Payroll Tracker
Placeholder text.  First itteration of an update to TDTrac that drops the budget tracking emphasis, and focuses on staffing gigs. ToDo's and calendar modules will not be ported. (I didn't use either, if you do, development of them is available, but probably not for free.)


## Requirements
 * MySQL 5.7+
 * PHP 7.x+
 * Apache or similar webserver
 * Approx 100 MB of space for web files + caches 
 * A shared or unique MySQL database


## Install

 1. Clone the gitHub Repo
 2. Edit as a new file, ```config/tdtrac-dist.php``` -> ```config/tdtrac.php```
    * __CHANGE THE SALT!!__
    * Database connection information (you should create one, with it's own user)
    * Mailer information.  Gmail details included, you must allow less-secure app to use gmail.
    * See: https://devanswers.co/allow-less-secure-apps-access-gmail-account/
 3. Fix permissions on ```tmp``` and ```log``` - world writeable is easiest.  They need to be writeable for both your user, **and** the webserver user.
 4. Run ```bin/cake migrations migrate``` to create the database and populate the configuration values
 5. Run ```bin/cake user_add --admin <email> <password> <first_name> <last_name>``` to add an admin user.
 6. Optionally, run ```bin/cake roles_production``` or ```bin/cake roles_instructor``` to add some default user roles.
 7. Delete the _contents_ of ```tmp``` and ```log```
 8. A sample nginx server configuation is included. (using php-fpm).  YMMV.
 9. Visit the site, configure the rest on the configuration page. __At least:__
    * admin-email
    * admin-name
    * short-name
    * long-name
    * server-name
    * mailing-address
 10. This ships with debugging turned off.  Turn it on in ```config/tdtrac.php``` when reporting any errors.

## Crontab Install

Yeah, gotta write / test this bit.  

 1. Set up the crontab
 2. Change the configuration value of 'queue-email' to "1" (the default)

**Important Note** Some features do not appear in the user interface if mail queuing is not enabled. This is for performance reasons.

## Install without command line access.

Instructions forthcoming. A SQL dump is available in ```sql_schema_manual.sql```.  This file will create the database, and populate the configuration values. Create a user, be sure to fake a uuid for it. Everything after that can be done in the app. Include note here about turning off mail queuing.


## Command Line Toys

 - ```bin/cake roles_instructor YES``` Add "instructor" basic roles to the db.
 - ```bin/cake roles_production YES``` Add "production" basic roles to the db
 - ```bin/cake user_active <username>``` Toggle user's active status
 - ```bin/cake user_add <username> <password> <first_name> <last_name> --admin -budget``` Add an ( --admin ) (--budget ) user to the system. 
 - ```bin/cake user_admin <username>``` Toggle user's admin status 
 - ```bin/cake user_budget <username>```  Toggle user's budget status
 - ```bin/cake user_password <username> <password>``` Change a user's password 

**Note**: Stay clear of the demo_ command line toys - they are to populate the demo site, and are dangerous.  That don't check to make sure the database isn't a real one first.
