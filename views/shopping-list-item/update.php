<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ShoppingListItem */

$this->title = 'Update Shopping List Item: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Shopping List Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="shopping-list-item-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
