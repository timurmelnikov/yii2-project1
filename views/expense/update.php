<?php

use yii\helpers\Html;
use app\classes\Caption;

/* @var $this yii\web\View */
/* @var $model app\models\Expense */

//$this->title = $model::SECTION_TITLE;
$this->params['breadcrumbs'][] = ['label' => Caption::SECTION_EXPENSE, 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id];
$this->params['breadcrumbs'][] = ['label' => Caption::ACTION_UPDATE];
?>
<div class="expense-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
