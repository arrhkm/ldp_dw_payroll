<?php

namespace app\controllers;

use Yii;
use app\models\Bpjs;
use app\models\BpjsSearch;
use app\models\Employee;
use app\models\ModelFormImportBpjs;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use moonland\phpexcel\Excel;
use yii\data\ArrayDataProvider;


/**
 * BpjsController implements the CRUD actions for Bpjs model.
 */
class BpjsController extends Controller
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
     * Lists all Bpjs models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BpjsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Bpjs model.
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
     * Creates a new Bpjs model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Bpjs();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Bpjs model.
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
     * Deletes an existing Bpjs model.
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

    public function getDataImport($data){
        $array_data =[];
        $connect = Yii::$app->db;
        foreach ($data as $dt){            
           
            if (Employee::find(['reg_number'=>$dt['reg_number']])->exists()){
                $qry="SELECT id FROM employee WHERE reg_number=:reg_number";
                $command = $connect->createCommand($qry);
                $command->bindValue(':reg_number', $dt['reg_number']);
                $id_employee = (int)$command->queryScalar();
                $employee = Employee::find()->where(['id'=>$id_employee])->one();

                $model = Bpjs::find()->where(['id_employee'=>$id_employee]);
                
                if ($model->exists()){
                   
                    array_push($array_data, [
                        'reg_number'=>$dt['reg_number'],
                        'name'=>$employee->name,
                        'bpjs_ker'=>$dt['bpjs_kes'],
                        'bpjs_tkerja'=>$dt['bpjs_tkerja'],
                        'status'=>'sudah masuk database',
                    ]);
                }else {

                    if (!empty($id_employee)){
                        $bpjs_push = New Bpjs;
                        $bpjs_push->id = $bpjs_push->getLastId();
                        $bpjs_push->id_employee = $employee->id;
                        $bpjs_push->bpjs_kes = 'basic*0.2';
                        $bpjs_push->bpjs_tkerja = 'basic*0.1';
                        $bpjs_push->save();
                        array_push($array_data, [
                            'reg_number'=>$dt['reg_number'],
                            'name'=>$employee->name,
                            'bpjs_ker'=>$dt['bpjs_kes'],
                            'bpjs_tkerja'=>$dt['bpjs_tkerja'],
                            'status'=>'New',
                        ]);
                    }
                   
                }
            }else {
                array_push($array_data, [
                    'reg_number'=>$dt['reg_number'],                    
                    'bpjs_ker'=>$dt['bpjs_kes'],
                    'bpjs_tkerja'=>$dt['bpjs_tkerja'],
                    'status'=>'REG_NUMBER tidak terdaftar di employee',
                ]);
            }        
        }
        return $array_data;
       
    }

    public function actionImportcsv(){
        $model = New ModelFormImportBpjs;
        $data=[];
        $array_data=[];
        if (Yii::$app->request->isPost) { 
            //$x = Yii::$app->request;     
            $model->excelFile = UploadedFile::getInstance($model, 'excelFile');  
           
            if ($model->upload()) { 
                $fileName = Yii::$app->basePath.'/web/upload_file/'.$model->excelFile->name;
                $data = Excel::import($fileName, [
                    'setFirstRecordAsKeys' => true, // if you want to set the keys of record column with first record, if it not set, the header with use the alphabet column on excel. 
                    'getOnlySheet' => 'Sheet1', // you can set this property if you want to get the specified sheet from the excel data with multiple worksheet.
                ]);                             
                unlink($fileName);
                
                $array_data = $this->getDataImport($data);
            }
        }

        return $this->render('importcsv', [
            'model'=>$model,
            //'data'=>$dataArray,
            //'provider'=>$provider,
            'data'=>$data,
            'array_data'=>$array_data,
           
        ]);
    }
    /**
     * Finds the Bpjs model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Bpjs the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Bpjs::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
