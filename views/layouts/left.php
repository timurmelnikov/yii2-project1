<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
                <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                'items' => [
                    ['label' => 'Меню', 'options' => ['class' => 'header']],
                    [
                        'label' => 'Операции',
                        'icon' => 'calculator',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Доходы', 'icon' => 'arrow-down', 'url' => ['#'],],
                            ['label' => 'Расходы', 'icon' => 'arrow-up', 'url' => ['#'],],
                            ['label' => 'Перемещения', 'icon' => 'exchange', 'url' => ['#'],],
                            ['label' => 'Списки покупок', 'icon' => 'list', 'url' => ['#'],],
                        ],
                    ],
                    [
                        'label' => 'Словари',
                        'icon' => 'list-alt',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Счета (кошельки)', 'icon' => 'cc-visa', 'url' => ['#'],],
                            ['label' => 'Категории доходов', 'icon' => 'list-ul', 'url' => ['#'],],
                            ['label' => 'Категории расходов', 'icon' => 'list-ul', 'url' => ['#'],],
                            ['label' => 'Шаблоны расходов', 'icon' => 'file-text', 'url' => ['#'],],
                            ['label' => 'Единицы измерения', 'icon' => 'balance-scale', 'url' => ['#'],],
                            ['label' => 'Курсы валют', 'icon' => 'dollar', 'url' => ['#'],],
                        ],
                    ],
                    [
                        'label' => 'Отчеты',
                        'icon' => 'area-chart',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Отчет 1', 'icon' => 'pie-chart', 'url' => ['#'],],
                            ['label' => 'Отчет 2', 'icon' => 'bar-chart', 'url' => ['#'],],
                        ],
                    ],
                    [
                        'label' => 'Управление',
                        'icon' => 'user-secret',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Пользователи', 'icon' => 'users', 'url' => ['#'],],

                            [
                                'label' => 'Development',
                                'icon' => 'code',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                                    ['label' => 'Debug', 'icon' => 'bug', 'url' => ['/debug'],],
                                ],
                            ],
                        ],
                    ],

                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                ],
            ]
        ) ?>

    </section>

</aside>
