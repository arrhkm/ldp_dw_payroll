<?php

namespace app\controllers;

use Yii;
use app\models\Timeshift;
use app\models\TimeshiftDetil;
use app\models\TimeshiftSearch;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TimeshiftController implements the CRUD actions for Timeshift model.
 */
class TimeshiftController extends Controller
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
     * Lists all Timeshift models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TimeshiftSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Timeshift model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        //Tsd
        $Tsd = TimeshiftDetil::find()->where(['id_timeshift'=>$id])->orderBy(['num_day'=>'ASC'])->all();
        $Provider = New ArrayDataProvider([
            'allModels'=>$Tsd,
            'pagination'=>[
                'pageSize'=>7,
            ]
        ]);


        return $this->render('view', [
            'model' => $this->findModel($id),
            'Provider'=>$Provider,
        ]);
    }

    /**
     * Creates a new Timeshift model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Timeshift();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionAdddetil($id){
        $model = $this->findModel($id);
        $modelDetil = New TimeshiftDetil();
        $modelDetil->id = $modelDetil->getLastId();
        $modelDetil->id_timeshift = $model->id;
        //$modelDetil->id_outservice = $model->id;
        if ($modelDetil->load(Yii::$app->request->post()) && $modelDetil->save()){
            return $this->redirect(['view', 'id'=>$model->id]);
        }
        
        return $this->render('_form_detil', [
            'model'=>$model,
            'modelDetil'=>$modelDetil,
        ]);
    }

    public function actionDeletedetil($id){
        $modelDetil = TimeshiftDetil::findOne($id);
        $model = $this->findModel($modelDetil->id_timeshift);
        if ($modelDetil->delete()){
            return $this->redirect(['view', 'id'=>$model->id]);
        }
    }

    public function actionUpdatedetil($id){
        $modelDetil = TimeshiftDetil::findOne($id);
        $model = $this->findModel($modelDetil->id_timeshift);
        if ($modelDetil->load(Yii::$app->request->post()) && $modelDetil->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('updatedetil', [
            'model' => $model,
            'modelDetil'=>$modelDetil,
        ]);
    }

    /**
     * Updates an existing Timeshift model.
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
     * Deletes an existing Timeshift model.
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
     * Finds the Timeshift model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Timeshift the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Timeshift::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
