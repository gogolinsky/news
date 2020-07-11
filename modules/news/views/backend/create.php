<?php

/**
 * @var \yii\web\View $this
 * @var \app\modules\news\forms\NewsForm $newsForm
*/

$this->title = 'Добавление новости';
$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?= $this->render('_form', compact('newsForm')) ?>
