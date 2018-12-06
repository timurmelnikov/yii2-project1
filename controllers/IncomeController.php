<?php

namespace app\controllers;

use Yii;
use app\models\Income;
use app\models\IncomeSearch;
use app\classes\Controller;
use yii\web\NotFoundHttpException;
use app\classes\VerbFilter;
use app\classes\Caption;
use yii\filters\AccessControl;
//use app\models\Account;

/**
 * IncomeController implements the CRUD actions for Income model.
 */
class IncomeController extends Controller {

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
                        'actions' => ['index', 'create'],
                        'allow' => true,
                        'roles' => ['user', 'show_all'],
                    ],
                    [
                        'actions' => ['update', 'delete'],
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
     * Lists all Income models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new IncomeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Income model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Income();
        $model->user_id = Yii::$app->user->identity->id;
        $model->date_oper = date('Y-m-d');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if (Yii::$app->request->post()['Income']['continue'] == 1) {
                $model = new Income();
                $model->user_id = Yii::$app->user->identity->id;
                $model->date_oper = date('Y-m-d');
                $model->continue = 1;
                Yii::$app->getSession()->setFlash('create-success', Caption::FLASH_CREATE_SUCCESS);
                return $this->render('create', ['model' => $model,]);
            } else {
                Yii::$app->getSession()->setFlash('create-success', Caption::FLASH_CREATE_SUCCESS);
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('create', ['model' => $model,]);
        }
    }

    /**
     * Updates an existing Income model.
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
     * Откат операции с обнослением счета
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
     * Finds the Income model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Income the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Income::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Caption::ERROR_NOT_FOUND);
        }
    }

}
