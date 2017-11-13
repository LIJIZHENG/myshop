<?php

use yii\db\Migration;

/**
 * Handles the creation of table `address`.
 */
class m171113_074840_create_address_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('address', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(20)->notNull()->comment('收货人'),
            'province'=>$this->string(20)->notNull()->comment('省份'),
            'area'=>$this->string(20)->notNull()->comment('地区'),
            'city'=>$this->string(20)->notNull()->comment('城市'),
            'detail'=>$this->string(100)->notNull()->comment('详细地址'),
            'tel'=>$this->string(11)->notNull()->comment('电话号码'),
            'status'=>$this->smallInteger(1)->notNull()->comment('状态,1默认地址,0显示,-1删除'),
            'member_id'=>$this->integer()->notNull()->comment('会员id')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('address');
    }
}
