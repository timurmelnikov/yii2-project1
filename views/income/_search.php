<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\classes\Caption;

/* @var $this yii\web\View */
/* @var $model app\models\IncomeCategorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="income-search">

    <?php
    $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
    ]);
    ?>


    <?= $form->field($model, 'amount') ?>

    <?= $form->field($model, 'income_category_id') ?>

    <?= $form->field($model, 'date_oper') ?>

    <?= $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'account_id')   ?>

    <div class="form-group">
        <?= Html::submitButton(Caption::ACTION_SEARCH, ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Caption::ACTION_RESET, ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
