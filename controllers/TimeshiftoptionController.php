<?php

namespace app\controllers;

use app\models\Employee;
use app\models\ModelFormTimeshiftEmployee;
use Yii;
use app\models\TimeshiftOption;
use app\models\TimeshiftOptionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\Timeshift;
use yii\data\ArrayDataProvider;

/**
 * TimeshiftoptionController implements the CRUD actions for TimeshiftOption model.
 */
class TimeshiftoptionController extends Controller
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
     * Lists all TimeshiftOption models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TimeshiftOptionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TimeshiftOption model.
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
     * Creates a new TimeshiftOption model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TimeshiftOption();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionTimeshiftoptionemployee(){
        $modelForm = New ModelFormTimeshiftEmployee();

        $employee_list = Employee::find()
        ->where([
            'is_active'=>true,
            
            ])
            ->all();
        $modelTimeshift = Timeshift::find()->all();
        $timeshift_list = ArrayHelper::map($modelTimeshift, 'id', 'name');
            $data_employee = ArrayHelper::map($employee_list, 'id', 'reg_number');
        if ($modelForm->load(Yii::$app->request->post()) && $modelForm->validate()){
            //Input data default Timeshift karyawan 
            foreach ($modelForm->id_employee as $ids){
                $timeshif = TimeshiftOption::find()->where(['id_employee'=>$ids, 'id_timeshift'=>$modelForm->id_timeshift]);
                if ($timeshif->exists()){
                    $t_ops = TimeshiftOption::find()->where(['id_timeshift'=>$modelForm->id_timeshift, 'id_employee'=>$ids]);
                }else {
                    $t_ops = New TimeshiftOption();
                    $t_ops->id = $t_ops->getLastId();
                    $t_ops->id_employee = $ids;
                    $t_ops->id_timeshift = $modelForm->id_timeshift;
                    $t_ops->save();
                }
            }
            $dt_t_ops = TimeshiftOption::find()->where(['id_timeshift'=>$modelForm->id_timeshift])->all();
            $timeshiftOptionProvider = New ArrayDataProvider([
                'allModels'=>$dt_t_ops,
                'pagination'=>[
                    'pageSize'=>20000,
                ]
            ]);
            return $this->render('timeshift_option_employee', [
                'model'=>$modelForm,
                'data_employee'=>$data_employee,
                'timeshift_list'=>$timeshift_list,
                'timeshiftOptionProvider'=>$timeshiftOptionProvider,
            ]);
        }

        return $this->render('timeshift_option_employee', [
            'model'=>$modelForm,
            'data_employee'=>$data_employee,
            'timeshift_list'=>$timeshift_list,
        ]);
    }

    /**
     * Updates an existing TimeshiftOption model.
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
     * Deletes an existing TimeshiftOption model.
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
     * Finds the TimeshiftOption model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TimeshiftOption the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TimeshiftOption::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
