<?php

namespace app\modules\news\models;

use app\modules\category\models\Category;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $title
 * @property string $text
 *
 * @property CategoryAssigment[] $categoryAssignments
 * @property Category[] $categories
 */
class News extends ActiveRecord
{
	public function behaviors(): array
	{
		return [
			[
				'class' => SaveRelationsBehavior::class,
				'relations' => ['categoryAssignments'],
			],
		];
	}

    public static function tableName()
    {
        return 'news';
    }

	public function rules()
	{
		return [
			[['title', 'text'], 'required'],
			['title', 'string', 'max' => 255],
		];
	}

	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'title' => 'Заголовок',
			'text' => 'Текст',
		];
	}

	public static function create($title, $text)
	{
		$news = new News();
		$news->title = $title;
		$news->text = $text;

		return $news;
	}

	public function edit(string $title, string $text)
	{
		$this->title = $title;
		$this->text = $text;
	}

	public function getCategoryAssignments(): ActiveQuery
	{
		return $this->hasMany(CategoryAssigment::class, ['news_id' => 'id']);
	}

	public function getCategories(): ActiveQuery
	{
		return $this->hasMany(Category::class, ['id' => 'category_id'])->via('categoryAssignments');
	}

	public function assignCategory($id): void
	{
		$assignments = $this->categoryAssignments;

		foreach ($assignments as $assignment) {
			if ($assignment->isForCategory($id)) {
				return;
			}
		}

		$assignments[] = CategoryAssigment::create($id);
		$this->categoryAssignments = $assignments;
	}

	public function revokeCategories(): void
	{
		$this->categoryAssignments = [];
	}
}
