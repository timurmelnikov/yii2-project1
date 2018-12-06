<?php

namespace app\controllers;

use Yii;
use app\models\AccountMove;
use app\models\AccountMoveSearch;
use app\classes\Controller;
use yii\web\NotFoundHttpException;
use app\classes\VerbFilter;
use app\classes\Caption;
use yii\filters\AccessControl;

/**
 * AccountMoveController implements the CRUD actions for AccountMove model.
 */
class AccountMoveController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'rollback' => ['post'],
                ],
            ],
            //Фильтр для прав
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create',],
                        'allow' => true,
                        'roles' => ['user', 'show_all'],
                    ],
                    [
                        'actions' => ['update', 'rollback'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                    if ($this->isUserOwner()) {
                        return true;
                    }
                    return false;
                }
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all AccountMove models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new AccountMoveSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new AccountMove model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new AccountMove();
        $model->user_id = Yii::$app->user->identity->id;
        $model->date_oper = date('Y-m-d');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('create-success', Caption::FLASH_CREATE_SUCCESS);
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AccountMove model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('update-success', Caption::FLASH_UPDATE_SUCCESS);
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Откат операции с обнослением счетов
     * @param integer $id
     * @return mixed
     */
    public function actionRollback($id) {
        if ($this->findModel($id)->delete()) {
            Yii::$app->getSession()->setFlash('rollback-success', Caption::FLASH_ROLLBACK_SUCCESS);
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the AccountMove model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AccountMove the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = AccountMove::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Caption::ERROR_NOT_FOUND);
        }
    }

}
