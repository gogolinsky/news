<?php

/**
 * @var yii\web\View $this
 * @var \app\modules\news\models\News $news
 * @var \app\modules\news\forms\NewsForm $newsForm
 */

$this->title = 'Редактирование новости';
$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $news->title];

?>

<?= $this->render('_form', compact('newsForm')) ?>
