<?php

namespace app\classes;

use Yii;
use yii\base\Widget;
use kartik\widgets\Growl;

/**
 * Виджет Growl для CRUD.
 */
class GrowlCRUD extends Widget
{

    public function run()
    {

        if (Yii::$app->session->getFlash('delete-error')) {
            return Growl::widget([
                        'title' => Caption::FLASH_TITLE_ERROR,
                        'body' => Yii::$app->session->getFlash('delete-error'),
                        'pluginOptions' => ['showProgressbar' => true,],
                        'showSeparator' => true,
                        'type' => Growl::TYPE_DANGER,
                        'icon' => 'glyphicon glyphicon-remove',
            ]);
        }

        if (Yii::$app->session->getFlash('rollback-success')) {
            return Growl::widget([
                        'title' => Caption::FLASH_TITLE_SUCCESS,
                        'body' => Yii::$app->session->getFlash('rollback-success'),
                        'pluginOptions' => [
                            'showProgressbar' => true,
                        ],
                        'showSeparator' => true,
                        'type' => Growl::TYPE_SUCCESS,
                        'icon' => 'glyphicon glyphicon-ok',
            ]);
        }

        if (Yii::$app->session->getFlash('save-as-template-error')) {
            return Growl::widget([
                        'title' => Caption::FLASH_TITLE_ERROR,
                        'body' => Yii::$app->session->getFlash('save-as-template-error'),
                        'pluginOptions' => ['showProgressbar' => true,],
                        'showSeparator' => true,
                        'type' => Growl::TYPE_DANGER,
                        'icon' => 'glyphicon glyphicon-remove',
            ]);
        }

        if (Yii::$app->session->getFlash('save-as-template-success')) {
            return Growl::widget([
                        'title' => Caption::FLASH_TITLE_SUCCESS,
                        'body' => Yii::$app->session->getFlash('save-as-template-success'),
                        'pluginOptions' => [
                            'showProgressbar' => true,
                        ],
                        'showSeparator' => true,
                        'type' => Growl::TYPE_SUCCESS,
                        'icon' => 'glyphicon glyphicon-ok',
            ]);
        }

        if (Yii::$app->session->getFlash('delete-success')) {
            return Growl::widget([
                        'title' => Caption::FLASH_TITLE_SUCCESS,
                        'body' => Yii::$app->session->getFlash('delete-success'),
                        'pluginOptions' => [
                            'showProgressbar' => true,
                        ],
                        'showSeparator' => true,
                        'type' => Growl::TYPE_SUCCESS,
                        'icon' => 'glyphicon glyphicon-ok',
            ]);
        }

        if (Yii::$app->session->getFlash('create-success')) {
            return Growl::widget([
                        'title' => Caption::FLASH_TITLE_SUCCESS,
                        'body' => Yii::$app->session->getFlash('create-success'),
                        'pluginOptions' => [
                            'showProgressbar' => true,
                        ],
                        'showSeparator' => true,
                        'type' => Growl::TYPE_SUCCESS,
                        'icon' => 'glyphicon glyphicon-ok',
            ]);
        }

        if (Yii::$app->session->getFlash('update-success')) {
            return Growl::widget([
                        'title' => Caption::FLASH_TITLE_SUCCESS,
                        'body' => Yii::$app->session->getFlash('update-success'),
                        'pluginOptions' => [
                            'showProgressbar' => true,
                        ],
                        'showSeparator' => true,
                        'type' => Growl::TYPE_SUCCESS,
                        'icon' => 'glyphicon glyphicon-ok',
            ]);
        }
    }
}
