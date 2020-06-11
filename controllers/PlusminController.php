<?php

namespace app\controllers;

use Yii;
use app\models\PlusminGaji;
use app\models\PlusminGajiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\FormPlusmin;
use app\models\Periode;
use yii\helpers\ArrayHelper;
use yii\data\ArrayDataProvider;
use yii\web\UploadedFile;
use moonland\phpexcel\Excel;

/**
 * PlusminController implements the CRUD actions for PlusminGaji model.
 */
class PlusminController extends Controller
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
     * Lists all PlusminGaji models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PlusminGajiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PlusminGaji model.
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
     * Creates a new PlusminGaji model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PlusminGaji();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->kd_plusmin]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PlusminGaji model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->kd_plusmin]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PlusminGaji model.
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

    public function actionImportcsv(){
        $model = New FormPlusmin();
        $period = Periode::find()->orderBy('tgl_akhir desc')->all();
        $period_list = ArrayHelper::map($period, 'kd_periode','nama_periode');
        
        if (Yii::$app->request->isPost) { 
            $x = Yii::$app->request;
        //if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->kd_periode = Yii::$app->request->get('kd_periode');
            $model->excelFile = UploadedFile::getInstance($model, 'excelFile');  
            //$model->load(Yii::$app->request->post());   
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
                        
                            $plusmin = PlusminGaji::find()->where(['emp_id'=>$dt['emp_id'], 'tgl_plusmin'=>$dt['tgl_plusmin']]);
                            if (!$plusmin->exists()){
                                $model_plusmin = New PlusminGaji();
                                $model_plusmin->kd_periode = $dt['kd_periode'];
                                $model_plusmin->kd_plusmin = $model_plusmin->getLastId();
                                $model_plusmin->emp_id = $dt['emp_id'];
                                $model_plusmin->tgl_plusmin = $dt['tgl_plusmin'];
                                $model_plusmin->jml_plus = $dt['jml_plus'];
                                $model_plusmin->jml_min = $dt['jml_min'];
                                
                                $model_plusmin->ket = $dt['ket'];
                                $model_plusmin->save();

                                array_push($dataArray, [
                                    'kd_plusmin'=>$model_plusmin->kd_plusmin,
                                    'kd_periode'=>$dt['kd_periode'],
                                    'emp_id'=>$dt['emp_id'],
                                    'tgl_plusmin' => $dt['tgl_plusmin'],
                                    'jml_plus'=>$dt['jml_plus'],
                                    'jml_min'=>$dt['jml_min'],  
                                    'ket'=>$dt['ket'],
                                                                  
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
                    return $this->render('importcsv', [
                        'model'=>$model,
                        'data'=>$dataArray,
                        'provider'=>$provider,
                        'period_list'=>$period_list,
                        'x'=>$x,
                    ]);
                }

            }
        }


        return $this->render('importcsv', [
            'model'=>$model,            
            'period_list'=>$period_list,
            'data'=>$dataArray,
            'x'=>$x,
        ]);
    }

    /**
     * Finds the PlusminGaji model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PlusminGaji the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PlusminGaji::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
