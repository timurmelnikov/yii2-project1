<?php

use yii\helpers\Html;
use app\classes\Caption;

/* @var $this yii\web\View */

$this->title = Caption::SECTION_ABOUT;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

</div>
