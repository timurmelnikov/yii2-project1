<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\classes\VerbFilter;
use app\models\AuthItem;
use yii\data\ActiveDataProvider;
use app\classes\Caption;
//use yii\filters\AccessControl;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'update' => ['post'],
                    //'index' => ['post'],
                    'delete' => ['post'],
                    //'create' => ['post'],
                    'password' => ['post'],
                    'permission' => ['post'],
                //'role-assignment' => ['post'],
                ],
            ],
                //Фильтр для прав
//            'access' => [
//                'class' => AccessControl::className(),
//                'rules' => [
//                    [
//                        'actions' => ['update', 'index', 'delete', 'create', 'password', 'permission', 'role-assignment'],
//                        'allow' => true,
//                        'roles' => ['admin'],
//                    ],
//                ],
//            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new User();

        $model->setScenario('password');

        $model->created_at = date_timestamp_get(date_create());
        $model->updated_at = date_timestamp_get(date_create());


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('create-success', Caption::FLASH_CREATE_SUCCESS);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $model->updated_at = date_timestamp_get(date_create());

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('update-success', Caption::FLASH_UPDATE_SUCCESS);
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        try {
            $this->findModel($id)->delete();
            Yii::$app->getSession()->setFlash('delete-success', Caption::FLASH_DELETE_SUCCESS);
            return $this->redirect(['index']);
        } catch (\Exception $ex) {
            if ($ex->getCode() == 23000) {
                Yii::$app->getSession()->setFlash('delete-error', Caption::FLASH_DELETE_ERROR_RELATION);
            }
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Caption::ERROR_NOT_FOUND);
        }
    }

    /**
     * Изменение пароля пользователя
     * @param integer $id
     * @return mixed
     */
    public function actionPassword($id) {
        $model = $this->findModel($id);
        $model->setScenario('password');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('password', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Назначение ролей пользователям (все роли, которые можно дать пользователю)
     * @param integer $id
     * @return mixed
     */
    public function actionPermission($id) {
        $model = $this->findModel($id);
        return $this->renderPermission($model);
    }

    /**
     * Назначение ролей пользователям (дать/забрать)
     * @param integer $id
     * @param string $role
     * @param integer $action 0-remove 1-add
     * @return mixed
     */
    public function actionRoleAssignment($id, $role = NULL, $action = NULL) {
        $model = $this->findModel($id);
        if (Yii::$app->request->isAjax) {
            if ($action == 1) {
                //Назначение роли пользователю
                $userRole = Yii::$app->authManager->getRole($role);
                Yii::$app->authManager->assign($userRole, $id);
            } else if ($action == 0 && $model->username !== 'root') {
                //Удаление роли у пользователя
                $userRole = Yii::$app->authManager->getRole($role);
                Yii::$app->authManager->revoke($userRole, $id);
            }
        }
        return $this->renderPermission($model);
    }

    /**
     * Назначение ролей пользователям (рендеринг грида)
     * @param integer $model
     * @return mixed
     */
    public function renderPermission($model) {
        $dataProvider = new ActiveDataProvider(['query' => AuthItem::find(),]);
        return $this->render('permission', ['user_model' => $model, 'dataProvider' => $dataProvider,]);
    }

}
