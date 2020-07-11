<?php

namespace app\modules\news\formatters;

use app\modules\category\models\Category;
use app\modules\news\models\News;

class NewsFormatter
{
	public function element(News $news)
	{
		return [
			'title' => $news->title,
			'text' => $news->text,
			'categories' => array_map(function(Category $category) {
				return $category->title;
			}, $news->categories),
		];
	}

	public function elements(array $elements)
	{
		return array_map(function (News $news) {
			return $this->element($news);
		}, $elements);
	}
}