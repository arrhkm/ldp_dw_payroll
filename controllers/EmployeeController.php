<?php

namespace app\controllers;

use app\models\Coreperson;
use Yii;
use app\models\Employee;
use app\models\EmployeeSearch;
use PHPUnit\Framework\Constraint\ArrayHasKey;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * EmployeeController implements the CRUD actions for Employee model.
 */
class EmployeeController extends Controller
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
     * Lists all Employee models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmployeeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionEmployeeclose()
    {
        $searchModel = new EmployeeSearch();
        $dataProvider = $searchModel->searchEmployeeClose(Yii::$app->request->queryParams);

        return $this->render('employeeclose', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Employee model.
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
     * Creates a new Employee model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Employee();
        $model->id = $model->getLastId();   
        if ($model->load(Yii::$app->request->post())) {
            $model->name = Coreperson::findOne($model->id_coreperson)->name;
            if ($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
            
        }

        return $this->render('create', [
            'model' => $model,
            'employee_list'=> $this->getEmployeeUnList(),
        ]);
    }

    /**
     * Updates an existing Employee model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {
            //$model->name = Coreperson::findOne($model->id_coreperson)->name;
            if ($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
            
        }

        return $this->render('update', [
            'model' => $model,
            'employee_list'=>$this->getEmployeeList(),//getEmployeeUnList(),
        ]);
    }

    /**
     * Deletes an existing Employee model.
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

    /**
     * Finds the Employee model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Employee the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Employee::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function getEmployeeUnList(){
        $person =  Employee::find()->with('coreperson')->all();
        $id = [];
        foreach ($person as $persons){
            array_push($id, $persons['id_coreperson']);
        }
        $person_list = Coreperson::find()->where(['NOT IN','id', $id])->all();
        $employee_list = ArrayHelper::map($person_list, 'id','name');
        return $employee_list;
    }

    public function getEmployeeList(){
        $employee = Employee::find()->with(['coreperson'])->asArray()->all();
        
       
        
        return ArrayHelper::map($employee, 'id','name');
    }
}
