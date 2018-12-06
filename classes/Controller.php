<?php

namespace app\classes;

use Yii;


/**
 * Общие настройки Контроллеров.
 */
class Controller extends \yii\web\Controller {

    /**
     * Является ли  текущий пользователь владельйем  записи?
     */
    protected function isUserOwner() {
        if ($this->findModel(Yii::$app->request->get('id'))
                ->user_id == Yii::$app->user->id) {
            return TRUE;
        } else {
            return FALSE;
        }
        return true;
    }

}
