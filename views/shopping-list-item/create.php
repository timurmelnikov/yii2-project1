<?php

use yii\helpers\Html;
use app\classes\Caption;

/* @var $this yii\web\View */
/* @var $model app\models\ShoppingListItem */

$this->title = 'Create Shopping List Item';
$this->params['breadcrumbs'][] = ['label' => 'Shopping List Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="shopping-list-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
