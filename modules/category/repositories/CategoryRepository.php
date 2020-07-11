<?php

namespace app\modules\category\repositories;

use app\modules\category\models\Category;
use DomainException;
use RuntimeException;

class CategoryRepository
{
	public function get(int $id)
	{
		$category = Category::findOne($id);

		if (empty($category)) {
			throw new DomainException("Category $id does not exists");
		}

		return $category;
	}

	public function save(Category $category)
	{
		if (!$category->save()) {
			throw new DomainException('Saving error: ' . json_encode($category->errors));
		}
	}

	public function delete(Category $category)
	{
		if (!$category->delete()) {
			throw new RuntimeException('Category removing error');
		}
	}

	public function getTree(): array
	{
		$root = Category::findOne(1);
		$tree = $this->generateTree($root);

		return $tree;
	}

	public function getNestedIds(int $id)
	{
		$category = $this->get($id);
		$ids = $category->getDescendants(null, true)->select(['id'])->column();

		return $ids;
	}

	private function generateTree(Category $root): array
	{
		$nestedChildren = $root->getDescendants(1)->all();

		if (empty($nestedChildren)) {
			return ['id' => $root->id, 'url' => $root->getHref(), 'label' => $root->title, 'depth' => $root->depth];
		}

		$children = [];

		foreach ($nestedChildren as $child) {
			$children[] = $this->generateTree($child);
		}

		$tree = ['id' => $root->id, 'url' => $root->getHref(), 'label' => $root->title, 'depth' => $root->depth, 'children' => $children];

		return $tree;
	}
}