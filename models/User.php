<?php

namespace app\models;

use yii\base\NotSupportedException;
use yii\rbac\DbManager;
use Yii;
use app\classes\Caption;

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface {

    const STATE_ACTIVE = 0;
    const STATE_BAN = 1;

    public $password;
    public $password_repeat;
    public $permissions;

    public static function tableName() {
        return '{{%user}}';
    }

    public function behaviors() {
        return [
        ];
    }

    public static function findIdentity($id) {
        return static::findOne(['id' => $id]);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public static function findByUsername($username) {
        return static::findOne(['username' => $username]);
    }

    public function getId() {
        return $this->getPrimaryKey();
    }

    public function getAuthKey() {
        return $this->auth_key; //return $this->authKey;
    }

    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    //Мои методы...

    /**
     * @inheritdoc
     */
    public function rules() {
        return [

            [['created_at', 'updated_at', 'username', 'email', 'state'], 'required'],
            [['password', 'password_repeat'], 'required', 'on' => 'password'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'on' => 'password'],
            ['email', 'email'],
            [['id', 'created_at', 'updated_at', 'state'], 'integer'],
            [['fullname', 'username', 'auth_key', 'email_confirm_token', 'password_hash', 'password_reset_token', 'email'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'created_at' => 'Создан',
            'updated_at' => 'Изменен',
            'fullname' => 'Полное имя',
            'username' => 'Логин',
            'state' => 'Состояние',
            'password' => 'Пароль',
            'password_repeat' => 'Пароль еще раз',
            'email' => 'E-mail',
            'permissions' => 'Назначеные роли'
        ];
    }

    /**
     * Хешируем пароль, перед сохранением Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if ($this->password) {
                //Установка пароля в $this->password_hash
                $this->setPassword($this->password);
                //Установка пароля в $this->password_hash (конец)
                $this->generateAuthKey();
            }
            return true;
        }

        return false;
    }

    public function beforeDelete() {
        parent::beforeDelete();
//Запрещаем удаление пользователя "root"
        if ($this->username == 'root') {
            Yii::$app->getSession()->setFlash('delete-error', Caption::FLASH_DELETE_ERROR_USER_ROOT);
            return false;
        }
        //Запрещаем удаление пользователем самого себя
        if ($this->id == Yii::$app->user->id) {
            Yii::$app->getSession()->setFlash('delete-error', Caption::FLASH_DELETE_ERROR_USER_SELF);
            return false;
        }

        return TRUE;
    }


    /**
     * Есть ли роль у пользователя ?
     */
    public static function hasRole($id, $role) {
        $dbman = new DbManager;
        if ($dbman->checkAccess($id, $role)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getExpenses() {
        return $this->hasMany(Expense::className(), ['user_id' => 'id']);
    }

    public function getIncomes() {
        return $this->hasMany(Income::className(), ['user_id' => 'id']);
    }

    public function getAccounts() {
        return $this->hasMany(Account::className(), ['user_id' => 'id']);
    }

//     public function getSettings() {
//         return $this->hasMany(Setting::className(), ['user_id' => 'id']);
//     }

    public function getMoves() {
        return $this->hasMany(AccountMove::className(), ['user_id' => 'id']);
    }

    public function getExpensetemps() {
        return $this->hasMany(ExpenseTemplate::className(), ['user_id' => 'id']);
    }

    public function getCategoryincs() {
        return $this->hasMany(IncomeCategory::className(), ['user_id' => 'id']);
    }

}
