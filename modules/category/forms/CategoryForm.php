<?php

namespace app\modules\category\forms;

use app\modules\category\models\Category;
use yii\base\Model;

class CategoryForm extends Model
{
	public $parent_id;
	public $title;

	public function __construct(Category $category = null, $config = [])
	{
		if ($category != null) {
			$this->parent_id = $category->parent->id;
			$this->title = $category->title;
		}

		parent::__construct($config);
	}

	public function rules()
	{
		return [
			[['parent_id', 'title'], 'required'],
			[['title'], 'string', 'max' => 255],
			[['parent_id'], 'integer'],
		];
	}

	public function attributeLabels()
	{
		return [
			'parent_id' => 'Родительская рубрика',
			'title' => 'Заголовок',
		];
	}
}