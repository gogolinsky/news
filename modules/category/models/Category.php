<?php

namespace app\modules\category\models;

use paulzi\nestedsets\NestedSetsBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * @property int $id
 * @property int $lft
 * @property int $depth
 * @property int $rgt
 * @property string $title
 *
 * @property Category $parent
 * @property Category[] $parents
 * @property Category[] $children
 * @property Category $prev
 * @property Category $next
 *
 * @mixin NestedSetsBehavior
 */
class Category extends ActiveRecord
{
	public function behaviors()
    {
        return [
	        NestedSetsBehavior::class,
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * @return CategoryQuery
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }

    public static function tableName()
    {
        return 'categories';
    }

    public function rules()
    {
        return [
            ['title', 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
        ];
    }
	public static function create(string $title)
	{
		$category = new Category();
		$category->title = $title;

		return $category;
	}

	public function edit($title)
	{
		$this->title = $title;
	}

	public function getNestedTitle()
	{
		$title = str_repeat('.', max((int) $this->depth - 1, 0));
		$title .= ' ' . $this->title;

		return $title;
	}

	public function getHref()
	{
		return Url::to(['/category/frontend/view', 'id' => $this->id]);
	}
}
