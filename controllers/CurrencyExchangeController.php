<?php

namespace app\controllers;

use Yii;
use app\models\CurrencyExchange;
use app\models\CurrencyExchangeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\classes\VerbFilter;
use app\classes\Caption;
use yii\filters\AccessControl;

/**
 * CurrencyExchangeController implements the CRUD actions for CurrencyExchange model.
 */
class CurrencyExchangeController extends Controller {

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
                        'actions' => ['update', 'index', 'delete', 'create', 'get-exchange'],
                        'allow' => true,
                        'roles' => ['user', 'show_all'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all CurrencyExchange models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new CurrencyExchangeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new CurrencyExchange model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new CurrencyExchange();

        $model->start_date = date('Y-m-d');
        $model->number_units = 100;

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
     * Updates an existing CurrencyExchange model.
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
     * Deletes an existing CurrencyExchange model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();
        Yii::$app->getSession()->setFlash('delete-success', Caption::FLASH_DELETE_SUCCESS);
        return $this->redirect(['index']);
    }

    /**
     * Finds the CurrencyExchange model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CurrencyExchange the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = CurrencyExchange::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Caption::ERROR_NOT_FOUND);
        }
    }

    //Получение значений курсов валют...
    public function actionGetExchange($currency_id = 0) {

        $currency_name = \app\models\Currency::findOne($currency_id)->name;

        $xml = simplexml_load_file('http://bank-ua.com/export/currrate.xml');
        foreach ($xml->children() as $item) {
            if ($item->char3 == $currency_name) {
                echo json_encode(['rate' => $item->rate, 'size' => $item->size]);
            }
        }
    }

}
