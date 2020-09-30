<?php

namespace app\controllers;

use app\components\EmployeeList;
use Yii;
use app\models\AdjustmentSalary;
use app\models\AdjustmentSalarySearch;
use app\models\Employee;
use app\models\Period;
use app\models\PeriodSearch;
use app\models\UploadForm;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * AdjustmentsalaryController implements the CRUD actions for AdjustmentSalary model.
 */
class AdjustmentsalaryController extends Controller
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
                    //'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all AdjustmentSalary models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdjustmentSalarySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);      
       

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            
        ]);
    }
    public function actionPeriod(){
        //$period = ArrayHelper::map(Period::find()->orderBy(['end_date'=>SORT_DESC])->all(), 'id', 'end_date');
        $searchModel = new PeriodSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('period', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        
    }
    

    public function actionPeriodAdjustment($period_id){
        $model = New AdjustmentSalary();

        $period= Period::findOne($period_id);
        $searchModel = new AdjustmentSalarySearch();
        $dataProvider = $searchModel->searchByDate(Yii::$app->request->queryParams, $period->start_date, $period->end_date);

        return $this->render('index-adjustment-salary',[
            'searchModel'=>$searchModel,
            'dataProvider'=>$dataProvider,
            'period'=>$period,
            'model'=>$model,
        ]);
    }

    /**
     * Displays a single AdjustmentSalary model.
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
     * Creates a new AdjustmentSalary model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($period_id)
    {
        $model = new AdjustmentSalary();
        $model->id = $model->getLastId();
        $period= Period::findOne($period_id);
        $model->period_id = $period->id;
        $model->date_adjustment = $period->end_date;

        

        $list_code =['D'=>'Debet', 'K'=>'Kredit'];


        if ($model->load(Yii::$app->request->post())) {
            $model->date_adjustment = $period->end_date;
            $cek = AdjustmentSalary::find()->where([
                'id_employee'=>$model->id_employee, 
                'date_adjustment'=>$model->date_adjustment, 
                'code_adjustment'=>$model->code_adjustment]);
            if ($cek->exists()){
                $modelUpdate = AdjustmentSalary::find()->where([
                    'id_employee'=>$model->id_employee, 
                    'date_adjustment'=>$model->date_adjustment, 
                    'code_adjustment'=>$model->code_adjustment])
                    ->one();

                $modelUpdate->value_adjustment = $model->value_adjustment;
                $modelUpdate->save();
                return $this->redirect(['period-adjustment', 'period_id' => $period->id]);
            }else {
                $model->save();
                return $this->redirect(['period-adjustment', 'period_id' => $period->id]);
            }
            
        }

        return $this->render('create', [
            'model' => $model,
            'list_code'=>$list_code,
            'employee'=>EmployeeList::getEmployeeActive(),
        ]);
    }

    public function actionImport($id_period){
       
        $period = Period::findOne($id_period);
        $model = New UploadForm();
          
        $name="Null";
        $data = array();
        if (Yii::$app->request->isPost) {
            
            $model->excelFile = UploadedFile::getInstance($model, 'excelFile');            
            if ($model->upload()) {
                // file is uploaded successfully                
                
                $fileName = Yii::$app->basePath.'/web/upload_file/'.$model->excelFile->name;
                $data = \moonland\phpexcel\Excel::import($fileName, [
                    'setFirstRecordAsKeys' => true, // if you want to set the keys of record column with first record, if it not set, the header with use the alphabet column on excel. 
                    //'setIndexSheetByName' => true, // set this if your excel data with multiple worksheet, the index of array will be set with the sheet name. If this not set, the index will use numeric. 
                    'getOnlySheet' => 'Sheet1', // you can set this property if you want to get the specified sheet from the excel data with multiple worksheet.
                ]);
                
                
                unlink($fileName);//Hapus file nya...
                foreach ($data as $datas){
                    $employee = Employee::findOne(['reg_number'=>$datas['emp_id'],
                    ]);
                    $cek = AdjustmentSalary::find()->where([
                        'id_employee'=>$employee->id,
                        'date_adjustment'=>$datas['tanggal'],
                        'code_adjustment'=>$datas['code']
                    ]);
                    if ($cek->exists()){
                        $modelSave = AdjustmentSalary::find()->where([
                            'id_employee'=>$employee->id,
                            'date_adjustment'=>$datas['tanggal'],
                            'code_adjustment'=>$datas['code'],
                           
                        ])->one();
                        $modelSave->value_adjustment=$datas['value'];
                        $modelSave->description=$datas['keterangan'];
                        $modelSave->save();
                    }else {
                        $modelSave = New AdjustmentSalary();
                        $modelSave->id = $modelSave->getLastId();
                        $modelSave->id_employee = $employee->id;
                        $modelSave->date_adjustment = $datas['tanggal'];
                        $modelSave->code_adjustment = $datas['code'];
                        $modelSave->value_adjustment = $datas['value'];
                        $modelSave->save();
                    }
                }



                $provider = new ArrayDataProvider([
                    'allModels' => $data,
                    'sort' => [
                        'attributes' => [
                            //'pin', 
                            //'nama', 'total_gp', 
                            //'t_jabatan', 't_fungsional', 't_masakerja',
                            ],
                    ],
                    
                    'pagination' => [
                        'pageSize' => 1000,
                    ],
                ]);   
                $total = $provider->getCount();
                //$id_start = Payrollnew::getLastId();
                $dt_set = array();
                    

                return $this->render('import', [                     
                    'model'=>$model,                    
                    'provider'=>$provider,
                    'period'=>$period,
                ]); 
            }
        }
    
          
        return $this->render('import',[          
            'model'=>$model,
            'period'=>$period,
            
        ]);
    }
    

    /**
     * Updates an existing AdjustmentSalary model.
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
     * Deletes an existing AdjustmentSalary model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $period_id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['period-adjustment', 'period_id'=>$period_id]);
    }

    /**
     * Finds the AdjustmentSalary model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AdjustmentSalary the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AdjustmentSalary::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
