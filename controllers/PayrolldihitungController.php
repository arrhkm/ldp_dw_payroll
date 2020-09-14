<?php

namespace app\controllers;

use app\components\EmployeeList;
use Yii;
use app\models\PayrollDihitung;
use app\models\PayrollDihitungSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PayrolldihitungController implements the CRUD actions for PayrollDihitung model.
 */
class PayrolldihitungController extends Controller
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
     * Lists all PayrollDihitung models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PayrollDihitungSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PayrollDihitung model.
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
     * Creates a new PayrollDihitung model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PayrollDihitung();

        if ($model->load(Yii::$app->request->post())) {
            $x=[];
            $x = $model->id_employee;           
            foreach ($x as $dt){
                $cek = PayrollDihitung::find()->where(['id_employee'=>$dt]);
                if(!$cek->exists()){
                    $tambah = new PayrollDihitung;
                    $tambah->id = $tambah->getLastId();
                    $tambah->id_employee = $dt;
                    $tambah->save();
                }
            }
            
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'list_employee'=>EmployeeList::getEmployeeActive(),
        ]);
    }

    public function actionDeleteall(){
        if (Yii::$app->request->isAjax){
            $x= Yii::$app->request->post();
            /*foreach($x['item'] as $dt){
                
            }*/
            PayrollDihitung::deleteAll(['id'=>$x['item']]);
            return $this->redirect(['index']);
        }
    }

    /**
     * Updates an existing PayrollDihitung model.
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
            'list_employee'=>EmployeeList::getEmployeeActive(),
        ]);
    }

    /**
     * Deletes an existing PayrollDihitung model.
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
     * Finds the PayrollDihitung model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PayrollDihitung the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PayrollDihitung::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
