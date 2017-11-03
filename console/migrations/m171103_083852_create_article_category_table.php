<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article_category`.
 */
class m171103_083852_create_article_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article_category', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment('文章分类'),
            'intro'=>$this->text()->comment('简介'),
            'sort'=>$this->integer(11)->notNull()->comment('排序'),
            'status'=>$this->smallInteger(2)->unsigned()->notNull()->comment('状态')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article_category');
    }
}
