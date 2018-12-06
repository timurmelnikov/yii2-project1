<?php

namespace app\controllers;

use Yii;
use app\models\ExpenseCategory;
use app\models\ExpenseCategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\classes\VerbFilter;
use app\classes\Caption;
use yii\filters\AccessControl;

/**
 * ExpenseCategoryController implements the CRUD actions for ExpenseCategory model.
 */
class ExpenseCategoryController extends Controller {

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
     * Lists all Categoryexp models.
     * @return mixed
     */
    public function actionIndex($parent_id = 0) {

        //$m = new ExpenseCategory();
        //$m->updatePathAll();

        $searchModel = new ExpenseCategorySearch();
        $searchModel->setParent($parent_id);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Categoryexp model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($parent_id = 0) {
        $model = new ExpenseCategory();
        $model->parent_id = $parent_id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('create-success', Caption::FLASH_CREATE_SUCCESS);
            return $this->redirect(['index', 'parent_id' => $model->parent_id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Categoryexp model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $parent_id = 0) {
        $model = $this->findModel($id);
        $model->parent_id = $parent_id;


        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            //Обновляем поле path
            $model->updatePathAll();

            Yii::$app->getSession()->setFlash('update-success', Caption::FLASH_UPDATE_SUCCESS);
            return $this->redirect(['index', 'parent_id' => $model->parent_id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Categoryexp model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id, $parent_id = 0) {

        try {
            $this->findModel($id)->delete();
            Yii::$app->getSession()->setFlash('delete-success', Caption::FLASH_DELETE_SUCCESS);
            return $this->redirect(['index', 'parent_id' => $parent_id]);
        } catch (\Exception $ex) {
            if ($ex->getCode() == 23000) {
                Yii::$app->getSession()->setFlash('delete-error', Caption::FLASH_DELETE_ERROR_RELATION);
            }
            return $this->redirect(['index', 'parent_id' => $parent_id]);
        }
    }

    /**
     * Finds the ExpenseCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ExpenseCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ExpenseCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Caption::ERROR_NOT_FOUND);
        }
    }

}
