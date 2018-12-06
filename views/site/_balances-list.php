<?php

use yii\helpers\Html;
?>

<div class="balances-list-item">


    <tr>
        <td><?= Html::encode($model->name) ?></td>
        <td align="right"><?= Html::encode($model->current_sum) ?> </td>
    </tr>



</div>