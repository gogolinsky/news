<?php

use yii\bootstrap\ActiveForm;

/**
 * @var yii\web\View $this
 * @var \app\modules\news\forms\NewsForm $newsForm
 */

?>

<?php $form = ActiveForm::begin() ?>
	<?= $form->field($newsForm->categories, 'ids')->dropDownList($newsForm->categories->getList(), ['multiple' => true]) ?>
    <?= $form->field($newsForm, 'title') ?>
    <?= $form->field($newsForm, 'text')->textarea(['rows' => 5]) ?>

	<div class="form-group">
		<button class="btn btn-success">Сохранить</button>
	</div>
<?php ActiveForm::end() ?>
