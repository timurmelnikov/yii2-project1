<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use timurmelnikov\widgets\LoadingOverlayPjax;
use app\models\User;
use app\classes\Caption;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->params['breadcrumbs'][] = Caption::SECTION_USER;
?>

<div class="user-index">



    <p><?= Html::a(Caption::ACTION_CREATE, ['create'], ['class' => 'btn btn-success']) ?></p>


    <?php LoadingOverlayPjax::begin(['timeout' => 3000]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model) {
            if ($model->id == Yii::$app->user->id) {
                return ['class' => 'info'];
            } else if ($model->state == User::STATE_BAN) {
                return ['class' => 'danger'];
            } else if ($model->state == User::STATE_ACTIVE) {
                //return ['class' => 'success'];
            };
        },
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn',
                        'options' => ['width' => '40px']
                    ],
                    // ['class' => 'yii\grid\CheckboxColumn'],
                    //'id',
                    [
                        'attribute' => 'username',
                        'value' => 'username',
                        'options' => ['width' => '140px'],
                    ],
                    'fullname',
                    [
                        'attribute' => 'state',
                        'options' => ['width' => '140px'],
                        'value' => function ($data) {
                    return $data->state == User::STATE_ACTIVE ? Caption::STATE_ACTIVE : ($data->state == User::STATE_BAN ? Caption::STATE_BAN : "");
                },
                        'filter' => Html::activeDropDownList($searchModel, 'state', [User::STATE_ACTIVE => Caption::STATE_ACTIVE, User::STATE_BAN => Caption::STATE_BAN], ['class' => 'form-control', 'prompt' => '']),
                        'contentOptions' => ['style' => 'text-align: center;'],
                    //'options' => ['width' => '150px'],
                    ],
                    ['class' => \yii\grid\ActionColumn::className(),
                        'header' => Caption::LABEL_ACTIONS,
                        'options' => ['width' => '90px'],
                        'contentOptions' => ['style' => 'text-align: center'],
                        'buttons' => [

                            'password' => function ($url, $model, $key) {
                                return Html::a('<img src=' . Yii::$app->request->baseUrl . '/images/password.png >', ['password', 'id' => $key], ['title' => Caption::ACTION_USER_PASSWORD, 'data-method' => 'post']);
                            },
                                    'permission' => function ($url, $model, $key) {
                                return Html::a('<span class="glyphicon glyphicon-user"/>', ['permission', 'id' => $key], ['title' => Caption::ACTION_USER_ROLE, 'data-method' => 'post']); //Сделать - 'data-method' => 'post', !!!!!!!!!!!!!!!!
                            },
                                    'update' => function ($url, $model, $key) {
                                return Html::a('<span class="glyphicon glyphicon-pencil"/>', ['update', 'id' => $key], ['title' => Caption::ACTION_UPDATE, 'data-method' => 'post']);
                            },
                                    'delete' => function ($url, $model, $key) {
                                return Html::a('<span class="glyphicon glyphicon-trash"/>', ['delete', 'id' => $key], ['title' => Caption::ACTION_DELETE, 'data-method' => 'post',  'data-confirm' => Caption::CONFIRM_DELETE]);
                            },
                                ],
                                'template' => '{password} {permission} {update} {delete}'
                            ],
                        ],
                    ]);
                    ?>
                    <?php LoadingOverlayPjax::end(); ?>

</div>