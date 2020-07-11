<?php

/**
 * @var yii\web\View $this
 * @var \app\modules\category\forms\CategoryForm categoryForm
 * @var array $dropDownArray
 * @var array $dropDownOptionsArray
 */

$this->title = 'Добавление рубрики';
$this->params['breadcrumbs'][] = ['label' => 'Рубрики', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?= $this->render('_form', compact('categoryForm', 'dropDownArray', 'dropDownOptionsArray')) ?>