<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\classes\Caption;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\ExpenseCategory;

/* @var $this yii\web\View */
/* @var $model app\models\ExpenseSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="expense-search">

    <?php
    $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
    ]);
    ?>



    <?= $form->field($model, 'cost') ?>

    <?= $form->field($model, 'unit_id') ?>

    <?= $form->field($model, 'count_unit') ?>

    <?php // echo $form->field($model, 'expense_category_id') ?>


    <?php
//    echo $form->field($model, 'expense_category_id')->widget(Select2::classname(), [
//        'data' => ArrayHelper::map(ExpenseCategory::findAllForSelect(), 'id', 'name'),
//        'language' => 'ru',
//        //'theme' => Select2::THEME_BOOTSTRAP,
//        'options' => ['placeholder' => Caption::PROMPT_SELECT],
//        'pluginOptions' => [
//            'allowClear' => true,
//        ],
//    ])
    ?>

    <?php // echo $form->field($model, 'description')   ?>

    <?php // echo $form->field($model, 'date_oper')   ?>

    <?php // echo $form->field($model, 'user_id')   ?>

    <?php // echo $form->field($model, 'account_id')    ?>

    <div class="form-group">
        <?= Html::submitButton(Caption::ACTION_SEARCH, ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Caption::ACTION_RESET, ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
