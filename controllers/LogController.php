<?php

namespace app\controllers;

use app\components\EmployeeList;
use app\models\Cardlog;
use Yii;
use app\models\Log;
use app\models\LogSearch;
use app\models\ModelFormLog;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LogController implements the CRUD actions for Log model.
 */
class LogController extends Controller
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
     * Lists all Log models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Log model.
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
     * Creates a new Log model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Log();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionLogBaru(){
        $model = New ModelFormLog();
        
        if ($model->load(Yii::$app->request->post())){
            $card = Cardlog::findOne(['id_employee'=>$model->id_employee]);
            $pin = $card->pin;            
            $dt_timestamp = "{$model->date_log} {$model->time_log}";

            $cek = Log::find()->where(['pin'=>$pin, 'timestamp'=>$dt_timestamp]);
            if(!$cek->exists()){
                $dt_log = New Log;
                $dt_log->id = $dt_log->getLastId();
                $dt_log->pin = $pin;
                $dt_log->timestamp = $dt_timestamp;
                $dt_log->status = 0;
                $dt_log->verification = 100;
                $dt_log->id_attmachine = 1;
                if($dt_log->save()){
                    return $this->render('_form-log',[
                        'model'=>$model,
                        'list_employee'=>EmployeeList::getEmployeeActive(),
                        'pin'=>$pin,
                        'dt_timestamp'=>$dt_timestamp,
                        
                    ]);
                }
            }
            
        }
        return $this->render('_form-log', [
            'model'=>$model,
            'list_employee'=>EmployeeList::getEmployeeActive(),
        ]);
    }

    /**
     * Updates an existing Log model.
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

    public function actionSetmasal(){
        $model = New ModelFormLog();
        
        if ($model->load(Yii::$app->request->post())){
            $dt_timestamp = "{$model->date_log} {$model->time_log}";

            foreach ($model->id_employee as $id_emp){
                $card = Cardlog::findOne(['id_employee'=>$id_emp]);
                $pin = $card->pin;            
               
                $cek = Log::find()->where(['pin'=>$pin, 'timestamp'=>$dt_timestamp]);
                if(!$cek->exists()){
                    $dt_log = New Log;
                    $dt_log->id = $dt_log->getLastId();
                    $dt_log->pin = $pin;
                    $dt_log->timestamp = $dt_timestamp;
                    $dt_log->status = 0;
                    $dt_log->verification = 100;
                    $dt_log->id_attmachine = 1;
                    $dt_log->save();
                        /*return $this->render('_form-log-masal',[
                            'model'=>$model,
                            'list_employee'=>EmployeeList::getEmployeeActive(),
                            'pin'=>$pin,
                            'dt_timestamp'=>$dt_timestamp,
                            
                        ]);
                    */
                }
            }
        }
        return $this->render('_form-log-masal', [
            'model'=>$model,
            'list_employee'=>EmployeeList::getEmployeeActive(),
        ]);
    }

    /**
     * Deletes an existing Log model.
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
     * Finds the Log model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Log the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Log::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
