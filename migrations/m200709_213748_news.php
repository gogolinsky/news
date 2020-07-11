<?php

use yii\db\Migration;

class m200709_213748_news extends Migration
{
    public function safeUp()
    {
	    $this->createTable('news', [
		    'id' => $this->primaryKey(),
		    'title' => $this->string(255)->notNull(),
		    'text' => $this->text()->notNull(),
	    ]);
	    $this->createTable('news_categories', [
		    'id' => $this->primaryKey(),
		    'news_id' => $this->integer()->notNull(),
		    'category_id' => $this->integer()->notNull(),
	    ]);
	    $this->addForeignKey('fk_news_categories_news', 'news_categories', 'news_id', 'news', 'id', 'cascade', 'cascade');
	    $this->addForeignKey('fk_news_categories_category', 'news_categories', 'category_id', 'categories', 'id', 'cascade', 'cascade');
    }

    public function safeDown()
    {
        $this->dropTable('news_categories');
        $this->dropTable('news');
    }
}
