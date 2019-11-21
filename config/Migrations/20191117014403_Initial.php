<?php
use Migrations\AbstractMigration;

class Initial extends AbstractMigration
{

    public $autoId = false;

    public function up()
    {

        $this->table('app_configs')
            ->addColumn('id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('key_name', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('value_short', 'string', [
                'default' => null,
                'limit' => 250,
                'null' => true,
            ])
            ->addColumn('value_long', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('budgets')
            ->addColumn('id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('vendor', 'string', [
                'default' => null,
                'limit' => 150,
                'null' => false,
            ])
            ->addColumn('category', 'string', [
                'default' => null,
                'limit' => 150,
                'null' => false,
            ])
            ->addColumn('detail', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('date', 'date', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('amount', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 8,
                'scale' => 2,
            ])
            ->addColumn('user_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('job_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('created_at', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'job_id',
                ]
            )
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->create();

        $this->table('jobs')
            ->addColumn('id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => false,
            ])
            ->addColumn('detail', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => true,
            ])
            ->addColumn('location', 'string', [
                'default' => null,
                'limit' => 150,
                'null' => true,
            ])
            ->addColumn('category', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => true,
            ])
            ->addColumn('date_start', 'date', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('date_end', 'date', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('time_string', 'string', [
                'default' => null,
                'limit' => 250,
                'null' => false,
            ])
            ->addColumn('due_payroll_submitted', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('due_payroll_paid', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('notes', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('is_active', 'boolean', [
                'default' => true,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('is_open', 'boolean', [
                'default' => true,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('has_payroll', 'boolean', [
                'default' => true,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('has_budget', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('has_budget_total', 'decimal', [
                'default' => '0.00',
                'null' => false,
                'precision' => 10,
                'scale' => 2,
            ])
            ->addColumn('created_at', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('updated_at', 'timestamp', [
                'default' => '1970-01-01 05:00:01',
                'limit' => null,
                'null' => false,
            ])
            ->create();

        $this->table('jobs_roles')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 10,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('job_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('role_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('number_needed', 'integer', [
                'default' => '1',
                'limit' => 11,
                'null' => false,
            ])
            ->addIndex(
                [
                    'job_id',
                ]
            )
            ->addIndex(
                [
                    'role_id',
                ]
            )
            ->create();

        $this->table('payrolls')
            ->addColumn('id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('date_worked', 'date', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('time_start', 'time', [
                'default' => '08:00:00',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('time_end', 'time', [
                'default' => '17:00:00',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('hours_worked', 'float', [
                'default' => null,
                'null' => true,
                'precision' => 4,
                'scale' => 2,
            ])
            ->addColumn('is_paid', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('user_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('job_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('created_at', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('updated_at', 'timestamp', [
                'default' => '1970-01-01 05:00:01',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'job_id',
                ]
            )
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->create();

        $this->table('roles')
            ->addColumn('id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('detail', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('sort_order', 'integer', [
                'default' => '999',
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('created_at', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('updated_at', 'timestamp', [
                'default' => '1970-01-01 05:00:01',
                'limit' => null,
                'null' => false,
            ])
            ->create();

        $this->table('users')
            ->addColumn('id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('password', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('first', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('last', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('phone', 'string', [
                'default' => null,
                'limit' => 13,
                'null' => true,
            ])
            ->addColumn('is_active', 'boolean', [
                'default' => true,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('is_password_expired', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('is_admin', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('is_budget', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('is_verified', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('last_login_at', 'timestamp', [
                'default' => '1970-01-01 10:00:01',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('created_at', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('updated_at', 'timestamp', [
                'default' => '1970-01-01 10:00:01',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('reset_hash', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => true,
            ])
            ->addColumn('reset_hash_time', 'timestamp', [
                'default' => '1970-01-01 10:00:01',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('verify_hash', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => true,
            ])
            ->addIndex(
                [
                    'reset_hash',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'username',
                ],
                ['unique' => true]
            )
            ->create();

        $this->table('users_jobs')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 10,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('user_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('job_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('role_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('is_available', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('is_scheduled', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('note', 'string', [
                'default' => null,
                'limit' => 250,
                'null' => true,
            ])
            ->addIndex(
                [
                    'job_id',
                ]
            )
            ->addIndex(
                [
                    'role_id',
                ]
            )
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->create();

        $this->table('users_roles')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 10,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('user_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('role_id', 'uuid', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'role_id',
                ]
            )
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->create();

        $this->table('budgets')
            ->addForeignKey(
                'job_id',
                'jobs',
                'id',
                [
                    'update' => 'RESTRICT',
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'RESTRICT',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();

        $this->table('jobs_roles')
            ->addForeignKey(
                'job_id',
                'jobs',
                'id',
                [
                    'update' => 'RESTRICT',
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'role_id',
                'roles',
                'id',
                [
                    'update' => 'RESTRICT',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();

        $this->table('payrolls')
            ->addForeignKey(
                'job_id',
                'jobs',
                'id',
                [
                    'update' => 'RESTRICT',
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'RESTRICT',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();

        $this->table('users_jobs')
            ->addForeignKey(
                'job_id',
                'jobs',
                'id',
                [
                    'update' => 'RESTRICT',
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'role_id',
                'roles',
                'id',
                [
                    'update' => 'RESTRICT',
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'RESTRICT',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();

        $this->table('users_roles')
            ->addForeignKey(
                'role_id',
                'roles',
                'id',
                [
                    'update' => 'RESTRICT',
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'RESTRICT',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();

        $app_configs = array(
            array('id' => '07ed25e3-240c-4ca2-ab4b-4a45f142c2b3','key_name' => 'server-name','value_short' => 'FQDN, with protocal of the server name','value_long' => 'https://demostaff.tdtrac.com'),
            array('id' => '1066f6f6-bb33-430f-9e08-561e33d7d6f8','key_name' => 'job-new-email','value_short' => 'Sent when a job is newly added to the database and needs staff to indicate availability','value_long' => 'Good day!\n\nYou are receiving the e-mail due to the fact that a new job has been added to {{long-name}}\'s TDTracStaff instance.  Job staffing requirements have been added, and based on your training profile, you qualify for one or more of the open positions.  Please follow the link below to indicate your availability as soon as possible.  You will be notified if you are selected to be scheduled for this job.\n\n * __Job Name__: [[name]]\n * __Job Description__: [[detail]]\n * __Job Location__: [[location]]\n\nThis job runs from _[[date_start_string]]_ through _[[date_end_string]]_.  The time(s) of the event are _[[time_string]]_.  If scheduled, payroll hours will be due no later than _[[due_payroll_submitted_string]]_, with paychecks cut on _[[due_payroll_paid_string]]_.\n\n<div>\n@@@{{server-name}}/jobs/available/[[id]]|Set your availability@@@\n</div>\n\nThank you for your time today!\n\n_~{{admin-name}}_\n<{{admin-email}}>'),
            array('id' => '11782b20-8c91-4f83-bd45-2feef5c8fdf2','key_name' => 'job-old-email','value_short' => 'Sent when a job is NOT newly added to the database and either STILL needs staff to indicate availability, or staffing needs have changed','value_long' => 'Good day!\n\nYou are receiving the e-mail due to the fact that a job that has been added to {{long-name}}\'s TDTracStaff instance still requires staffing, or the staffing requirements have recently changed. Based on your training profile, you qualify for one or more of the open positions. Please follow the link below to indicate your availability as soon as possible. Our apologies if you have already indicated your availability, this is a limitation of the current system. You will be notified if you are selected to be scheduled for this job.\n\n* __Job Name__: [[name]]\n* __Job Description__: [[detail]]\n* __Job Location__: [[location]]\n\nThis job runs from _[[date_start_string]]_ through _[[date_end_string]]_. The time(s) of the event are _[[time_string]]_. If scheduled, payroll hours will be due no later than _[[due_payroll_submitted_string]]_, with paychecks cut on _[[due_payroll_paid_string]]_.\n\n<div>\n@@@{{server-name}}/jobs/available/[[id]]|Set your availability@@@\n</div>\n\nThank you for your time today!\n\n_~{{admin-name}}_\n<{{admin-email}}>'),
            array('id' => '21873149-f8d7-4bb7-9192-ad212ff1be5e','key_name' => 'welcome-email','value_short' => 'The welcome E-Mail','value_long' => 'Good day!\n\nWelcome to {{long-name}}\'s digital time sheet and staffing system.  The e-mail below contains your temporary password, username, and login link.\n\nYou have been assigned a temporary password, please change it the first time you log in!\n\nAddress:  {{server-name}}\nUsername: {{username}}\nPassword: {{password}}\n\n@@@{{server-name}}/books/quickstart.pdf|Quick Start Guide@@@\n\n@@@{{server-name}}/books/handbook.pdf|Handbook@@@\n\nThanks,\n\n{{admin-name}}\n{{admin-email}}'),
            array('id' => '46596a40-576d-4319-803e-cdb3a880dbfd','key_name' => 'require-hours','value_short' => 'Require hours worked, rather than just a total - must be 0 (use a total), or 1 (use start and end times)','value_long' => '1'),
            array('id' => '67dc9387-52bd-4ced-a377-957f0b043617','key_name' => 'notify-email','value_short' => 'Email sent when you have scheduled 1 or more staff members.','value_long' => 'Good day!\n\nYou are receiving the e-mail due to the fact that a job has been staffed in {{long-name}}\'s TDTracStaff instance. Please visit the link below to check if you have been selected to be scheduled for this job.\n\n* __Job Name__: [[name]]\n* __Job Description__: [[detail]]\n* __Job Location__: [[location]]\n\nThis job runs from _[[date_start_string]]_ through _[[date_end_string]]_. The time(s) of the event are _[[time_string]]_. If scheduled, payroll hours will be due no later than _[[due_payroll_submitted_string]]_, with paychecks cut on _[[due_payroll_paid_string]]_.\n\n<div>\n@@@{{server-name}}/jobs/view/[[id]]|View your schedule@@@\n</div>\n\nThank you for your time today!\n\n_~{{admin-name}}_\n<{{admin-email}}>'),
            array('id' => '7aebba45-57b5-4a5e-a788-004f4ffb043c','key_name' => 'paydates-period','value_short' => 'Set of period paydate, in the format [ "2019-09-11", 14 ] (start, period) or false','value_long' => 'false'),
            array('id' => '8b37c74a-3973-4864-bf96-3ec0059967c1','key_name' => 'admin-name','value_short' => 'The administrator\'s Name','value_long' => 'Example Admin'),
            array('id' => '9d0a4cdf-91db-4079-ad20-b350a51424cd','key_name' => 'long-name','value_short' => 'Long name of the system, usually a company name','value_long' => 'Example Company'),
            array('id' => 'bbb58578-7411-4aa6-a3e0-aeb1acc0fe54','key_name' => 'calendar-api-key','value_short' => 'Key for iCal (ics) access - probably a UUID or hash or password - that is sent in cleartext.','value_long' => '5f1742c5-441e-4575-beff-c32a33ea7aa7'),
            array('id' => 'cec8b70f-a89a-42d0-9940-2f2d58102f5f','key_name' => 'mailing-address','value_short' => 'Mailing Address of the company - used in E-Mails.','value_long' => '123 Fake Street, Pittsburgh, PA 15201'),
            array('id' => 'dca46886-6cf7-41b7-8e9e-a1c350a0c79f','key_name' => 'paydates-fixed','value_short' => 'Set of fixed paydate, in the fixed format: [ [-1,-1,15], [-1,-1,30] ] (15th and 30th) or false','value_long' => '[ [-1,-1,15], [-1,-1,30] ]'),
            array('id' => 'e79b33e7-5cad-4171-bc84-83cad71a0d0e','key_name' => 'admin-email','value_short' => 'The administrator\'s E-Mail Address','value_long' => 'jtsage@gmail.com'),
            array('id' => 'fc43931f-37b7-459c-8cc0-dd362e3b2ae5','key_name' => 'allow-unscheduled-hours','value_short' => 'Allow adding hours to jobs the user is not scheduled for. (0 /1)','value_long' => '1'),
            array('id' => 'fe35a641-5ce3-47f6-90fe-14dca4cdb0ab','key_name' => 'short-name','value_short' => 'Short name of the Site, usually Initials','value_long' => 'EC'),
            array('id' => '76b14e8d-00fd-4890-832a-540a49e2960f','key_name' => 'time-zone','value_short' => 'Display Time Zone - Used infrequently, data is stored without modification.','value_long' => 'America/New_York'),
            array('id' => 'c9e14a00-416b-498a-8464-78d700780a14','key_name' => 'queue-email','value_short' => 'Queue E-Mail for sending later. This is a good idea, but requires cron setup to be complete.','value_long' => '1')
        );
        $this->insert('app_configs', $app_configs);
    }




    public function down()
    {
        $this->table('budgets')
            ->dropForeignKey(
                'job_id'
            )
            ->dropForeignKey(
                'user_id'
            )->save();

        $this->table('jobs_roles')
            ->dropForeignKey(
                'job_id'
            )
            ->dropForeignKey(
                'role_id'
            )->save();

        $this->table('payrolls')
            ->dropForeignKey(
                'job_id'
            )
            ->dropForeignKey(
                'user_id'
            )->save();

        $this->table('users_jobs')
            ->dropForeignKey(
                'job_id'
            )
            ->dropForeignKey(
                'role_id'
            )
            ->dropForeignKey(
                'user_id'
            )->save();

        $this->table('users_roles')
            ->dropForeignKey(
                'role_id'
            )
            ->dropForeignKey(
                'user_id'
            )->save();

        $this->table('app_configs')->drop()->save();
        $this->table('budgets')->drop()->save();
        $this->table('jobs')->drop()->save();
        $this->table('jobs_roles')->drop()->save();
        $this->table('payrolls')->drop()->save();
        $this->table('roles')->drop()->save();
        $this->table('users')->drop()->save();
        $this->table('users_jobs')->drop()->save();
        $this->table('users_roles')->drop()->save();
    }
}
