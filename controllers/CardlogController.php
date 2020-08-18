<?php

namespace app\controllers;

use Yii;
use app\models\Cardlog;
use app\models\CardlogSearch;
use app\models\Employee;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * CardlogController implements the CRUD actions for Cardlog model.
 */
class CardlogController extends Controller
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
     * Lists all Cardlog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CardlogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cardlog model.
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
     * Creates a new Cardlog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function getEmployee(){
         //register
         $regs = [];
         foreach (Cardlog::find()->all() as $reg){
             array_push($regs, $reg->id);
         }
         $emp = Employee::find()->where(['NOT IN', 'id', $regs])->andWhere(['is_active'=>True])->all();
         return ArrayHelper::map($emp, 'id', 'name');
    }

    public function getEmployeeUpdate(){
        //register
        
        $emp = Employee::find()->all();
        return ArrayHelper::map($emp, 'id', 'name');
   }

    public function actionCreate()
    {
        $model = new Cardlog();
        $model->id = $model->getLastId();    

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'emp_list'=>$this->getEmployee(),
        ]);
    }

    /**
     * Updates an existing Cardlog model.
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
            'emp_list'=>$this->getEmployeeUpdate(),
        ]);
    }

    /**
     * Deletes an existing Cardlog model.
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
     * Finds the Cardlog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cardlog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cardlog::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
