<?php

use yii\db\Migration;

class m200708_204506_categories extends Migration
{
    public function safeUp()
    {
    	$this->createTable('categories', [
    		'id' => $this->primaryKey(),
		    'lft' => $this->integer()->notNull(),
		    'rgt' => $this->integer()->notNull(),
		    'depth' => $this->integer()->notNull(),
		    'title' => $this->string(255)->notNull(),
	    ]);
    	$this->insert('categories', [
		    'lft' => 1,
			'rgt' => 2,
			'depth' => 0,
			'title' => '',
	    ]);
    }

    public function safeDown()
    {
        $this->dropTable('categories');
    }
}
