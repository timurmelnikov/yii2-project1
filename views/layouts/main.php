<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\classes\Caption;
use app\classes\GrowlCRUD;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="<?= Yii::$app->request->baseUrl . '/images/favicon.png' ?>" rel="shortcut icon" type="image/x-icon" />
        <?= Html::csrfMetaTags() ?>
        <title><?= isset($this->title) ? Yii::$app->name . ' - ' . Html::encode($this->title) : Yii::$app->name; ?></title>
        <?php $this->head() ?>
    </head>
    <body>

        <?= GrowlCRUD::widget([]); ?> <!-- Вывод сообщений Growl -->
        
        <?php $this->beginBody() ?>

        <div class="wrap">
            <?php
            NavBar::begin([
                'brandLabel' => '<span class="glyphicon glyphicon-home"/>',//Caption::SECTION_MAIN,
                //'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            echo Nav::widget([

                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                     ['label' => Caption::SECTION_OPERATION,
                        'items' => [

                            ['label' => Caption::SECTION_INCOME, 'url' => ['/income']],
                            ['label' => Caption::SECTION_EXPENSE, 'url' => ['/expense']],
                            '<li class="divider"></li>',
                            ['label' => Caption::SECTION_ACCOUNT_MOVE, 'url' => ['/account-move']],
//                            '<li class="divider"></li>',
//                            ['label' => Caption::SECTION_DEBT, 'url' => ['#']],
//                            '<li class="divider"></li>',
//                            ['label' => Caption::SECTION_SHEDULER, 'url' => ['#']],
                            '<li class="divider"></li>',
                            ['label' => Caption::SECTION_SHOPPING_LIST, 'url' => ['/shopping-list']],
                        ],
                        'visible' => !Yii::$app->user->isGuest],
                    ['label' => Caption::SECTION_DICTIONARY,
                        'items' => [
                            ['label' => Caption::SECTION_ACCOUNT, 'url' => ['/account']],
                            '<li class="divider"></li>',
                            ['label' => Caption::SECTION_INCOME_CATEGORY, 'url' => ['/income-category']],
                            ['label' => Caption::SECTION_EXPENSE_CATEGORY, 'url' => ['/expense-category'],],
                            '<li class="divider"></li>',
                            ['label' => Caption::SECTION_EXPENSE_TEMPLATE, 'url' => ['/expense-template']],
                            '<li class="divider"></li>',
                            ['label' => Caption::SECTION_UNIT, 'url' => ['/unit']],
                            '<li class="divider"></li>',
                            ['label' => Caption::SECTION_CURRENCY_EXCHANGE, 'url' => ['/currency-exchange']],
                        ],
                        'visible' => !Yii::$app->user->isGuest],
                    ['label' => Caption::SECTION_REPORT,
                        'items' => [
                            ['label' => 'Отчет1', 'url' => ['/report/rep1']],
                            ['label' => 'Отчет2', 'url' => ['/report/rep2']],
                            '<li class="divider"></li>',
                            ['label' => 'Отчет3', 'url' => ['/report/rep3']],
                            '<li class="divider"></li>',
                            ['label' => 'Отчет4', 'url' => ['/report/rep4']],
                        ],
                        'visible' => !Yii::$app->user->isGuest],
                    ['label' => Caption::SECTION_MANAGAMENT,
                        'items' => [
                            ['label' => Caption::SECTION_USER, 'url' => ['/user']],
//                            '<li class="divider"></li>',
//                            ['label' => Caption::SECTION_SETTING, 'url' => ['/setting']],
                        ],
                        'visible' => !Yii::$app->user->isGuest],
                    ['label' => 'Помощь',
                        'items' => [

                            ['label' => Caption::SECTION_CONTACT, 'url' => ['/site/contact']],
                            '<li class="divider"></li>',
                            ['label' => Caption::SECTION_ABOUT, 'url' => ['/site/about']],
                            '<li class="divider"></li>',
                            ['label' => 'Прототип1', 'url' => 'http://www.drebedengi.ru/?module=v2_homeBuhPrivate'],
                            ['label' => 'Прототип2', 'url' => 'http://finance.uramaks.com/'],
                            ['label' => 'Прототип3', 'url' => 'http://www.cashorganizer.com/rus/'],
                            ['label' => 'Прототип4 (yii2)', 'url' => 'http://www.economizzer.org/'],
                        ],
                        'visible' => !Yii::$app->user->isGuest],
                    Yii::$app->user->isGuest ? '' /* ['label' => Caption::SECTION_LOGIN, 'url' => ['/site/login']] */ :
                            [
                        'label' => Caption::SECTION_LOGOUT . ' (' . Yii::$app->user->identity->username . ')',
                        'url' => ['/site/logout'],
                        'linkOptions' => ['data-method' => 'post']
                            ],
                ],
            ]);
            NavBar::end();
            ?>

            <div class="container">

                <?php
//                echo user_min_browser($_SERVER['HTTP_USER_AGENT']);
//                echo '<br/>';
//                echo user_browser($_SERVER['HTTP_USER_AGENT']);
//
//                function user_min_browser($agent) {
//                    preg_match("/(MSIE|Opera|Firefox|Chrome|Version)(?:\/| )([0-9.]+)/", $agent, $browser_info);
//                    list(, $browser, $version) = $browser_info;
//                    if ($browser == 'Opera' && $version == '9.80')
//                        return 'Opera ' . substr($agent, -5);
//                    if ($browser == 'Version')
//                        return 'Safari ' . $version;
//                    if (!$browser && strpos($agent, 'Gecko'))
//                        return 'Browser based on Gecko';
//                    return $browser . ' ' . $version;
//                }
//
//                function user_browser($agent) {
//                    preg_match("/(MSIE|Opera|Firefox|Chrome|Version|Opera Mini|Netscape|Konqueror|SeaMonkey|Camino|Minefield|Iceweasel|K-Meleon|Maxthon)(?:\/| )([0-9.]+)/", $agent, $browser_info); // регулярное выражение, которое позволяет отпределить 90% браузеров
//                    list(, $browser, $version) = $browser_info; // получаем данные из массива в переменную
//                    if (preg_match("/Opera ([0-9.]+)/i", $agent, $opera))
//                        return 'Opera ' . $opera[1]; // определение _очень_старых_ версий Оперы (до 8.50), при желании можно убрать
//                    if ($browser == 'MSIE') { // если браузер определён как IE
//                        preg_match("/(Maxthon|Avant Browser|MyIE2)/i", $agent, $ie); // проверяем, не разработка ли это на основе IE
//                        if ($ie)
//                            return $ie[1] . ' based on IE ' . $version; // если да, то возвращаем сообщение об этом
//                        return 'IE ' . $version; // иначе просто возвращаем IE и номер версии
//                    }
//                    if ($browser == 'Firefox') { // если браузер определён как Firefox
//                        preg_match("/(Flock|Navigator|Epiphany)\/([0-9.]+)/", $agent, $ff); // проверяем, не разработка ли это на основе Firefox
//                        if ($ff)
//                            return $ff[1] . ' ' . $ff[2]; // если да, то выводим номер и версию
//                    }
//                    if ($browser == 'Opera' && $version == '9.80')
//                        return 'Opera ' . substr($agent, -5); // если браузер определён как Opera 9.80, берём версию Оперы из конца строки
//                    if ($browser == 'Version')
//                        return 'Safari ' . $version; // определяем Сафари
//                    if (!$browser && strpos($agent, 'Gecko'))
//                        return 'Browser based on Gecko'; // для неопознанных браузеров проверяем, если они на движке Gecko, и возращаем сообщение об этом
//                    return $browser . ' ' . $version; // для всех остальных возвращаем браузер и версию
//                }
                ?>


                <noscript>
                <div class="alert alert-danger" role="alert"><?= Caption::ERROR_NOSCRIPT; ?></div>
                </noscript>

                <?= !Yii::$app->user->isGuest ? Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],]) : null ?>

                <?= $content ?>

            </div>

        </div>

        <div id = "toTop" ><span class="glyphicon glyphicon-arrow-up"></span> Наверх</div>

        <footer class="footer">
            <div class="container">
                <p class="pull-left">&copy; <?=Yii::$app->params['authorName']?> <?= date('Y') ?> <a href="<?=Yii::$app->params['sourceCode']?>" target="blank_">GitHub</a></p>
                
                <p class="pull-right"><?= Yii::powered() ?></p>
            </div>
        </footer>

        <?php $this->endBody() ?>

        <script type="text/javascript">
            $(function () {
                $(window).scroll(function () {
                    if ($(this).scrollTop() != 0) {
                        $('#toTop').fadeIn();
                    } else {
                        $('#toTop').fadeOut();
                    }
                });
                $('#toTop').click(function () {
                    $('body,html').animate({scrollTop: 0}, 300);
                });
            });
        </script>

    </body>
</html>
<?php $this->endPage() ?>
