<?php

use yii\helpers\Html;
use app\classes\Caption;

/* @var $this yii\web\View */
/* @var $model app\models\ExpenseTemplate */

//$this->title = $model::SECTION_TITLE;
$this->params['breadcrumbs'][] = ['label' => Caption::SECTION_EXPENSE_TEMPLATE, 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Caption::ACTION_CREATE];
?>
<div class="expense-template-create">


    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
