<?php

namespace app\modules\news\forms;

use app\forms\CompositeForm;
use app\modules\news\models\News;

/**
 * @property string $title
 * @property string $text
 *
 * @property CategoriesForm $categories
 */
class NewsForm extends CompositeForm
{
	public $title;
	public $text;

	public function __construct(News $news = null, $config = [])
	{
		if ($news) {
			$this->title = $news->title;
			$this->text = $news->text;
			$this->categories = new CategoriesForm($news);
		} else {
			$this->categories = new CategoriesForm();
		}

		parent::__construct($config);
	}

	public function rules()
	{
		return [
			[['title', 'text'], 'required'],
			[['title'], 'string', 'max' => 255],
			[['text'], 'string'],
		];
	}

	public function attributeLabels()
	{
		return [
			'title' => 'Заголовок',
			'text' => 'Текст',
		];
	}

	protected function internalForms(): array
	{
		return ['categories'];
	}
}