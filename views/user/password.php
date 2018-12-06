<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\classes\Caption;

/* @var $this yii\web\View */
/* @var $model app\models\User */


$this->params['breadcrumbs'][] = ['label' => Caption::SECTION_USER_PASSWORD, 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username];
?>
<div class="user-password">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
<?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Caption::ACTION_CREATE : Caption::ACTION_UPDATE, ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
<?= Html::a(Caption::ACTION_CANCEL, ['/user'], [ 'class' => 'btn btn-warning',]) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
