<?php

use yii\helpers\Html;
use app\classes\Caption;

/* @var $this yii\web\View */
/* @var $model app\models\CurrencyExchange */

//$this->title = $model::SECTION_TITLE;
$this->params['breadcrumbs'][] = ['label' => Caption::SECTION_CURRENCY_EXCHANGE, 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Caption::ACTION_CREATE];
?>
<div class="currency-exchange-create">

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
