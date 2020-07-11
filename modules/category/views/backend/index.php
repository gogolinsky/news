<?php

use app\modules\category\models\Category;
use yii\grid\ActionColumn;
use yii\grid\DataColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Рубрики';
$this->params['breadcrumbs'][] = $this->title;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var \app\modules\category\models\CategorySearch $searchModel
 */

?>

<p>
    <a href="<?= Url::to(['/category/backend/create']) ?>" class="btn btn-success">Добавить</a>
</p>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'class' => DataColumn::class,
            'attribute' => 'id',
	        'headerOptions' => ['style' => 'width:80px'],
        ],
        [
            'class' => DataColumn::class,
            'value' => function (Category $model) {
                return
                    Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', ['move-up', 'id' => $model->id], [
                        'class' => 'pjax-action'
                    ]) .
                    Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', ['move-down', 'id' => $model->id], [
                        'class' => 'pjax-action'
                    ]);
            },
            'format' => 'raw',
	        'headerOptions' => ['style' => 'width:45px'],
        ],
        [
            'class' => DataColumn::class,
            'attribute' => 'title',
	        'value' => function(Category $category) {
				return $category->getNestedTitle();
	        }
        ],
        [
            'class' => ActionColumn::class,
            'template' => '{update} {delete}',
	        'headerOptions' => ['style' => 'width:50px'],
        ],
    ],
]) ?>
