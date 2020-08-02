<?php

namespace app\controllers;

use app\components\EmployeeList;
use Yii;
use app\models\Spkl;
use app\models\SpklSeach;
use app\models\UploadForm;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * SpklController implements the CRUD actions for Spkl model.
 */
class SpklController extends Controller
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
     * Lists all Spkl models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SpklSeach();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Spkl model.
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
     * Creates a new Spkl model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Spkl();
        $model->id = $model->getLastId();

        $emp = New EmployeeList();
        $emp_list = $emp->getEmployeeActive();



        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'emp_list'=>$emp_list,
        ]);
    }

    /**
     * Updates an existing Spkl model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $emp = New EmployeeList();
        $emp_list = $emp->getEmployeeActive();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'emp_list'=>$emp_list,
        ]);
    }

    /**
     * Deletes an existing Spkl model.
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
     * Finds the Spkl model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Spkl the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Spkl::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionImportspkl(){
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
                   

                return $this->render('importspkl', [                     
                    'model'=>$model,                    
                    'provider'=>$provider,
                ]); 
            }
        }

      
        return $this->render('importspkl',[          
            'model'=>$model,
            
        ]);
    }
}
