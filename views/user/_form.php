<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User;
use app\classes\Caption;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php if ($model->isNewRecord): ?>
        <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'disabled' => $model->isNewRecord ? false : true,]) ?>
        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]) ?>
    <?php endif; ?> 

    <?= $form->field($model, 'fullname')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'state')->dropDownList(['' => Caption::PROMPT_SELECT, User::STATE_ACTIVE => Caption::STATE_ACTIVE, User::STATE_BAN => Caption::STATE_BAN]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Caption::ACTION_CREATE : Caption::ACTION_UPDATE, ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
<?= Html::a(Caption::ACTION_CANCEL, ['/user'], [ 'class' => 'btn btn-warning',]) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
