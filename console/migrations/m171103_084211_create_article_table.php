<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article`.
 */
class m171103_084211_create_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment('文章名'),
            'intro'=>$this->text()->comment('简介'),
            'article_category_id'=>$this->integer()->unsigned()->notNull()->comment('文章分类id'),
            'sort'=>$this->integer(11)->unsigned()->comment('排序'),
            'status'=>$this->smallInteger(2)->unsigned()->comment('状态,-1删除,0隐藏,1正常'),
            'create_time'=>$this->integer(11)->unsigned()->comment('创建时间')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article');
    }
}
