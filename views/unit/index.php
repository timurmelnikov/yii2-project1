<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use timurmelnikov\widgets\LoadingOverlayPjax;
use app\classes\Caption;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UnitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->params['breadcrumbs'][] = Caption::SECTION_UNIT;
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
            'name',
            'fullname',
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
