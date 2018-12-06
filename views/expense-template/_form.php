<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\classes\Caption;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\User;
use app\models\Unit;
use app\models\ExpenseCategory;
use kartik\money\MaskMoney;
use app\models\Account;

/* @var $this yii\web\View */
/* @var $model app\models\ExpenseTemplate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="expense-template-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?=
    $form->field($model, 'account_id')->widget(Select2::classname(), [
        //'data' => ArrayHelper::map(Wallet::find()->where(['state' => Wallet::STATE_ACTIVE, 'user_id' => Yii::$app->user->identity->id])->all(), 'id', 'name'),
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
    $form->field($model, 'cost')->widget(MaskMoney::classname(), [
        'pluginOptions' => [
            'prefix' => '₴ ',
            'allowZero' => true,
            'allowNegative' => false
        ]
    ]);
    ?>

    
    
    
    
    
        <div class="row" >
        <div class="col-lg-6 col-md-6 col-sm-6">
            <?=
            $form->field($model, 'count_unit')->widget(MaskMoney::classname(), [
                'pluginOptions' => [
                    'allowZero' => true,
                    'allowNegative' => false
                ]
            ]);
            ?>


        </div> 
        <div class="col-lg-6 col-md-6 col-sm-6">
            <?=
            $form->field($model, 'unit_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Unit::find()->all(), 'id', 'fullname'),
                'language' => 'ru',
                'options' => ['placeholder' => Caption::PROMPT_SELECT],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])
            ?>
        </div> 
    </div>
    
    
    
    
    
    
    
    <?=
    $form->field($model, 'expense_category_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(ExpenseCategory::findAllForSelect(), 'id', 'name'),
        'language' => 'ru',
        //'theme' => Select2::THEME_BOOTSTRAP,
        'options' => ['placeholder' => Caption::PROMPT_SELECT],
        'pluginOptions' => [
            'allowClear' => true,
        ],
        'addon' => [
            'append' => [
                'content' => Html::button('<span class="glyphicon glyphicon-plus"></span>', ['class' => 'btn btn-default', 'id' => 'categoryexp-add-button', 'title' => Caption::ACTION_NEW_CATEGORY]),
                'asButton' => true
            ]
        ]
    ])
    ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

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
        <?= Html::a(Caption::ACTION_CANCEL, ['/expense-template'], [ 'class' => 'btn btn-warning',]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
