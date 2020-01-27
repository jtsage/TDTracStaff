<?php
use Migrations\AbstractMigration;

class AddAWSSNSConfig extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $app_configs = array(
            array('id'=>'a9b70ff2-fe9c-4f4b-b385-0d2d47c26bf0', 'key_name' => 'sms-access-key','value_short' => 'AWS Access Key for SMS','value_long' => 'YOUR-ACCESS-KEY'),
            array('id'=>'acbbae38-553c-44b7-ab12-f13efb5a5bfb', 'key_name' => 'sms-enable','value_short' => 'Enable SMS Functionality (0/1)','value_long' => '0'),
            array('id'=>'c48e16a0-0541-4262-bf5d-6c47f758b2ca', 'key_name' => 'sms-private-key','value_short' => 'AWS Private Key for SMS','value_long' => 'YOUR-SECRET-KEY'),
        );
        $this->table('app_configs')->insert($app_configs)->save();
    }
}

