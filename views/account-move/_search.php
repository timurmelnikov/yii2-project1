<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\classes\Caption;

/* @var $this yii\web\View */
/* @var $model app\models\AccountMoveSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="account-move-search">

    <?php
    $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
    ]);
    ?>



    <?= $form->field($model, 'account_from') ?>

    <?= $form->field($model, 'account_to') ?>

    <?= $form->field($model, 'move_sum') ?>

    <?= $form->field($model, 'date_oper') ?>

    <?php // echo $form->field($model, 'user_id')  ?>

    <?php // echo $form->field($model, 'description') ?>

    <div class="form-group">
        <?= Html::submitButton(Caption::ACTION_SEARCH, ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Caption::ACTION_RESET, ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
