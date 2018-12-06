<?php

use yii\bootstrap\Collapse;
use yii\bootstrap\ButtonDropdown;
use yii\bootstrap\ButtonGroup;
use yii\helpers\Html;
use app\models\ExpenseTemplate;
use app\classes\Caption;
use app\models\Account;
use yii\widgets\ListView;
use yii\widgets\Pjax;

//use kartik\daterange\DateRangePicker;
?>
<div class="site-index">
    <div class="body-content">
        <div class="col-md-3 col-lg-3">
            <img class="visible-md visible-lg" src="<?= Yii::$app->request->baseUrl . '/images/logo.png'; ?>" style='width: 100%' alt="<?= Yii::$app->name; ?>">
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title"><?= Caption::SECTION_SHOPPING_LIST_MY ?></div>
                </div> 
                <div class="panel-body">
             
                </div>
            </div>
             
            <div class="visible-md visible-lg panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title"><?= Caption::SECTION_MY_BALANCE ?></div>
                </div> 
                <?php Pjax::begin(['timeout' => 3000]); ?>
                <div class="panel-body">
                    <table class="table table-condensed borderless">
                        <td style="font-weight:bold;">Всего:</td>
                        <td align="right" style="font-weight:bold; color: red"><?= Account::find()->where(['user_id' => Yii::$app->user->identity->id])->sum('current_sum') ?></td>
                        <?php
                        echo ListView::widget([
                            'dataProvider' => $dataProvider,
                            'itemView' => '_balances-list',
                            'layout' => "{items}\n<tr><td>{pager}</td><td></td></tr>",
                        ]);
                        ?>
                    </table>     
                </div>
                <?php Pjax::end(); ?>                     
            </div>

        </div>


        <div class="col-md-9 col-lg-9">

            <!-- Блок управления -->
            <?php
//Расходы
            $expense = ButtonGroup::widget([
                        'buttons' => [
                            Html::a(Caption::ACTION_IN_SECTION, ['/expense'], [
                                'class' => 'btn btn-success',
                                'title' => Caption::ACTION_IN_SECTION,
                                'options' => [
                                //'style' => "width:100%"
                                ]
                                    ]
                            ),
                            Html::a(Caption::ACTION_CREATE, ['/expense/create'], [
                                'class' => 'btn btn-primary',
                                'title' => Caption::ACTION_CREATE,
                                'options' => [
                                //'style' => "width:100%"
                                ]
                                    ]
                            ),
                            //Если шаблон есть, показываем кнопку
                            ExpenseTemplate::findDropdownItems() !== [] ? ButtonDropdown::widget([
                                'label' => Caption::ACTION_FROM_TEMPLATE,
                                //'split' => TRUE,
                                'dropdown' => [
                                    'items' => ExpenseTemplate::findDropdownItems(),
                                ],
                                'options' => [
                                    //'style' => "width:100px",

                                    'class' => 'btn-primary',
                                    'title' => Caption::ACTION_FROM_TEMPLATE]
                            ]) : null,
                        ],
                        'options' => [
                            'class' => 'btn-group-justified',
                        ]
            ]);

//Доходы
            $income = ButtonGroup::widget([
                        'buttons' => [
                            Html::a(Caption::ACTION_IN_SECTION, ['/income'], [
                                'class' => 'btn btn-success',
                                'title' => Caption::ACTION_IN_SECTION,
                                'options' => [
                                //'style' => "width:100%"
                                ]
                                    ]
                            ),
                            Html::a(Caption::ACTION_CREATE, ['/income/create'], [
                                'class' => 'btn btn-primary',
                                'title' => Caption::ACTION_CREATE,
                                'options' => [
                                //'style' => "width:100%"
                                ]
                                    ]
                            ),
                        ],
                        'options' => [
                            'class' => 'btn-group-justified',
                        ]
            ]);

//Кошельки
            $account = ButtonGroup::widget([
                        'buttons' => [
                            Html::a(Caption::ACTION_IN_SECTION, ['/account'], [
                                'class' => 'btn btn-success',
                                'title' => Caption::ACTION_IN_SECTION,
                                'options' => [
                                //'style' => "width:100%"
                                ]
                                    ]
                            ),
                            Html::a(Caption::ACTION_CREATE, ['/account/create'], [
                                'class' => 'btn btn-primary',
                                'title' => Caption::ACTION_CREATE,
                                'options' => [
                                //'style' => "width:100%"
                                ]
                                    ]
                            ),
                        ],
                        'options' => [
                            'class' => 'btn-group-justified',
                        ]
            ]);

//Перемещения
            $account_move = ButtonGroup::widget([
                        'buttons' => [
                            Html::a(Caption::ACTION_IN_SECTION, ['/account-move'], [
                                'class' => 'btn btn-success',
                                'title' => Caption::ACTION_IN_SECTION,
                                'options' => [
                                //'style' => "width:100%"
                                ]
                                    ]
                            ),
                            Html::a(Caption::ACTION_CREATE, ['/account-move/create'], [
                                'class' => 'btn btn-primary',
                                'title' => Caption::ACTION_CREATE,
                                'options' => [
                                //'style' => "width:100%"
                                ]
                                    ]
                            ),
                        ],
                        'options' => [
                            'class' => 'btn-group-justified',
                        ]
            ]);



            //Список покупок
            $shopping_list = ButtonGroup::widget([
                        'buttons' => [
                            Html::a(Caption::ACTION_IN_SECTION, ['/shopping-list'], [
                                'class' => 'btn btn-success',
                                'title' => Caption::ACTION_IN_SECTION,
                                'options' => [
    
                                ]
                                    ]
                            ),
                            Html::a(Caption::ACTION_CREATE, ['/shopping-list/create'], [
                                'class' => 'btn btn-primary',
                                'title' => Caption::ACTION_CREATE,
                                'options' => [
     
                                ]
                                    ]
                            ),
                        ],
                        'options' => [
                            'class' => 'btn-group-justified',
                        ]
            ]);

//Виджет блока управления главной страницы
            echo Collapse::widget([
                'encodeLabels' => FALSE,
                'items' => [
                    // equivalent to the above
                        [
                        'label' => '<img src="' . Yii::$app->request->baseUrl . '/images/section/expense.png' . ' "width="100" "alt="" > ' . Caption::SECTION_EXPENSE,
                        'content' => $expense,
                        // open its content by default
                        'contentOptions' => ['class' => 'in']
                    ],
                        [
                        'label' => '<img src="' . Yii::$app->request->baseUrl . '/images/section/income.png' . ' "width="100" "alt="" > ' . Caption::SECTION_INCOME,
                        'content' => $income,
                    ],
                        [
                        'label' => '<img src="' . Yii::$app->request->baseUrl . '/images/section/account.png' . ' "width="100" "alt="" > ' . Caption::SECTION_ACCOUNT,
                        'content' => $account,
                    ],
                        [
                        'label' => '<img src="' . Yii::$app->request->baseUrl . '/images/section/account-move.png' . ' "width="100" "alt="" > ' . Caption::SECTION_ACCOUNT_MOVE,
                        'content' => $account_move,
                    ],
                        [
                        'label' => '<img src="' . Yii::$app->request->baseUrl . '/images/section/shopping-list.png' . ' "width="100" "alt="" > ' . Caption::SECTION_SHOPPING_LIST,
                        'content' => $shopping_list,
                    ],
                ]
            ]);
            ?>
            <!-- Блок управления (конец) -->      
        </div>
    </div>
</div>



<?php
//Открытие панелей при наведении мыши
$script = <<<JS
//$(document).ready(function () {
//    $(".collapse-toggle").mouseover(function () {
//        if ($(this).hasClass("collapsed")) {
//            $(this).click();
//            //console.log("test");
//        }
//    });
//});
JS;
$this->registerJs($script);
