<?php

use yii\helpers\Html;
use app\classes\Caption;

/* @var $this yii\web\View */
/* @var $model app\models\AccountMove */

//$this->title = $model::SECTION_TITLE;
$this->params['breadcrumbs'][] = ['label' => Caption::SECTION_ACCOUNT_MOVE, 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Caption::ACTION_CREATE];
?>
<div class="account-move-create">


    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
