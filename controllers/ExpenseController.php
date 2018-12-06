<?php

namespace app\controllers;

use Yii;
use app\models\Expense;
use app\models\ExpenseSearch;
use app\classes\Controller;
use yii\web\NotFoundHttpException;
use app\classes\VerbFilter;
use app\classes\Caption;
use yii\filters\AccessControl;
use app\models\ExpenseTemplate;
use yii\helpers\Html;

/**
 * ExpenseController implements the CRUD actions for Expense model.
 */
class ExpenseController extends Controller {

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
                        'actions' => ['index', 'create', 'save-as-template'],
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
     * Lists all Expense models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ExpenseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Expense model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($tmp = 0) {
        $model = new Expense();
        $model->user_id = Yii::$app->user->identity->id;
        $model->date_oper = date('Y-m-d');
        $model->unit_id = 1; //В настройках должно задаваться!
        $model->count_unit = 1;


        if ($tmp > 0) {
            $model->cost = ExpenseTemplate::findOne($tmp)->cost;
            $model->unit_id = ExpenseTemplate::findOne($tmp)->unit_id;
            $model->count_unit = ExpenseTemplate::findOne($tmp)->count_unit;
            $model->account_id = ExpenseTemplate::findOne($tmp)->account_id;
            $model->expense_category_id = ExpenseTemplate::findOne($tmp)->expense_category_id;
            $model->description = ExpenseTemplate::findOne($tmp)->description;
        }



        //Для Ajax валидации       
        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }
        //Для Ajax валидации (конец)

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (Yii::$app->request->post()['Expense']['continue'] == 1) {
                $model = new Expense();
                $model->user_id = Yii::$app->user->identity->id;
                $model->date_oper = date('Y-m-d');
                $model->unit_id = 1; //В настройках должно задаваться!
                $model->count_unit = 1;
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
     * Updates an existing Expense model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);


        //Для Ajax валидации       
        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }
        //Для Ajax валидации (конец)

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
     * Сохраняет запись об операции в виде шаблона
     * @return mixed
     */
    public function actionSaveAsTemplate($id) {
        $expense = Expense::findOne($id);
        $expense_template = new ExpenseTemplate();
        $expense_template->expense_category_id = $expense->expense_category_id;
        $expense_template->cost = $expense->cost;
        $expense_template->description = $expense->description;
        $expense_template->user_id = Yii::$app->user->identity->id; //$expense->user_id;
        $expense_template->account_id = $expense->account_id;
        $expense_template->name = $expense->expenseCategory->name;
        $expense_template->unit_id = $expense->unit_id;
        $expense_template->count_unit = $expense->count_unit;

        if ($expense_template->save()) {
            Yii::$app->getSession()->setFlash('save-as-template-success', Caption::FLASH_CREATE_TEMPLATE_SUCCESS . '"' . $expense_template->name . '"<hr/>' . Html::a(Caption::ACTION_CHANGE_TEMPLATE, ['expense-template/update', 'id' => $expense_template->id], ['class' => 'btn btn-primary btn-sm']));
        } else {
            Yii::$app->getSession()->setFlash('save-as-template-error', Caption::VALIDATION_EXPENSE_TEMPLATE_UNIQUE_OPERATION . '<hr/>' . Html::a(Caption::ACTION_GO_TEMPLATE, ['/expense-template'], ['class' => 'btn btn-primary btn-sm']));
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Expense model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Expense the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Expense::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Caption::ERROR_NOT_FOUND);
        }
    }

}
