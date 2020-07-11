<?php

namespace app\modules\news\models;

use yii\db\ActiveRecord;

/**
 * @property integer $news_id;
 * @property integer $category_id;
 */
class CategoryAssigment extends ActiveRecord
{
	public static function create($categoryId): self
	{
		$assignment = new static();
		$assignment->category_id = $categoryId;
		return $assignment;
	}

	public function isForCategory($id): bool
	{
		return $this->category_id == $id;
	}

	public static function tableName(): string
	{
		return '{{%news_categories}}';
	}
}