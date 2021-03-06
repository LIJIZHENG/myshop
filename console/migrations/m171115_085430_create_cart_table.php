<?php

use yii\db\Migration;

/**
 * Handles the creation of table `cart`.
 */
class m171115_085430_create_cart_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('cart', [
            'id' => $this->primaryKey(),
            'goods_id'=>$this->integer()->unsigned()->notNull()->comment('商品id'),
            'amount'=>$this->integer()->unsigned()->notNull()->comment('商品数量'),
            'member_id'=>$this->integer()->unsigned()->notNull()->comment('会员id')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('cart');
    }
}
