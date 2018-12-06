<?php

use app\classes\Caption;

/* @var $this yii\web\View */
/* @var $model app\models\User */
$this->params['breadcrumbs'][] = ['label' => Caption::SECTION_USER, 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username];
$this->params['breadcrumbs'][] = ['label' => Caption::ACTION_UPDATE];
?>
<div class="user-update">

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
