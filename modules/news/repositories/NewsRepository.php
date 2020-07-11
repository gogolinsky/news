<?php

namespace app\modules\news\repositories;

use app\modules\news\models\News;
use DomainException;
use RuntimeException;

class NewsRepository
{
	public function get($id): News
	{
		$news = News::findOne($id);

		if (empty($news)) {
			throw new DomainException("News $id does not exists");
		}

		return $news;
	}

	public function save(News $news)
	{
		if (!$news->save()) {
			throw new DomainException('Saving error: ' . json_encode($news->errors));
		}
	}

	public function delete(News $news)
	{
		if (!$news->delete()) {
			throw new RuntimeException('News removing error');
		}
	}

	public function getAll(): array
	{
		$news = News::find()->orderBy(['id' => SORT_DESC])->all();

		return $news;
	}

	public function getForCategory($id): array
	{
		$news = News::find()
			->joinWith(['categories'])
			->where(['categories.id' => $id])
			->orderBy(['id' => SORT_DESC])
			->all();

		return $news;
	}
}