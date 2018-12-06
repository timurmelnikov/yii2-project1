<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\Account;
use app\models\Unit;
use app\models\User;
use app\models\ExpenseCategory;
use app\classes\Caption;
use kartik\money\MaskMoney;

/* @var $this yii\web\View */
/* @var $model app\models\Expense */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="expense-form">

    <?php
    $form = ActiveForm::begin([
                //'enableClientValidation' => FALSE,
                'enableAjaxValidation' => TRUE,
    ]);
    ?>


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
     
        'options' => ['placeholder' => Caption::PROMPT_SELECT],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ])
    ?>


    <?=
    $form->field($model, 'cost', [
        'addon' => [
            'append' => [
                'content' => Html::button('<span class="glyphicon glyphicon-plus"></span>', ['class' => 'btn btn-default', 'id' => 'unit-edit-button', 'title' => Caption::SECTION_UNIT]),
                'asButton' => true
            ]
        ]
    ])->widget(MaskMoney::classname(), [
        'pluginOptions' => [
            'prefix' => '₴ ',
            'allowZero' => true,
            'allowNegative' => false,
        ],
        'disabled' => $model->isNewRecord ? false : true,
    ]);
    ?>


    <div id="unit-edit" class="row" style="display:none">
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
//        'addon' => [
//            'append' => [
//                'content' => Html::button('<span class="glyphicon glyphicon-plus"></span>', ['class' => 'btn btn-default', 'id' => 'expense-category-add-button', 'title' => Caption::ACTION_NEW_CATEGORY]),
//                'asButton' => true
//            ]
//        ]
    ])
    ?>


    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $model->isNewRecord ? $form->field($model, 'continue')->checkbox() : null ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Caption::ACTION_CREATE : Caption::ACTION_UPDATE, ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Caption::ACTION_CANCEL, ['/expense'], [ 'class' => 'btn btn-warning',]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
$script = <<<JS
//Показываем единицы измерения при ошибках их валидации (ajax) 
$($(":submit")).on('click', function () {
    if ($(".field-expense-count_unit").hasClass("has-error") || $(".field-expense-unit_id").hasClass("has-error")) {
        showUnit();
    }
});

//Показываем единицы измерения при ошибках их валидации (перезагрузка формы)  
if ($(".field-expense-count_unit").hasClass("has-error") || $(".field-expense-unit_id").hasClass("has-error")) {
    showUnit();
}

//Показываем единицы измерения при нажатии на кнопку
$('#unit-edit-button').click(function () {
    showUnit();
});

function showUnit() {
    //Изменяем значек на кнопке    
    if ($('#unit-edit').css('display') === 'block') {
        $("#unit-edit-button span").removeClass("glyphicon-minus");
        $("#unit-edit-button span").addClass("glyphicon-plus");
    } else {
        $("#unit-edit-button span").removeClass("glyphicon-plus");
        $("#unit-edit-button span").addClass("glyphicon-minus");
    }
    //Показываем поле    
    $('#unit-edit').slideToggle(150);
}
JS;

$this->registerJs($script);
?>
