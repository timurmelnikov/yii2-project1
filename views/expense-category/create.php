<?php

use yii\helpers\Html;
use app\classes\Caption;

/* @var $this yii\web\View */
/* @var $model app\models\ExpenseCategory */


$this->params['breadcrumbs'][] = ['label' => Caption::SECTION_EXPENSE_CATEGORY, 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Caption::ACTION_CREATE];
?>
<div class="expense-category-create">


    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
