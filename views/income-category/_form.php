<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\Account;
use app\classes\Caption;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\IncomeCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="income-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>


    <?=
    $form->field($model, 'account_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Account::find()->where(['state' => Account::STATE_ACTIVE, 'user_id' => Yii::$app->user->identity->id])->all(), 'id', 'name'),
        'language' => 'ru',
        //'theme' => Select2::THEME_BOOTSTRAP,
        'options' => ['placeholder' => Caption::PROMPT_SELECT],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ])
    ?>

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
        <?= Html::a(Caption::ACTION_CANCEL, ['/income-category'], [ 'class' => 'btn btn-warning',]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
