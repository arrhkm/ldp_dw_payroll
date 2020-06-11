<?php

namespace app\controllers;

use Yii;
use app\models\Employee;
use app\models\EmployeeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\ImportForm;
use yii\web\UploadedFile;
use moonland\phpexcel\Excel;
//use yii\data\ArrayDataProvider;
use app\models\UbahGaji;

/**
 * EmployeeController implements the CRUD actions for Employee model.
 */
class EmployeeController extends Controller
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
     * Lists all Employee models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmployeeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Employee model.
     * @param string $id
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
     * Creates a new Employee model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Employee();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->emp_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Employee model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->emp_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Employee model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionUbahgaji()
    {
        $model = new UbahGaji();

        if ($model->load(Yii::$app->request->post())){
            
            $employee = Employee::find()->filterWhere(['gaji_pokok'=>$model->gaji_lama])->all();
            if (isset($employee)){

                foreach ($employee as $data) {
                    $emp = $this->findModel($data['emp_id']);
                    $emp->gaji_pokok = $model->gaji_baru;
                    $emp->save();
                }
            }
            return $this->render('ubahgaji', [
                'employee'=>$employee, 
                'model'=>$model,
                    'update'=>'Ubah Gaji',
            ]);
              

        } 

        return $this->render('ubahgaji',[
            'model'=>$model,
            'update'=>'Ubah Gaji',
        ]);

    }

    public function actionUbahjamsostek()
    {
        $model = new UbahGaji();

        if ($model->load(Yii::$app->request->post())){
            //if(Employee::find()->filterWhere(['gaji_pokok'=>$model->gaji_lama])->exist()){
                $employee = Employee::find()->filterWhere(['pot_jamsos'=>$model->gaji_lama])->all();
                if (isset($employee)){

                    foreach ($employee as $data) {
                        $emp = $this->findModel($data['emp_id']);
                        $emp->pot_jamsos = $model->gaji_baru;
                        $emp->save();
                    }
                }
                return $this->render('ubahjamsostek', [
                    'employee'=>$employee, 
                    'model'=>$model,
                    'update'=>'Ubah Jamsostek',
                ]);
            //}

            

        } 

        return $this->render('ubahjamsostek',[
            'model'=>$model,
            'update'=>'Ubah Jamsostek',
        ]);

    }

    /**
     * Finds the Employee model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Employee the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Employee::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
