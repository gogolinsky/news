<?php

use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\grid\DataColumn;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 * @var \app\modules\news\models\NewsSearch $searchModel
 */

$this->title = 'Новости';
$this->params['breadcrumbs'][] = $this->title;

?>

<p>
    <a href="<?= Url::to(['/news/backend/create']) ?>" class="btn btn-success">Добавить</a>
</p>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'summaryOptions' => ['class' => 'text-right'],
    'columns' => [
        [
            'class' => DataColumn::class,
            'attribute' => 'id',
            'headerOptions' => ['style' => 'width:80px'],
        ],
        [
            'class' => DataColumn::class,
            'attribute' => 'title',
        ],
        [
            'class' => ActionColumn::class,
            'template' => '{update} {delete}',
            'headerOptions' => ['style' => 'width:60px'],
        ],
    ],
]) ?>
