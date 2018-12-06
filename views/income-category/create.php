<?php
/* @var $this yii\web\View */
/* @var $model app\models\IncomeCategory */

use yii\helpers\Html;
use app\classes\Caption;

//$this->title = $model::SECTION_TITLE;
$this->params['breadcrumbs'][] = ['label' => Caption::SECTION_INCOME_CATEGORY, 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Caption::ACTION_CREATE];
?>
<div class="income-category-create">



    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
