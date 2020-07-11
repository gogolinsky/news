<?php

namespace app\modules\category\services;

use app\modules\category\forms\CategoryForm;
use app\modules\category\models\Category;
use app\modules\category\repositories\CategoryRepository;
use DomainException;

class CategoryService
{
	private $categories;

	public function __construct(CategoryRepository $categories)
	{
		$this->categories = $categories;
	}

	public function create(CategoryForm $form): Category
	{
		$parent = $this->categories->get($form->parent_id);
		$category = Category::create($form->title);
		$category->appendTo($parent);
		$this->categories->save($category);

		return $category;
	}

	public function edit(int $id, CategoryForm $form)
	{
		$category = $this->categories->get($id);
		$this->assertIsNotRoot($category);
		$category->edit($form->title);

		if ($form->parent_id !== $category->parent->id) {
			$parent = $this->categories->get($form->parent_id);
			$category->appendTo($parent);
		}

		$this->categories->save($category);
	}

	public function moveUp($id)
	{
		$category = $this->categories->get($id);
		$this->assertIsNotRoot($category);

		if ($prev = $category->prev) {
			$category->insertBefore($prev);
		}

		$this->categories->save($category);
	}

	public function moveDown($id)
	{
		$category = $this->categories->get($id);
		$this->assertIsNotRoot($category);

		if ($next = $category->next) {
			$category->insertAfter($next);
		}

		$this->categories->save($category);
	}

	public function delete($id)
	{
		$category = $this->categories->get($id);
		$this->assertIsNotRoot($category);
		$this->categories->delete($category);
	}

	private function assertIsNotRoot(Category $category)
	{
		if ($category->isRoot()) {
			throw new DomainException('Unable to edit the root category.');
		}
	}
}