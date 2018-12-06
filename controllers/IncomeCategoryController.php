<?php

namespace app\controllers;

use Yii;
use app\models\IncomeCategory;
use app\models\IncomeCategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\classes\VerbFilter;
use app\classes\Caption;
use yii\filters\AccessControl;


/**
 * IncomeCategoryController implements the CRUD actions for IncomeCategory model.
 */
class IncomeCategoryController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
                        //Фильтр для прав
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['update', 'index', 'delete', 'create'],
                        'allow' => true,
                        'roles' => ['user', 'show_all'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all IncomeCategory models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new IncomeCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new IncomeCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new IncomeCategory();
        $model->user_id = Yii::$app->user->identity->id;

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
     * Updates an existing IncomeCategory model.
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
     * Deletes an existing IncomeCategory model.
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
     * Finds the IncomeCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return IncomeCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = IncomeCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Caption::ERROR_NOT_FOUND);
        }
    }

}
