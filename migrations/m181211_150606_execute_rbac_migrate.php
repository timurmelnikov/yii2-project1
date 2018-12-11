<?php

use yii\db\Migration;

/**
 * Class m181211_150606_execute_rbac_migrate
 */
class m181211_150606_execute_rbac_migrate extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //Вызываем миграции RBAC
        Yii::$app->runAction('migrate/up', [
            'migrationPath' => '@yii/rbac/migrations',
            'interactive' => false,
        ]);

        //Создаем роли
        $role = Yii::$app->authManager->createRole('root');
        $role->description = 'Супер-администратор';
        Yii::$app->authManager->add($role);
        $role = Yii::$app->authManager->createRole('admin');
        $role->description = 'Администратор';
        Yii::$app->authManager->add($role);
        $role = Yii::$app->authManager->createRole('user');
        $role->description = 'Пользователь';
        Yii::$app->authManager->add($role);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181211_150606_execute_rbac_migrate cannot be reverted.\n";

        return false;
    }

}
