<?php

namespace app\modules\news\forms;

use app\modules\category\models\Category;
use app\modules\news\models\News;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class CategoriesForm extends Model
{
	public $ids = [];

	public function __construct(News $news = null, $config = [])
	{
		if ($news) {
			$this->ids = ArrayHelper::getColumn($news->categories, 'id');
		}

		parent::__construct($config);
	}

	public function getList(): array
	{
		$categories = Category::find()->indexBy('id')->andWhere(['>', 'depth', 0])->orderBy(['lft' => SORT_ASC])->all();

		return array_map(function(Category $category) {
			return $category->getNestedTitle();
		}, $categories);
	}

	public function rules(): array
	{
		return [
			['ids', 'required'],
			['ids', 'each', 'rule' => ['integer']],
		];
	}

	public function attributeLabels()
	{
		return [
			'ids' => 'Категории',
		];
	}
}