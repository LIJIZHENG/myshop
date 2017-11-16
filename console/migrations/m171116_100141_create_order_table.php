<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order`.
 */
class m171116_100141_create_order_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('order', [
            'id' => $this->primaryKey(),
            'member_id'=>$this->integer()->unsigned()->notNull()->comment('用户id'),
            'name'=>$this->string(50)->notNull()->comment('收货人'),
            'province'=>$this->string(20)->notNull()->comment('省'),
            'city'=>$this->string(20)->notNull()->comment('市'),
            'area'=>$this->string(20)->notNull()->comment('县'),
            'address'=>$this->string(255)->notNull()->comment('详细地址'),
            'tel'=>$this->string(11)->notNull()->comment('电话号码'),
            'delivery_id'=>$this->smallInteger()->unsigned()->notNull()->comment('配送方式id'),
            'delivery_name'=>$this->string(50)->notNull()->comment('配送方式名称'),
            'delivery_price'=>$this->decimal(10,2)->unsigned()->notNull()->comment('配送价格'),
            'payment_id'=>$this->smallInteger()->unsigned()->notNull()->comment('支付方式id'),
            'payment_name'=>$this->string(50)->notNull()->comment('支付方式名称'),
            'total'=>$this->decimal(10,2)->unsigned()->notNull()->comment('订单金额'),
            'status'=>$this->smallInteger()->unsigned()->notNull()->comment('订单状态,0已取消,1待付款,2待发货,3待收货,4完成'),
            'trade_no'=>$this->string(100)->comment('第三方支付交易号'),
            'create_time'=>$this->integer()->unsigned()->notNull()->comment('创建时间')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('order');
    }
}
