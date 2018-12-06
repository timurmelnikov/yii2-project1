<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use timurmelnikov\widgets\LoadingOverlayPjax;
use yii\helpers\ArrayHelper;
use app\classes\Caption;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CurrencyExchangeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->params['breadcrumbs'][] = Caption::SECTION_CURRENCY_EXCHANGE;

?>


<div class="unit-index">

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
            // 'id',
            [
                'attribute' => 'start_date',
                'options' => ['width' => '140px'],
                'format' => ['date', 'php:d.m.Y']
            ],
            [
                'attribute' => 'currency_id',
                'value' => 'currency.fullname',
                'filter' => Html::activeDropDownList($searchModel, 'currency_id', ArrayHelper::map(app\models\Currency::find()->all(), 'id', 'name'), ['class' => 'form-control', 'prompt' => '']),
            //'contentOptions' => ['style' => 'text-align: center;'],
            ],
            [
                'attribute' => 'number_units',
                'value' => 'number_units',
                'options' => ['width' => '140px'],
                'contentOptions' => ['style' => 'text-align: center'],
            //'options' => ['width' => '150px'],
            ],
            [
                'attribute' => 'official_exchange',
                'value' => 'official_exchange',
                'options' => ['width' => '140px'],
                'contentOptions' => ['style' => 'text-align: right; font-weight:bold; color: red'],
            //'options' => ['width' => '150px'],
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
