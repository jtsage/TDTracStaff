# TDTracStaff

### A Theater Oriented Staff and Payroll Tracker
TDTrac is a web based job budget and payroll hours tracker, built by a Technical Director, for other TD's, freelance designers, and anyone else who finds it useful. TDTrac is completely free, released as open source. The "Staff" version of TDTrac lessens the emphasis on budget expenditures, and drops support for per-job calendars and task lists, while adding the ability to schedule individual employees for each job. User permissions have also been simplified across the board.


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
    * ```admin-email```
    * ```admin-name```
    * ```short-name```
    * ```long-name```
    * ```server-name```
    * ```mailing-address```
 10. This ships with debugging turned off.  Turn it on in ```config/tdtrac.php``` when reporting any errors.

## Crontab Install

TDTracStaff semi-requires a crontab task to run.  It's a really, really good idea to use this method rather than turning off queued E-mail. (If you absolutly must, reverse step 2 below)

 1. Set up a crontab for e-mail and cron.  In this example, send every 10 minutes (100 emails max), cron runs at 8:00am

     * ```*/10 * * * * /usr/bin/sudo -u www-data /path-to-install/bin/cake process_mail_queue```
     * ```0 0 8 * * /usr/bin/sudo -u www-data /path-to-install/bin/cake cron_job```

 2. Change the configuration value of ```queue-email``` to "1" (the default)

**Important Note** Some features do not appear in the user interface if mail queuing is not enabled. This is for performance reasons.

**Another Important Note** CRON jobs with e-mail require the use of mail queuing.

**Last Important Note** I've moved away from cron, look in ./Example_Config_SYSTEMD for how to do it with systemd timer units.

## Install without command line access.

 1. Clone or download the gitHub Repo
 2. Edit as a new file, ```config/tdtrac-dist.php``` -> ```config/tdtrac.php```
    * __CHANGE THE SALT!!__
    * Database connection information (you should create one, with it's own user)
    * Mailer information.  Gmail details included, you must allow less-secure app to use gmail.
    * See: https://devanswers.co/allow-less-secure-apps-access-gmail-account/
 3. Upload everything
 3. Fix permissions on ```tmp``` and ```log``` - world writeable is easiest.  They need to be writeable for both your user, **and** the webserver user.
 4. Use ```sql_schema_manual.sql``` to populate the database.
 5. Add a user via sql or phpmyadmin. ```is_verified```, ```is_admin```, and ```is_active``` should all be true.
 6. A sample nginx server configuation is included. (using php-fpm).  YMMV.
 7. Visit the reset password page and reset the password for the user you just created.
 8. Visit the site, configure the rest on the configuration page. __At least:__
    * ```admin-email```
    * ```admin-name```
    * ```short-name```
    * ```long-name```
    * ```server-name```
    * ```mailing-address```
 9. If you don't have CLI access, you likely don't have cron access.  Set the configuration value of ```queue-email``` to "0"

## Command Line Toys

 - ```bin/cake roles_instructor YES```
     - Add "instructor" basic roles to the db.
 - ```bin/cake roles_production YES```
     - Add "production" basic roles to the db
 - ```bin/cake user_active (--force-no|--force-yes) <username>```
     - Toggle user's active status
 - ```bin/cake user_add <username> <password> <first_name> <last_name> --admin -budget```
     - Add an ( --admin ) (--budget ) user to the system. 
 - ```bin/cake user_admin (--force-no|--force-yes) <username>```
     - Toggle user's admin status 
 - ```bin/cake user_budget (--force-no|--force-yes) <username>```
     - Toggle user's budget status
 - ```bin/cake user_password <username> <password>```
     - Change a user's password 

**Note**: Stay clear of the ```demo_``` command line toys - they are to populate the demo site, and are dangerous.  That don't check to make sure the database isn't a real one first.
