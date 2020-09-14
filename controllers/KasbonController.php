<?php

namespace app\controllers;

use app\components\EmployeeList;
use app\models\DetilKasbon;
use Yii;
use app\models\Kasbon;
use app\models\KasbonPlan;
use app\models\Kasbonsearch;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * KasbonController implements the CRUD actions for Kasbon model.
 */
class KasbonController extends Controller
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
     * Lists all Kasbon models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Kasbonsearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionClose()
    {
        $searchModel = new Kasbonsearch();
        $dataProvider = $searchModel->searchKasbonClose(Yii::$app->request->queryParams);

        return $this->render('close', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Kasbon model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $detil = DetilKasbon::find()->where(['id_kasbon'=>$id])->all();
        $detilProvider = New ArrayDataProvider([
            'allModels'=>$detil,
        ]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'detilProvider'=>$detilProvider,
        ]);
    }

    /**
     * Creates a new Kasbon model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Kasbon();
        $model->scenario = Kasbon::SCENARIO_CREATE;

        $model->id = $model->getLastId();
        $emp = EmployeeList::getEmployeeActive();
        $model->is_active = TRUE;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'emp'=>$emp,
        ]);
    }

    public function actionKasbonPlan($id){
        $kasbon = $this->findModel($id);
        $model = KasbonPlan::find()->where(['id_kasbon'=>$kasbon->id])
            ->orderBy(['date_kasbon_plan'=>SORT_ASC]);
        $dataProvider = New ActiveDataProvider([
            'query'=>$model,
            'pagination'=>False,

        ]);
        
        return $this->render('view-plan',[
            'kasbon'=>$kasbon,
            'dataProvider'=>$dataProvider,
        ]);
        
        //var_dump($dataProvider);
    }

    public function actionDeletePlan($id_kasbon, $id){
        $kasbon_plan = KasbonPlan::findOne($id);
        if ($kasbon_plan->delete()){
            return $this->redirect(['kasbon-plan', 'id'=>$id_kasbon]);
        }
    }

    public function actionCreatePlan($id){
        $kasbon = $this->findModel($id);
        $model = New KasbonPlan();

        if($model->load(Yii::$app->request->post())){
            $model->id_kasbon = $kasbon->id;
            $list_date = explode(';',$model->date_kasbon_plan);
            $dtarr = [];
            foreach ($list_date as $dtdate){
                $cek = KasbonPlan::find()->where(['date_kasbon_plan'=>$dtdate, 'id_kasbon'=>$model->id_kasbon]);
                if (!$cek->exists()){
                    $kasbon_plan = New KasbonPlan();
                    $kasbon_plan->id = $kasbon_plan->getLastId();
                    $kasbon_plan->date_kasbon_plan = $dtdate;
                    $kasbon_plan->plan_value = $model->plan_value;
                    $kasbon_plan->id_kasbon = $model->id_kasbon;
                    $kasbon_plan->is_close = FALSE;
                    $kasbon_plan->save();
                   array_push($dtarr, [
                        'id_kasbon'=>$model->id_kasbon,
                        'plan_value'=>$model->plan_value,
                        'date_kasbon_plan'=>$model->date_kasbon_plan

                   ]);
                }
                //var_dump($dtarr);
                
            }

            return $this->redirect(['kasbon-plan', 'id'=>$kasbon->id]);
        }

        return $this->render('create-plan',[
            'model'=>$model,
            'kasbon'=>$kasbon,
        ]);
    }

    public function actionUpdatePlan($id, $id_kasbon){
        $kasbon = $this->findModel($id_kasbon);
        $model = KasbonPlan::findOne($id);
        
        if($model->load(Yii::$app->request->post())){
            $model->save();
            return $this->redirect(['kasbon-plan', 'id'=>$kasbon->id]);
        }
        return $this->render('update-plan',[
            'model'=>$model,
            'kasbon'=>$kasbon,
        ]);
    }

    /**
     * Updates an existing Kasbon model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $emp = EmployeeList::getEmployeeActive();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'emp'=>$emp,
        ]);
    }

    /**
     * Deletes an existing Kasbon model.
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
     * Finds the Kasbon model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Kasbon the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Kasbon::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
