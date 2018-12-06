<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use timurmelnikov\widgets\LoadingOverlayPjax;
use yii\helpers\ArrayHelper;
use app\classes\Caption;
use app\models\Account;
use app\models\User;

/* @var $this yii\web\View */
/* @var $searchModel app\models\IncomeCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = Caption::SECTION_INCOME_CATEGORY;
?>

<div class="income-category-index">

    <p><?= Html::a(Caption::ACTION_CREATE, ['create'], ['class' => 'btn btn-success']) ?></p>

    <?php LoadingOverlayPjax::begin(['timeout' => 3000]); ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
                'options' => ['width' => '40px']
            ],
            //   'id',
            [
                'attribute' => 'name',
                'value' => 'name',
            ],
            [
                'attribute' => 'account_id',
                'value' => 'account.name',
                'filter' => Html::activeDropDownList($searchModel, 'account_id', ArrayHelper::map(Account::findAllAndUserName(Account::SHOW_USER), 'id', 'name'), ['class' => 'form-control', 'prompt' => '']),
                //'options' => ['width' => '42%']
            ],
            ['class' => \yii\grid\ActionColumn::className(),
                'header' => Caption::LABEL_ACTIONS,
                'options' => ['width' => '70px'],
                'contentOptions' => ['style' => 'text-align: center'],
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"/>', ['update', 'id' => $key], ['title' => Caption::ACTION_UPDATE, 'data-method' => 'post', 'data-pjax'=>0]);
                    },
                            'delete' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-trash"/>', ['delete', 'id' => $key], ['title' => Caption::ACTION_DELETE, 'data-method' => 'post', 'data-pjax'=>0, 'data-confirm' => Caption::CONFIRM_DELETE]);
                    },
                        ],
                        'template' => '{update}  {delete}'
                    ],
                ],
            ]);
            ?>
            <?php LoadingOverlayPjax::end(); ?>
</div>
