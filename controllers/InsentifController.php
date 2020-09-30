<?php

namespace app\controllers;

use app\components\EmployeeList;
use Yii;
use app\models\Insentif;
use app\models\InsentifMaster;
use app\models\InsentifSearch;
use app\models\ModelFormInsentifMultipleDate;
use app\models\TimeshiftOption;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * InsentifController implements the CRUD actions for Insentif model.
 */
class InsentifController extends Controller
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
     * Lists all Insentif models.
     * @return mixed
     */
    public function getEmployyeActive(){
        $emp = New EmployeeList();
        $emp_list = $emp->getEmployeeActive();
        
        return $emp_list;
    }

    public function getMasterInsentif(){
        $master_insentif = ArrayHelper::map(InsentifMaster::find()->all(), 'id','name');
        return $master_insentif;
    }
    public function actionIndex()
    {
        $searchModel = new InsentifSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Insentif model.
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
     * Creates a new Insentif model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Insentif();
        $model->id = $model->getLastId();

        $emp = New EmployeeList();
        $emp_list = $emp->getEmployeeActive();
        $master_insentif = ArrayHelper::map(InsentifMaster::find()->all(), 'id','name');
        if (Yii::$app->request->isAjax){
            if ($model->load(Yii::$app->request->post())&& $model->validate())  {
                if ($model->save()){
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                
            }

            return $this->renderAjax('create',[
                'model' => $model,
                'emp_list'=>$emp_list,
                'master_insentif'=>$master_insentif,
            ]);
        }else {
        

        /*return $this->render('create', [
            'model' => $model,
            'emp_list'=>$emp_list,
            'master_insentif'=>$master_insentif,
        ]);
        */
        return $this->render('create',[
            'model' => $model,
            'emp_list'=>$emp_list,
            'master_insentif'=>$master_insentif,
        ]);
        }
    }

    public function actionCreatemultiple(){
        $model = new ModelFormInsentifMultipleDate();
        //-------------------------------------------
        $emp = New EmployeeList();
        $emp_list = $emp->getEmployeeActive();
        $master_insentif = ArrayHelper::map(InsentifMaster::find()->all(), 'id','name');
        //-------------------------------------------
        if ($model->load(Yii::$app->request->post())&& $model->validate()){
            
            $x= explode(';',$model->date_insentif);
            var_dump($x);
            var_dump($model);
            foreach ($x as $dtdate){
                $cek = Insentif::find()->where(['id_employee'=>$model->id_employee, 'date_insentif'=>$dtdate, 'id_insentif_master'=>$model->id_insentif_master]);
                if(!$cek->exists()){
                    $insentif = New Insentif;
                    $insentif->date_insentif = $dtdate;
                    $insentif->id_insentif_master = $model->id_insentif_master;
                    $insentif->id_employee = $model->id_employee;
                    $insentif->id = $insentif->getLastId();
                    $insentif->save();
                }
            }
            return $this->redirect(['index']);
           
        }else {
            return $this->renderAjax('createmultiple',[
                'model'=>$model,
                'emp_list'=>$emp_list,
                'master_insentif'=>$master_insentif,
            ]);
        }
        
    }

    /**
     * Updates an existing Insentif model.
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
            'emp_list'=>$this->getEmployyeActive(),
            'master_insentif'=>$this->getMasterInsentif(),
        ]);
    }

    /**
     * Deletes an existing Insentif model.
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

    public function actionDeleteselected(){
        if (Yii::$app->request->isAjax){
            $x= Yii::$app->request->post();
            /*foreach($x['item'] as $dt){
                
            }*/
            Insentif::deleteAll(['id'=>$x['item']]);
            return $this->redirect(['index']);
        }
    }
    

    /**
     * Finds the Insentif model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Insentif the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Insentif::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
