<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\ExpenseCategory;
use app\classes\Caption;

/* @var $this yii\web\View */
/* @var $model app\models\ExpenseCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="expense-category-form">

<?php $form = ActiveForm::begin(); ?>


    <?=
    $form->field($model, 'parent_id')->widget(Select2::classname(), [
        //'data' => $model->isNewRecord ? ArrayHelper::map(ExpenseCategory::findAllForSelect(2), 'id', 'name') : ArrayHelper::map(ExpenseCategory::findAllForSelect(3, $model->id), 'id', 'name'),
        'data' => $model->isNewRecord ? ArrayHelper::map(ExpenseCategory::findAllForSelect(2), 'id', 'name') : ArrayHelper::map(ExpenseCategory::findAllForSelect(2), 'id', 'name'),
        'language' => 'ru',
        //'theme' => Select2::THEME_BOOTSTRAP,
        'options' => [
        //'placeholder' => Caption::PROMPT_SELECT //В данной форме не имеет смысла (в любом случае категория выбрана)
        ],
        'pluginOptions' => [
        //'allowClear' => true,
        ],
    ])
    ?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Caption::ACTION_CREATE : Caption::ACTION_UPDATE, ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
<?= Html::a(Caption::ACTION_CANCEL, ['/expense-category', 'parent_id' => $model->parent_id], [ 'class' => 'btn btn-warning',]) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
