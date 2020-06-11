<?php

namespace app\controllers;

use Yii;
use app\models\InsentifResiko;
use app\models\InsentifResikoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\ImportForm;
use yii\web\UploadedFile;
use moonland\phpexcel\Excel;
use yii\data\ArrayDataProvider;


/**
 * IresikoController implements the CRUD actions for InsentifResiko model.
 */
class IresikoController extends Controller
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
     * Lists all InsentifResiko models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InsentifResikoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single InsentifResiko model.
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
     * Creates a new InsentifResiko model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new InsentifResiko(); 
        $model->id = $model->getLastId();      

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actonImportfile()
    {

        $model = New ImportForm();
        if (Yii::$app->request->isPost) {            
            $model->excelFile = UploadedFile::getInstance($model, 'excelFile');            
            if ($model->upload()) { // file is uploaded successfully  
                $fileName = Yii::$app->basePath.'/web/upload_file/'.$model->excelFile->name;
                $data = Excel::import($fileName, [
                    'setFirstRecordAsKeys' => true, // if you want to set the keys of record column with first record, if it not set, the header with use the alphabet column on excel. 
                    //'setIndexSheetByName' => true, // set this if your excel data with multiple worksheet, the index of array will be set with the sheet name. If this not set, the index will use numeric. 
                    'getOnlySheet' => 'Sheet1', // you can set this property if you want to get the specified sheet from the excel data with multiple worksheet.
                ]);                             
                unlink($fileName);//Hapus file nya... 

                if(isset($data)){
                    $dataArray = [];                    
                    foreach ($data as $dt){
                        //$id = Attlog::getLastId();
                        //$dateTime = $dt['date_log']; //Yii::$app->formatter->asDatetime($dt['date_log'], 'php:Y-m-d H:i:s');
                        
                        //$lastlog = Attlog::find()->where(['id_attmachine'=>$dt['id_attmachine']])->max('date_log');
                       
                        //if (strtotime($dateTime) < strtotime($lastlog) || in_array($dt['id_attmachine'], [7]) ){
                            /*$Log = New Attlog();
                            $Log->id = Attlog::getLastId();
                            $Log->date_log = $dateTime;
                            $Log->pin = $dt['pin'];                                                             
                            $Log->id_attmachine= $dt['id_attmachine'];
                            $Log->status = 100;
                            $Log->verified = 100;
                            $Log->save();
                            */
                            array_push($dataArray, [
                                'emp_id'=>$dt['emp_id'],
                                'value'=>$dt['value'],
                                'date_insentif'=>$dt['date_insentif'],                                
                            ]);
                        //} 
                    }
                }
            }
        }
        return $this->render('importfile',[
            'model'=> $model,
            'data'=>$dataArray,
        ]);

    }

    public function actionImport(){
        $model = New ImportForm();

        if (Yii::$app->request->isPost) {            
            $model->excelFile = UploadedFile::getInstance($model, 'excelFile');            
            if ($model->upload()) { // file is uploaded successfully  
                $fileName = Yii::$app->basePath.'/web/upload_file/'.$model->excelFile->name;
                $data = Excel::import($fileName, [
                    'setFirstRecordAsKeys' => true, // if you want to set the keys of record column with first record, if it not set, the header with use the alphabet column on excel. 
                    //'setIndexSheetByName' => true, // set this if your excel data with multiple worksheet, the index of array will be set with the sheet name. If this not set, the index will use numeric. 
                    'getOnlySheet' => 'Sheet1', // you can set this property if you want to get the specified sheet from the excel data with multiple worksheet.
                ]);                             
                unlink($fileName);//Hapus file nya... 

                if(isset($data)){
                    $dataArray = [];                    
                    foreach ($data as $dt){
                        
                            $i_resiko = InsentifResiko::find()->where(['employee_emp_id'=>$dt['emp_id'], 'date_insentif'=>$dt['date_insentif']]);
                            if (!$i_resiko->exists()){
                                $model_iresiko = New InsentifResiko();
                                $model_iresiko->id = $model_iresiko->getLastId();
                                $model_iresiko->employee_emp_id = $dt['emp_id'];
                                $model_iresiko->value = $dt['value'];
                                $model_iresiko->date_insentif = $dt['date_insentif'];
                                $model_iresiko->save();

                                array_push($dataArray, [
                                    'emp_id'=>$dt['emp_id'],
                                    'value'=>$dt['value'],
                                    'date_insentif'=>$dt['date_insentif'],                                
                                ]);

                            }
                           
                        //} 
                    }
                    $provider = new ArrayDataProvider([     
                        'allModels'=>$dataArray,
                        'pagination' => [
                            'pageSize' => 10000,
                        ],
                    ]);
                    return $this->render('import', [
                        'model'=>$model,
                        'data'=>$dataArray,
                        'provider'=>$provider,
                    ]);
                }

            }
        }

        return $this->render('import', [
            'model'=>$model,
            //'data'=>'Test',
        ]);

    }

    /**
     * Updates an existing InsentifResiko model.
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
     * Deletes an existing InsentifResiko model.
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
     * Finds the InsentifResiko model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InsentifResiko the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InsentifResiko::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
