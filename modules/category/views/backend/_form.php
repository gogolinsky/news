<?php

use yii\bootstrap\ActiveForm;

/**
 * @var \app\modules\category\forms\CategoryForm $categoryForm
 * @var array $dropDownArray
 * @var array $dropDownOptionsArray
 */

?>

<?php $form = ActiveForm::begin() ?>

    <?= $form->field($categoryForm, 'parent_id')->dropDownList($dropDownArray, $dropDownOptionsArray) ?>
    <?= $form->field($categoryForm, 'title') ?>

    <div class="form-group">
        <button class="btn btn-success">Сохранить</button>
    </div>

<?php $form::end() ?>