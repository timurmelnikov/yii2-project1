<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\classes\Caption;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\User;
use kartik\money\MaskMoney;

/* @var $this yii\web\View */
/* @var $model app\models\Account */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="account-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>


    <?=
    $form->field($model, 'current_sum')->widget(MaskMoney::classname(), [
        'pluginOptions' => [
            'prefix' => '₴ ',
            'allowZero' => true,
            'allowNegative' => false
        ]
    ]);
    ?>

    <?= $form->field($model, 'state')->dropDownList(['' => Caption::PROMPT_SELECT, \app\models\Account::STATE_ACTIVE => Caption::STATE_ACTIVE, \app\models\Account::STATE_CLOSE => Caption::STATE_CLOSE]) ?>





    <?php
//    echo $form->field($model, 'user_id')->widget(Select2::classname(), [
//        'data' => ArrayHelper::map(User::find()->all(), 'id', 'username'),
//        'language' => 'ru',
//        'options' => ['placeholder' => Caption::PROMPT_SELECT],
//        'pluginOptions' => [
//            'allowClear' => true,
//        ],
//    ])
    ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Caption::ACTION_CREATE : Caption::ACTION_UPDATE, ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Caption::ACTION_CANCEL, ['/account'], [ 'class' => 'btn btn-warning',]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
