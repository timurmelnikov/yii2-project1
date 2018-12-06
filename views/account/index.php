<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use timurmelnikov\widgets\LoadingOverlayPjax;
use app\models\Account;
use app\models\User;
use app\classes\Caption;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AccountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->params['breadcrumbs'][] = Caption::SECTION_ACCOUNT;
?>


<div class="account-index">


    <p><?= Html::a(Caption::ACTION_CREATE, ['create'], ['class' => 'btn btn-success']) ?></p>

    <?php LoadingOverlayPjax::begin(['timeout' => 3000]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model) {
            if ($model->state == Account::STATE_CLOSE) {
                return ['class' => 'danger'];
            } else if ($model->state == Account::STATE_ACTIVE) {
                //return ['class' => 'success'];
            }
        },
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn',
                        'options' => ['width' => '40px']
                    ],
                    // 'id',
                    'name',
                    [
                        'attribute' => 'state',
                        'value' => function ($data) {

                            return $data->state == 0 ? Caption::STATE_ACTIVE : ($data->state == 1 ? Caption::STATE_CLOSE : null);
                        },
                        'filter' => Html::activeDropDownList($searchModel, 'state', [Account::STATE_ACTIVE => Caption::STATE_ACTIVE, Account::STATE_CLOSE => Caption::STATE_CLOSE], ['class' => 'form-control', 'prompt' => '']),
                        'options' => ['width' => '140px'],
                        'contentOptions' => ['style' => 'text-align: center;'],
                    ],
                    [
                        'attribute' => 'current_sum',
                        'value' => 'current_sum',
                        'contentOptions' => ['style' => 'text-align: right; font-weight:bold; color: red'],
                        'options' => ['width' => '140px'],
                    ],
                    [
                        'attribute' => 'user_id',
                        'value' => 'user.username',
                        'filter' => Html::activeDropDownList($searchModel, 'user_id', ArrayHelper::map(User::find()->where("username != 'root'")->all(), 'id', 'username'), ['class' => 'form-control', 'prompt' => '']),
                        'options' => ['width' => '140px'],
                        'contentOptions' => ['style' => 'text-align: center;'],
                        'visible' => Yii::$app->user->can('show_all'),
                    ],
                    ['class' => \yii\grid\ActionColumn::className(),
                        'header' => Caption::LABEL_ACTIONS,
                        'options' => ['width' => '70px'],
                        'contentOptions' => ['style' => 'text-align: center'],
                        'buttons' => [
                            'update' => function ($url, $model, $key) {

                                return Html::a('<span class="glyphicon glyphicon-pencil"/>', ['update', 'id' => $key], ['title' => Caption::ACTION_UPDATE,
                                            'data-method' => 'post',
                                            'data-pjax' => 0,
                                            'class' => ($model->user_id == Yii::$app->user->id) ? null : 'link-disabled'
                                ]);
                            },
                                    'delete' => function ($url, $model, $key) {

                                return Html::a('<span class="glyphicon glyphicon-trash"/>', ['delete', 'id' => $key], ['title' => Caption::ACTION_DELETE,
                                            'data-method' => 'post',
                                            'data-pjax' => 0,
                                            'class' => ($model->user_id == Yii::$app->user->id) ? null : 'link-disabled',
                                            'data-confirm' => Caption::CONFIRM_DELETE]);
                            },
                                ],
                                'template' => '{update}  {delete}'
                            ],
                        ],
                    ]);
                    ?>
                    <?php LoadingOverlayPjax::end(); ?>
</div>
