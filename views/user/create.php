<?php

use app\classes\Caption;

/* @var $this yii\web\View */
/* @var $model app\models\User */



$this->params['breadcrumbs'][] = ['label' => Caption::SECTION_USER, 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Caption::ACTION_CREATE];

$this->params['menuItems'] = [
    ['label' => 'Назад', 'url' => ['/user']],
];
?>
<div class="user-create">

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
