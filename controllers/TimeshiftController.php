<?php

namespace app\controllers;

use app\components\EmployeeList;
use app\models\Employee;
use app\models\PayrollGroup;
use app\models\PayrollGroupEmployee;
use app\models\PayrollGroupEmployeeSearch;
use Yii;
use app\models\Timeshift;
use app\models\TimeshiftDetil;
use app\models\TimeshiftEmployee;
use app\models\TimeshiftOption;
use app\models\TimeshiftSearch;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

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

    public function actionAnggota($id_timeshift){
        $t_option = TimeshiftOption::find()
        ->joinWith('employee a')
        ->where(['id_timeshift'=>$id_timeshift])
        ->orderBy(['a.reg_number'=>SORT_ASC])
        ;
        $dataProvider = New ActiveDataProvider([
            'query'=>$t_option,
        ]);

        return $this->render('anggota', [
            'dataProvider'=>$dataProvider,
            'id_timeshift'=>$id_timeshift,
            'model'=>Timeshift::findOne($id_timeshift),
           
        ]);
    }

    public function actionAddAnggota($id_timeshift){
        $searchModel = new PayrollGroupEmployeeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('_form-anggota',[
            //'list_employee'=>EmployeeList::getEmployeeActive(),
            //'model'=>$model,
            //'id_timeshift'=>$id_timeshift,
            //'list_group'=>$list_group, 
            'dataProvider'=>$dataProvider,
            'searchModel'=>$searchModel,
            'id_timeshift'=>$id_timeshift,
        ]);
    }

    public function actionAddtimeshiftemployee(){
        if (Yii::$app->request->isAjax){
            $x= Yii::$app->request->post();
            $id_timeshift=$x['id_timeshift'];
           
            foreach($x['item'] as $dt){
                $gorup = PayrollGroupEmployee::find()->where(['id'=>$dt])->one();
                $id_employee = $gorup->id_employee;
                $cek = TimeshiftOption::find()->where(['id_employee'=>$id_employee, 'id_timeshift'=>$id_timeshift]);
                if ($cek->exists()){
                    $TO = $cek->one();
                    $TO->id_employee = $id_employee;
                    $TO->id_timeshift = $id_timeshift;
                    $TO->save();

                }else {
                    $TO = New TimeshiftOption;
                    $TO->id = $TO->getLastId();
                    $TO->id_employee = $id_employee;
                    $TO->id_timeshift = $id_timeshift;
                   $TO->save();
                }
               
            }            
            return $this->redirect(['anggota','id_timeshift'=>$id_timeshift]);
        }
    }

    public function actionDeleteTimeshift($id, $id_timeshift){
        if (TimeshiftOption::findOne($id)->delete()){
            return $this->redirect(['anggota', 'id_timeshift'=>$id_timeshift]);
        }
    }

    public function actionCoba($data){
        return $this->render('coba',[
            'data'=>$data,
        ]);
    }

    // Generate list of subcat based on cat
    public function actionSubcat() {
        //Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            
            if ($parents != null){
                $cat_id = $parents[0];
                $out = PayrollGroupEmployee::getEmployeeList($cat_id);
                 /*\\backend\models\Branches::find()
                        ->where(['companies_company_id'=>$cat_id])
                        ->select(['branch_id','branch_name AS name'])->asArray()->all();
                */
                return  json_encode(['output'=>$out, 'selected'=>'']);
                    
            }
        }
        return json_encode(['output' => '', 'selected' => '']);
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
