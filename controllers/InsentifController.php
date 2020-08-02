<?php

namespace app\controllers;

use app\components\EmployeeList;
use Yii;
use app\models\Insentif;
use app\models\InsentifMaster;
use app\models\InsentifSearch;
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
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'emp_list'=>$emp_list,
            'master_insentif'=>$master_insentif,
        ]);
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
