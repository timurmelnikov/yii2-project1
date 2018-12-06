<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use timurmelnikov\widgets\LoadingOverlayPjax;
use app\models\User;
use app\classes\Caption;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->params['menuItems'] = [
    ['label' => 'Назад', 'url' => ['/user']],
];
?>

<div class="user-permission">

    <?php
    LoadingOverlayPjax::begin(['timeout' => 3000]);

    //Чтобы обрабатывать заголовок через AJAX


    $this->params['breadcrumbs'][] = ['label' => Caption::SECTION_USER_PERMISSION, 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => $user_model->username];
    ?>

    <?=
    GridView::widget([
        //'condensed' => false,
        'dataProvider' => $dataProvider,
        'layout' => '{items}',
        'rowOptions' => function ($model) use ($user_model) {


            if (!User::hasRole($user_model->id, $model->name)) {
                return ['class' => 'danger'];
            } else if (User::hasRole($user_model->id, $model->name)) {
                return ['class' => 'success'];
            }
        },
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn',
                        'options' => ['width' => '40px']
                    ],
                    [
                        'header' => Caption::LABEL_ROLE,
                        'value' => function ($data) {

                            return $data->description;
                        }
                    ],
                    [
                        'header' => Caption::LABEL_ROLE_APPOINTED,
                        'value' => function($data) use ($user_model) {
                            if (User::hasRole($user_model->id, $data->name)) {
                                return Caption::STATE_YES;
                            } else {
                                return Caption::STATE_NO;
                            }
                        },
                    ],
                    ['class' => \yii\grid\ActionColumn::className(),
                        'header' => Caption::LABEL_ACTIONS,
                        'options' => ['width' => '90px'],
                        'contentOptions' => ['style' => 'text-align: center'],
                        'buttons' => [

                            'add' => function ($url, $model, $key) use ($user_model) {

                                if (!User::hasRole($user_model->id, $model->name)) {
                                    return Html::a('<span class="glyphicon glyphicon-plus"/>', ['role-assignment', 'id' => $user_model->id, 'role' => $model->name, 'action' => 1], ['title' => Caption::ACTION_USER_ROLE_ADD]);
                                }
                            },
                                    'rem' => function ($url, $model, $key) use ($user_model) {

                                if (User::hasRole($user_model->id, $model->name)) {

                                    return Html::a('<span class="glyphicon glyphicon-minus"/>', ['role-assignment', 'id' => $user_model->id, 'role' => $model->name, 'action' => 0], ['title' => Caption::ACTION_USER_ROLE_REMOVE]);
                                }
                            },
                                ],
                                'template' => '{add} {rem}',
                            ],
                        ],
                    ]);
                    ?>
                    <?php LoadingOverlayPjax::end(); ?>

                    <p>

                        <?= Html::a(Caption::ACTION_BACK, ['/user'], [ 'class' => 'btn btn-warning',]) ?>
    </p>


</div>
