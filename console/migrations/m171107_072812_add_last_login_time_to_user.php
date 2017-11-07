<?php

use yii\db\Migration;

/**
 * Class m171107_072812_add_last_login_time_to_user
 */
class m171107_072812_add_last_login_time_to_user extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('user','last_login_time',$this->integer()->comment('最后登录时间'));
        $this->addColumn('user','last_login_ip',$this->bigInteger()->comment('最后登录ip'));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m171107_072812_add_last_login_time_to_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171107_072812_add_last_login_time_to_user cannot be reverted.\n";

        return false;
    }
    */
}
