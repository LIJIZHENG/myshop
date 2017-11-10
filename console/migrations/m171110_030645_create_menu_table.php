<?php

use yii\db\Migration;

/**
 * Handles the creation of table `menu`.
 */
class m171110_030645_create_menu_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('menu', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(30)->notNull()->comment('菜单名'),
            'parent_id'=>$this->integer()->unsigned()->notNull()->comment('上级菜单'),
            'depth'=>$this->smallInteger()->unsigned()->notNull()->comment('深度'),
            'route'=>$this->string(30)->notNull()->comment('路由'),
            'sort'=>$this->smallInteger()->unsigned()->notNull()->comment('排序')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('menu');
    }
}
