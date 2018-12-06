<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Account;
use app\models\User;
use app\classes\Caption;
use kartik\money\MaskMoney;

/* @var $this yii\web\View */
/* @var $model app\models\Income */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="income-form">

    <?php $form = ActiveForm::begin(); ?>



    <?=
    $form->field($model, 'date_oper')->widget(
            DatePicker::className(), [

        // 'language' => 'ru',
        'type' => DatePicker::TYPE_COMPONENT_APPEND,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]);
    ?>

    <?=
    $form->field($model, 'account_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Account::findAllAndCurrentSum(), 'id', 'name'),
        'language' => 'ru',
        'disabled' => $model->isNewRecord ? false : true,
        //'theme' => Select2::THEME_BOOTSTRAP,
        'options' => ['placeholder' => Caption::PROMPT_SELECT],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ])
    ?>

   
    <?=
    $form->field($model, 'amount')->widget(MaskMoney::classname(), [
        'pluginOptions' => [
            'prefix' => '₴ ',
            'allowZero' => true,
            'allowNegative' => false
        ]
    ]);
    ?>



    <?=
    $form->field($model, 'income_category_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(app\models\IncomeCategory::find()->where(['user_id' => Yii::$app->user->identity->id])->all(), 'id', 'name'),
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

    <?= $model->isNewRecord ? $form->field($model, 'continue')->checkbox() : null ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Caption::ACTION_CREATE : Caption::ACTION_UPDATE, ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Caption::ACTION_CANCEL, ['/income'], [ 'class' => 'btn btn-warning',]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
