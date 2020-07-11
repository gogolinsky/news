<?php

/**
 * @var \app\modules\category\models\Category $category
 * @var \app\modules\category\forms\CategoryForm $categoryForm
 * @var array $dropDownArray
 * @var array $dropDownOptionsArray
 */

$this->title = $category->title;
$this->params['breadcrumbs'][] = ['label' => 'Рубрики', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?= $this->render('_form', compact('categoryForm', 'dropDownArray', 'dropDownOptionsArray')) ?>