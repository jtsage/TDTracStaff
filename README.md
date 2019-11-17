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
 5. Run ```bin/cake tdtrac adduser -a <email> <password> <first_name> <last_name>``` to add an admin user.
 6. Optionally, run ```bin/cake tddemo add_prod_roles``` or ```bin/cake tddemo add_teach_roles``` to add some default user roles.
 7. Delete the _contents_ of ```tmp``` and ```log```
 8. A sample nginx server configuation is included. (using php-fpm).  YMMV.
 9. Visit the site, configure the rest on the configuration page. __At least:__
    * admin_email
    * admin_name
    * short_name
    * long_name
    * server_name
    * mailing_address
 10. This ships with debugging turned on.  Turn it off in ```config/tdtrac.php```

## Install without command line access.

Instructions forthcoming. A SQL dump is available in ```sql_schema_manual.sql```.  This file will create the database, and populate the configuration values. Create a user, be sure to fake a uuid for it. Everything after that can be done in the app.


