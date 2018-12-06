<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\classes\Caption;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ShoppingListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Shopping Lists';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="shopping-list-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Shopping List', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',
            'date_list',
            'user_from',
            'user_to',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
