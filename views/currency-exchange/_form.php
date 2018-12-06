<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use app\classes\Caption;
use kartik\money\MaskMoney;
use timurmelnikov\widgets\LoadingOverlayAsset;

/* @var $this yii\web\View */
/* @var $model app\models\CurrencyExchange */
/* @var $form yii\widgets\ActiveForm */

LoadingOverlayAsset::register($this);

?>

<div class="currency-exchange-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=
    $form->field($model, 'start_date')->widget(
            DatePicker::className(), [

        // 'language' => 'ru',
        'type' => DatePicker::TYPE_COMPONENT_APPEND,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]);
    ?>
    <?= $form->field($model, 'currency_id')->dropDownList(ArrayHelper::map(app\models\Currency::find()->all(), 'id', 'name'), ['prompt' => Caption::PROMPT_SELECT]) ?>
    <?= $form->field($model, 'number_units')->textInput() ?>
    <?=
    $form->field($model, 'official_exchange', [
        'addon' => [
            'append' => [
                'content' => Html::button(Caption::PROMPT_GET_CURRENCY, ['class' => 'btn btn-primary', 'id' => 'get-exchange']),
                'asButton' => true
            ]
        ]
    ])->widget(MaskMoney::classname(), [
        'pluginOptions' => [

            'prefix' => ' ',
            'precision' => 4,
            'allowZero' => true,
            'allowNegative' => false
        ],
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Caption::ACTION_CREATE : Caption::ACTION_UPDATE, ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Caption::ACTION_CANCEL, ['/currency-exchange'], [ 'class' => 'btn btn-warning',]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$message_error_name_currency = Caption::MESSAGE_ERROR_NAME_CURRENCY;
$message_error_get_currency = Caption::MESSAGE_ERROR_GET_CURRENCY;

//echo ShowLoading::widget(['loadingType' => 1]);
$url = Url::toRoute('/currency-exchange/get-exchange');
$script = <<<JS
$('#get-exchange').click(function () {
    if ($('#currencyexchange-currency_id').val() == '') {
        alert('$message_error_name_currency');
        throw "";
    }
     $.ajax({
        type: 'GET',
        url: '$url' + '?currency_id=' + $('#currencyexchange-currency_id').val(),
        // dataType: 'jsonp',
        success: function (json) {
            $('#currencyexchange-number_units').val($.parseJSON(json).size[0]);
            $('#currencyexchange-official_exchange-disp').val($.parseJSON(json).rate[0]);
            $('#currencyexchange-official_exchange-disp').focus();
        },
        error: function () {
            alert('$message_error_get_currency');
        }
    });
});

    //Наложение jQuery LoadingOverlay на элемент с ID #p0, при отправке AJAX-запроса
    $(document).ajaxSend(function(event, jqxhr, settings){
        $("#w0").LoadingOverlay("show");
    });
    //Скрытие jQuery LoadingOverlay на элемент с ID #p0, после выполнения AJAX-запроса
    $(document).ajaxComplete(function(event, jqxhr, settings){
        $("#w0").LoadingOverlay("hide");
    });

JS;
$this->registerJs($script);
?>