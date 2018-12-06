<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use timurmelnikov\widgets\LoadingOverlayPjax;
use app\classes\Caption;
use yii\helpers\ArrayHelper;
use app\models\IncomeCategory;
use app\models\Account;
use app\models\User;

/* @var $this yii\web\View */
/* @var $searchModel app\models\IncomeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->params['breadcrumbs'][] = Caption::SECTION_INCOME;
?>

<div class="income-index">



    <p>
        <?= Html::a(Caption::ACTION_CREATE, ['create'], ['class' => 'btn btn-success']) ?>
        <?php //echo Html::a(Caption::ACTION_SEARCH_ADVANCED, ['#'], ['class' => 'btn btn-primary search-advanced-button']) ?>
    </p>


    <div class="search-advanced-form" style="display:none">
        <?php //echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>



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
            [
                'attribute' => 'date_oper',
                'value' => 'date_oper',
                'options' => ['width' => '140px'],
            ],
            [
                'attribute' => 'income_category_id',
                'value' => 'incomeCategory.name',
                'filter' => Html::activeDropDownList($searchModel, 'income_category_id', ArrayHelper::map(IncomeCategory::findAllAndUserName(), 'id', 'name'), ['class' => 'form-control', 'prompt' => '']),
                'options' => ['width' => '250px'],
            ],
            [
                'attribute' => 'account_id',
                'value' => 'account.name',
                'filter' => Html::activeDropDownList($searchModel, 'account_id', ArrayHelper::map(Account::findAllAndUserName(), 'id', 'name'), ['class' => 'form-control', 'prompt' => '']),
            ],
            [
                'attribute' => 'amount',
                'value' => 'amount',
                'options' => ['width' => '140px'],
                'contentOptions' => ['style' => 'text-align: right; font-weight:bold; color: red'],
            ],
            [
                'attribute' => 'user_id',
                'value' => 'user.username',
                'filter' => Html::activeDropDownList($searchModel, 'user_id', ArrayHelper::map(User::find()->where("username != 'root'")->all(), 'id', 'username'), ['class' => 'form-control', 'prompt' => '']),
                'options' => ['width' => '140px'],
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
                        return Html::a('<span class="glyphicon glyphicon-pencil"/>', ['update', 'id' => $key], ['title' => Caption::ACTION_UPDATE, 'data-method' => 'post', 'data-pjax'=>0, 'class' => ($model->user_id == Yii::$app->user->id) ? null : 'link-disabled',]);
                    },
                            'rollback' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-arrow-left"/>', ['rollback', 'id' => $key], ['title' => Caption::ACTION_ROLLBACK, 'data-method' => 'post', 'data-pjax'=>0, 'class' => ($model->user_id == Yii::$app->user->id) ? null : 'link-disabled', 'data-confirm' => Caption::CONFIRM_ROLLBACK]);
                    },
                        ],
                        'template' => '{update}  {rollback}'
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
