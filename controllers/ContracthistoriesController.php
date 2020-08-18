<?php

namespace app\controllers;

use app\models\Contract;
use Yii;
use app\models\ContractHistories;
use app\models\ContractHistoriesSearch;
use app\models\Employee;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ContracthistoriesController implements the CRUD actions for ContractHistories model.
 */
class ContracthistoriesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ContractHistories models.
     * @return mixed
     */
    public function actionIndex($id_employee)
    {
        $employee = Employee::findOne($id_employee);
        $searchModel = new ContractHistoriesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'employee'=>$employee,
        ]);
    }

    /**
     * Displays a single ContractHistories model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ContractHistories model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id_employee)
    {
        $employee = Employee::findOne($id_employee);
        $model = new ContractHistories();
        $model->id = $model->getLastId();
        $model->id_employee = $id_employee;
        $model->doh = $employee->date_of_hired;

        $contract = Contract::find(['id_employee'=>$id_employee]);
        if ($contract->exists()){
            $contract = Contract::findOne(['id_employee'=>$id_employee]);
            $model->start_contract = $contract->start_contract;
            $model->duration_contract = $contract->duration_contract;
            $model->basic_salary = $contract->basic_salary;
            $model->number_contract = $contract->number_contract;
            

        }
        $CH = ContractHistories::find()->where(['id_employee'=>$id_employee]);
        if ($CH->exists()){
            ContractHistories::updateAll(['set_default'=>false], 'id_employee=:id_employee',[':id_employee'=>$id_employee]);
               
        }
        $model->set_default = TRUE;


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'employee'=> $employee,
        ]);
    }

    /**
     * Updates an existing ContractHistories model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ContractHistories model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $id_employee = $this->findModel($id)->id_employee;
        $this->findModel($id)->delete();

        return $this->redirect(['index', 'id_employee'=>$id_employee]);
    }

    /**
     * Finds the ContractHistories model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ContractHistories the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ContractHistories::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
