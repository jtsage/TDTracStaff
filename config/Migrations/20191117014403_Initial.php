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
            ->addColumn('is_available', 'tinyinteger', [
                'default' => '0',
                'limit' => 4,
                'null' => false,
            ])
            ->addColumn('is_scheduled', 'tinyinteger', [
                'default' => '0',
                'limit' => 4,
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

        // inserting multiple rows
        $rows = [
            [
                'id' => '1ca73059-c52c-49da-9092-f95de208cc80',
                'title' => 'Driver',
                'detail' => 'Certified to drive trucking to, from, and at events',
                'sort_order' => '600'
            ],
            [
                'id' => '1f07d7fa-ccca-4e5f-b483-f1d98e8dabca',
                'title' => 'Stagehand',
                'detail' => 'On site stagehand',
                'sort_order' => '400'
            ],
            [
                'id' => '2a736f3e-6ea6-4bdf-a057-9f3e67e6ead6',
                'title' => 'Event Tech I - Video',
                'detail' => 'On site video technician',
                'sort_order' => '203'
            ],
            [
                'id' => '31d12ee5-06c4-4fe6-bd08-df1d8d1224cc',
                'title' => 'Help Desk',
                'detail' => 'Offsite Help',
                'sort_order' => '1'
            ],
            [
                'id' => '3b9e9712-69c1-4286-a961-ff2dd880ef17',
                'title' => 'Field Lead',
                'detail' => 'In charge of all on-site aspects, main contact person on-site',
                'sort_order' => '100'
            ],
            [
                'id' => '4d6e852f-5376-41a1-bde0-31796f715af1',
                'title' => 'Shop Lead',
                'detail' => 'In charge of all pre-site aspects, main contact person at shop',
                'sort_order' => '101'
            ],
            [
                'id' => '996a29c5-d028-47bd-8810-14b6dc37b116',
                'title' => 'Intern',
                'detail' => 'On or Off site technician in training',
                'sort_order' => '900'
            ],
            [
                'id' => 'b6e30746-59d8-42b2-a34b-01b2f285e3d8',
                'title' => 'Event Tech I - Audio',
                'detail' => 'On site audio technician',
                'sort_order' => '201'
            ],
            [
                'id' => 'ba3a5166-cf4b-46cd-aadd-53b5d6bf1010',
                'title' => 'Event Tech I - Lighting',
                'detail' => 'On site lighting technician',
                'sort_order' => '202'
            ],
            [
                'id' => 'c777160b-0625-4f68-ae3c-c3e7804c5626',
                'title' => 'Utility',
                'detail' => 'On site utility worker',
                'sort_order' => '500'
            ],
            [
                'id' => 'ce184f8b-4606-4401-aaf7-b3c42fd02697',
                'title' => 'Event Tech II',
                'detail' => 'On site technician',
                'sort_order' => '300'
            ]
        ];

        // this is a handy shortcut
        $this->insert('roles', $rows);
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
