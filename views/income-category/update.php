<?php

use yii\helpers\Html;
use app\classes\Caption;
/* @var $this yii\web\View */
/* @var $model app\models\IncomeCategory */

//$this->title = $model::SECTION_TITLE;
$this->params['breadcrumbs'][] = ['label' => Caption::SECTION_INCOME_CATEGORY, 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name];
$this->params['breadcrumbs'][] = ['label' => Caption::ACTION_UPDATE];
?>
<div class="income-category-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
