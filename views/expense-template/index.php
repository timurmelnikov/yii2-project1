<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use timurmelnikov\widgets\LoadingOverlayPjax;
use app\classes\Caption;
use yii\helpers\ArrayHelper;
use app\models\User;
use app\models\Unit;
use app\models\ExpenseCategory;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ExpenseTemplateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->params['breadcrumbs'][] = Caption::SECTION_EXPENSE_TEMPLATE;
?>

<div class="expense-template-index">

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
            //'id',
            //'name',
            [
                'attribute' => 'name',
                'value' => 'name',
                'options' => ['width' => '240px'],
            ],
            [
                //'attribute' => 'account_from',
                'label' => Caption::LABEL_TEMPLATE_CONTENT,
                'value' => function($data) {

                    return
                            $data->expenseCategory->name . ': '
                            . $data->count_unit . '-'
                            . $data->unit->name . ', '
                            . $data->cost . ' ('
                            . $data->account->name . ') '
                            . ($data->description ? '. ' . $data->description : '');
                },
                'filter' => false,
            //'options' => ['width' => '140px'],
            ],
//            [
//                'attribute' => 'account_id',
//                'value' => 'account.name',
//            ],
//            [
//                'attribute' => 'expense_category_id',
//                'value' => 'expenseCategory.name',
//            ],
//            [
//                'attribute' => 'count_unit',
//                'value' => 'count_unit',
//            ],
//            [
//                'attribute' => 'unit_id',
//                'value' => 'unit.name',
//            ],
//            [
//                'attribute' => 'cost',
//                'value' => 'cost',
//                'options' => ['width' => '140px'],
//                'contentOptions' => ['style' => 'text-align: right; font-weight:bold; color: red'],
//            ],
//            'description',
            ['class' => \yii\grid\ActionColumn::className(),
                'header' => Caption::LABEL_ACTIONS,
                'options' => ['width' => '70px'],
                'contentOptions' => ['style' => 'text-align: center'],
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"/>', ['update', 'id' => $key], ['title' => Caption::ACTION_DELETE, 'data-method' => 'post', 'data-pjax'=>0]);
                    },
                            'delete' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-trash"/>', ['delete', 'id' => $key], ['title' => Caption::ACTION_UPDATE, 'data-method' => 'post', 'data-pjax'=>0, 'data-confirm' => Caption::CONFIRM_DELETE]);
                    },
                        ],
                        'template' => '{update}  {delete}'
                    ],
                ],
            ]);
            ?>
            <?php LoadingOverlayPjax::end(); ?>
</div>
