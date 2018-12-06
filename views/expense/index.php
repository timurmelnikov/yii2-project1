<?php

use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use timurmelnikov\widgets\LoadingOverlayPjax;
use app\classes\Caption;
use app\models\User;
use app\models\ExpenseCategory;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ExpenseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = $searchModel::SECTION_TITLE;
$this->params['breadcrumbs'][] = Caption::SECTION_EXPENSE;
?>


<div class="expense-index">

    <p>
        <?= Html::a(Caption::ACTION_CREATE, ['create'], ['class' => 'btn btn-success']) ?>

        <?php //echo Html::a(Caption::ACTION_SEARCH_ADVANCED, ['#'], ['class' => 'btn btn-primary search-advanced-button'])  ?>
    </p>


    <div class="search-advanced-form" style="display:none">
        <?php //echo $this->render('_search', ['model' => $searchModel]);  ?>
    </div>

    <?php LoadingOverlayPjax::begin(['timeout' => 3000]); ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        //'responsiveWrap'=>FALSE,
        'columns' => [
                ['class' => 'yii\grid\SerialColumn',
                'options' => ['width' => '40px']
            ],
            //'id',
            [
                'attribute' => 'date_oper',
                'value' => 'date_oper',
                'options' => ['width' => '140px'],
            ],
                [
                'attribute' => 'expense_category_id',
                'value' => 'expenseCategory.name',
                // 'filter' => Html::activeDropDownList($searchModel, 'expense_category_id', ArrayHelper::map(ExpenseCategory::findAllForSelect(), 'id', 'name'), ['class' => 'form-control', 'prompt' => '']),
                'options' => ['width' => '250px'],
                'filter' => Select2::widget([
                    //'name' => 'expense_category_id',
                    'attribute' => 'expense_category_id',
                    'model' => $searchModel,
                    'data' => ArrayHelper::map(ExpenseCategory::findAllForSelect(), 'id', 'name'),
                    'options' => [
                        'placeholder' => '',
                    ],
                    'pluginOptions' =>
                        [
                        'allowClear' => true,
                    ],
                ]),
            ],
//            [
//                'attribute' => 'unit_id',
//                'value' => 'unit.name',
//            ],
//            'count_unit',
            'description',
                [
                'attribute' => 'cost',
                'value' => 'cost',
                'options' => ['width' => '140px'],
                'contentOptions' => ['style' => 'text-align: right; font-weight:bold; color: red'],
            ],
                [
                'attribute' => 'user_id',
                'value' => 'user.username',
                'options' => ['width' => '140px'],
                'filter' => Html::activeDropDownList($searchModel, 'user_id', ArrayHelper::map(User::find()->where("username != 'root'")->all(), 'id', 'username'), ['class' => 'form-control', 'prompt' => '']),
                'contentOptions' => ['style' => 'text-align: center;'],
                'visible' => Yii::$app->user->can('show_all'),
            ],
            // 'account_id',
            ['class' => \yii\grid\ActionColumn::className(),
                'header' => Caption::LABEL_ACTIONS,
                'options' => ['width' => '70px'],
                'contentOptions' => ['style' => 'text-align: center'],
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"/>', ['update', 'id' => $key], ['title' => Caption::ACTION_UPDATE, 'data-method' => 'post', 'data-pjax' => 0, 'class' => ($model->user_id == Yii::$app->user->id) ? null : 'link-disabled',]);
                    },
                    'rollback' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-arrow-left"/>', ['rollback', 'id' => $key], ['title' => Caption::ACTION_ROLLBACK, 'data-method' => 'post', 'data-pjax' => 0, 'class' => ($model->user_id == Yii::$app->user->id) ? null : 'link-disabled', 'data-confirm' => Caption::CONFIRM_ROLLBACK]);
                    },
                    'save_as_template' => function ($url, $model, $key) {

                        return Html::a('<span class="glyphicon glyphicon-save"/>', ['save-as-template', 'id' => $key], ['title' => Caption::ACTION_CREATE_TEMPLATE, 'data-method' => 'post', 'data-pjax' => 0, 'data-confirm' => Caption::CONFIRM_CREATE_TEMPLATE,]);
                    },
                ],
                'template' => '{save_as_template}  {update}  {rollback}'
            ],
        ],
    ]);
    ?>
    <?php LoadingOverlayPjax::end(); ?>
</div>
<?php
$script = <<<JS
$('.search-advanced-button').click(function () {
    $('.search-advanced-form').toggle('slow');
    return false;
});
JS;
$this->registerJs($script);
?>
