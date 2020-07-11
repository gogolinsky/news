<?php

namespace app\modules\news\services;

use app\modules\category\repositories\CategoryRepository;
use app\modules\news\forms\NewsForm;
use app\modules\news\models\News;
use app\modules\news\repositories\NewsRepository;
use app\services\TransactionManager;

class NewsService
{
	private $news;
	private $categories;
	private $transaction;

	public function __construct(
		NewsRepository $news,
		CategoryRepository $categories,
		TransactionManager $transaction
	)
	{
		$this->news = $news;
		$this->categories = $categories;
		$this->transaction = $transaction;
	}

	public function create(NewsForm $form): News
	{
		$news = News::create($form->title, $form->text);

		foreach ($form->categories->ids as $id) {
			$category = $this->categories->get($id);
			$news->assignCategory($category->id);
		}

		$this->news->save($news);

		return $news;
	}

	public function edit(int $id, NewsForm $form)
	{
		$news = $this->news->get($id);
		$news->edit($form->title, $form->text);

		$this->transaction->wrap(function () use ($news, $form) {
			$news->revokeCategories();

			foreach ($form->categories->ids as $id) {
				$category = $this->categories->get($id);
				$news->assignCategory($category->id);
			}
		});

		$this->news->save($news);
	}

	public function delete($id)
	{
		$news = $this->news->get($id);
		$this->news->delete($news);
	}
}