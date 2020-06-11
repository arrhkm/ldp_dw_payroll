<?php

namespace app\controllers;

use Yii;
use app\models\Spl;
use app\models\SplSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\ImportForm;
use yii\web\UploadedFile;
use moonland\phpexcel\Excel;
use yii\data\ArrayDataProvider;
use app\models\SalesOrder;
use app\models\SplDetil;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * SplController implements the CRUD actions for Spl model.
 */
class SplController extends Controller
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
     * Lists all Spl models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SplSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Spl model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $x = $model->splDetils;

        
        $model_spl_detil = New SplDetil();
        $model_spl_detil->id = $model_spl_detil->getLastId();
        $model_spl_detil->spl_id = $id;

        $query = New Query();
        $provider = new ArrayDataProvider([
            'allModels' => $query->from('spl_detil')->where(['spl_id'=>$id])->all(),
           
        ]);
        if ($model_spl_detil->load(Yii::$app->request->post()) && $model_spl_detil->validate()){
            $jam = 0;
            foreach ($model->splDetils as $rowdetil){
                $jam + $rowdetil['jam'];
            }
            //if ($jam < $model_spl_detil->jam){
                //$model_spl_detil->validateJam('jam', 10);
            //}else {

            $model_spl_detil->save();
            //}
            return $this->render('view', [
                'model' => $model,
                'model_spl_detil'=>$model_spl_detil,
                'list_so'=>$this->getListSo(),
                'provider'=>$provider,
                'hkm'=>$model->splDetils,
            ]);
        }
        return $this->render('view', [
            'model' => $model,
            'model_spl_detil'=>$model_spl_detil,
            'list_so'=>$this->getListSo(),
            'provider'=>$provider,
            'hkm' =>$model->splDetils,
        ]);
    }

    public function actionDelspldetil($id){
        $spl_detil = SplDetil::findOne($id);
        $id_spl = $spl_detil->spl_id;
        $spl_detil->delete();
        return $this->redirect(['view','id'=>$id_spl]);
    }

    /**
     * Creates a new Spl model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionImportspl(){
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
                        $start = date('Y-m-d',strtotime($dt['date_spl']));
                        $spl = Spl::find()->where(['employee_emp_id'=>$dt['emp_id'], 'date_spl'=>$start]);
                        if (!$spl->exists()){
                            $model_spl = New Spl();
                            $model_spl->scenario = Spl::SCENARIOCSV;
                            
                            $model_spl->id = $model_spl->getLastId();
                            $model_spl->employee_emp_id = $dt['emp_id'];
                            $model_spl->date_spl= $dt['date_spl'];
                            $model_spl->overtime_value = $dt['overtime_value'];
                            //$model_spl->start_lembur = $dt['start_lembur'];
                            //$model_spl->end_lembur = $dt['end_lembur'];                                
                            
                            //if ($model_spl->validate()){
                                array_push($dataArray, [
                                    'id'=> $model_spl->id,
                                    'emp_id'=>$dt['emp_id'],
                                    'date_spl'=>$dt['date_spl'],
                                    'overtime_value'=>$dt['overtime_value']
                                    //'start_lembur'=>$dt['start_lembur'],
                                    //'end_lembur'=>$dt['end_lembur'],                                
                                ]);
                                $model_spl->save();
                                //$lembur_id ++;
                            
                            //}
                           

                            
                            
                        }
                           
                    }
                    $provider = new ArrayDataProvider([     
                        'allModels'=>$dataArray,
                        'pagination' => [
                            'pageSize' => 10000,
                        ],
                    ]);
                    return $this->render('import_spl', [
                        'model'=>$model,
                        'data'=>$dataArray,
                        'provider'=>$provider,
                    ]);
                }

            }
        }

        return $this->render('import_spl', [
            'model'=>$model,
            //'data'=>'Test',
        ]);
    }

    public function getListSo(){
        $so = SalesOrder::find()->where(['is_active'=>1])->all();
        $so_modif = ArrayHelper::toArray($so, [
            'app\models\SalesOrder'=>[
                'so_number',
                'so_num_name'=>function($so){
                    return $so->so_number." # ".$so->so_name;
                }
            ] 
        ] );
        
        return ArrayHelper::map($so_modif, 'so_number','so_num_name');
    }

    public function actionCreate()
    {
        //LIST SO        
        /*
        $so = SalesOrder::find()->where(['is_active'=>1])->all();
        $so_modif = ArrayHelper::toArray($so, [
            'app\models\SalesOrder'=>[
                'so_number',
                'so_num_name'=>function($so){
                    return $so->so_number." # ".$so->so_name;
                }
            ] 
        ] );
        $data_so = ArrayHelper::map($so_modif, 'so_number','so_num_name');*/
        $data_so = $this->getListSo();
        //-------------


        //$model = new Spl(['scenario'=>Spl::SCENARIOINPUT]);
        $model = new Spl();
        $model->id = $model->getLastId();

        if ($model->load(Yii::$app->request->post())) {
            /*if (isset($model->start_lembur)){
                $date_start = date_create($model->start_lembur);
                $model->date_spl = date_format($date_start, "Y-m-d");
            }*/
            if ($model->validate()){
                if ($model->save()){
                    //$model_spl_detil = New SplDetil();

                    return $this->redirect(['view',
                        'id' => $model->id,
                        //'model_spl_detil'=>$model_spl_detil,
                    ]);
                }
            } /*else {
                return $this->render('create', [
                    'model' => $model,
                    'data_so'=>$so,
                ]);
            }*/
            
            
        }

        return $this->render('create', [
            'model' => $model,
            'data_so'=>$data_so,
        ]);
    }

    /**
     * Updates an existing Spl model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        //$model->setScenario('scenarioinput');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Spl model.
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
     * Finds the Spl model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Spl the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Spl::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
