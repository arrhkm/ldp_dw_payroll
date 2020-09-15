<?php

namespace app\controllers;

use app\components\EmployeeList;
use app\models\Employee;
use app\models\ModelFormEmloyee;
use app\models\ModelFormEmployee;
use Yii;
use app\models\PayrollGroup;
use app\models\PayrollGroupEmployee;
use app\models\PayrollGroupSearch;
use app\models\PayrollLogic;
use BlueM\Tree;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * PayrollgroupController implements the CRUD actions for PayrollGroup model.
 */
class PayrollgroupController extends Controller
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
     * Lists all PayrollGroup models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PayrollGroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PayrollGroup model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $employee_saved = PayrollGroupEmployee::find()->where([
            'id_payroll_group'=>$id,
        ])->orderBy(['id'=>SORT_ASC])->all();

    
        //$employee = Employee::find()->where(['is_active'=>True])->all();
        $employee_list = EmployeeList::getEmployeeActive();//ArrayHelper::map($employee, 'id', 'name');    

        $modelForm = New ModelFormEmployee();
        $modelForm->id_payroll_group = $id;

        $providerGroup = New ArrayDataProvider([
            'allModels'=>$employee_saved,
            'pagination'=>[
                'pageSize'=>1000,
            ]
        ]);

        if ($modelForm->load(Yii::$app->request->post()) && $modelForm->validate()){
            $emp = $modelForm->id_employee;
            $first_id = PayrollGroupEmployee::getLastId();
            foreach ($emp as $id_employee){
                $model_cek = PayrollGroupEmployee::find()->where(['id_employee'=>$id_employee, 'id_payroll_group'=>$modelForm->id_payroll_group]);
                if (!$model_cek->exists()){

                    $modelInsert = New PayrollGroupEmployee();
                    $modelInsert->id = $modelInsert->getLastId();
                    $modelInsert->id_payroll_group = $modelForm->id_payroll_group;
                    $modelInsert->id_employee = $id_employee;
                    $modelInsert->save();
                }
                    
            }


            return $this->render('view',[
                'model' => $this->findModel($id),
                'providerGroup'=>$providerGroup,
                'modelForm'=>$modelForm,
                'employee_list'=>$employee_list,
            ]);
        }     


        return $this->render('view', [
            'model' => $this->findModel($id),
            'providerGroup'=>$providerGroup,
            'modelForm'=>$modelForm,
            'employee_list'=>$employee_list,
        ]);
    }

    /**
     * Creates a new PayrollGroup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function getLogicName(){
        $x = PayrollLogic::find()->all();
        return ArrayHelper::map($x, 'id', 'name');
    }
    public function actionCreate()
    {
        $model = new PayrollGroup();
        $model->id = $model->getLastId();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'list_logic'=>$this->getLogicName(),
        ]);
    }

    /**
     * Updates an existing PayrollGroup model.
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
            'list_logic' => $this->getLogicName()
        ]);
    }

    /**
     * Deletes an existing PayrollGroup model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeletegroupemployee($id){
        $model = PayrollGroupEmployee::findOne($id);
        $id_group = $model->id_payroll_group;
        $model->delete();

        return $this->redirect([
            'view',
            'id'=>$id_group,
        ]);
    }

    /**
     * Finds the PayrollGroup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PayrollGroup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PayrollGroup::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
