<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use timurmelnikov\widgets\LoadingOverlayPjax;
use app\classes\Caption;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ExpenseCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->params['breadcrumbs'][] = Caption::SECTION_EXPENSE_CATEGORY;
?>


<?php
//$title = Caption::SECTION_EXPENSE_CATEGORY;
//if (Yii::$app->session->getFlash('update-success')) {
//    echo GrowlSuccess::widget([
//        'title' => $title,
//        'body' => Yii::$app->session->getFlash('update-success'),
//    ]);
//}
//if (Yii::$app->session->getFlash('create-success')) {
//    echo GrowlSuccess::widget([
//        'title' => $title,
//        'body' => Yii::$app->session->getFlash('create-success'),
//    ]);
//}
//if (Yii::$app->session->getFlash('delete-success')) {
//    echo GrowlSuccess::widget([
//        'title' => $title,
//        'body' => Yii::$app->session->getFlash('delete-success'),
//    ]);
//}
//if (Yii::$app->session->getFlash('delete-error')) {
//    echo GrowlError::widget([
//        'title' => $title,
//        'body' => Yii::$app->session->getFlash('delete-error'),
//    ]);
//}
?>



<div class="expense-category-index">

    <?php LoadingOverlayPjax::begin(['timeout' => 3000]); ?>
    <p>
        <?= Html::a(Caption::ACTION_CREATE_CURRENT, ['create', 'parent_id' => $searchModel->parent_id], ['class' => 'btn btn-success', 'data-pjax' => 0]) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
                'options' => ['width' => '40px']
            ],
            [
                'header' => ($searchModel->parent_id != 0) ? Html::a('<span class="glyphicon glyphicon-home"></span> ', ['/expense-category'], ['title' => Caption::ACTION_GO_ROOT]) . Html::a($searchModel->getAttributeLabel('parent_id'), ['/expense-category', 'parent_id' => $searchModel->getParentId()]) : $searchModel->getAttributeLabel('parent_id'),
                'format' => 'html',
                'value' => function($data) {
            return ($data->parent_id != 0) ? Html::a($data->parent->name, ['/expense-category', 'parent_id' => $data->parent->parent_id]) : '';
        },
            ],
            //'path',
            [
                'label' => $searchModel->getAttributeLabel('name'),
                'attribute' => 'name',
                'enableSorting' => TRUE,
                'filter' => TRUE,
                'format' => 'html',
                'value' => function($data) {
                    return ($data->getCountSubitems($data->id) != 0) ? Html::a($data->name, ['/expense-category', 'parent_id' => $data->id]) . '<span class="badge pull-right">' . $data->getCountSubitems($data->id) . '</span>' : Html::a($data->name, ['/expense-category', 'parent_id' => $data->id]);
                },
                    //'options' => ['width' => '42%']
                    ],
                    ['class' => \yii\grid\ActionColumn::className(),
                        'header' => Caption::LABEL_ACTIONS,
                        'options' => ['width' => '70px'],
                        'contentOptions' => ['style' => 'text-align: center'],
                        'buttons' => [
                            'update' => function ($url, $model, $key) {
                                return Html::a('<span class="glyphicon glyphicon-pencil"/>', ['update', 'id' => $key, 'parent_id' => $model->parent_id], ['title' => Caption::ACTION_UPDATE, 'data-method' => 'post', 'data-pjax' => 0]);
                            },
                                    'delete' => function ($url, $model, $key) {
                                return Html::a('<span class="glyphicon glyphicon-trash"/>', ['delete', 'id' => $key, 'parent_id' => $model->parent_id], ['title' => Caption::ACTION_DELETE, 'data-method' => 'post', 'data-pjax' => 0, 'data-confirm' => Caption::CONFIRM_DELETE]);
                            },
                                ],
                                'template' => '{update}  {delete}'
                            ],
                        ],
                    ]);
                    ?>
                    <?php LoadingOverlayPjax::end(); ?>
</div>
