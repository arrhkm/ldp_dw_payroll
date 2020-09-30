<?php

namespace app\controllers;

use Yii;
use app\models\Contract;
use app\models\ContractDetil;
use app\models\ContractHistories;
use app\models\ContractSearch;
use app\models\DetilKasbon;
use app\models\Employee;
use DateInterval;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ContractController implements the CRUD actions for Contract model.
 */
class ContractController extends Controller
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
     * Lists all Contract models.
     * @return mixed
     */
    public function actionIndex()
    {
        //$this->duplicateContract();

        $searchModel = new ContractSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Contract model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    
    public function actionView($id)
    {
        $query = ContractDetil::find()->where(['id_contract'=>$id]);
        $provider = New ActiveDataProvider([
            'query'=>$query,
        ]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'provider'=>$provider,
        ]);
    }

    /**
     * Creates a new Contract model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Contract();
        $model->id = $model->getLastId();
        $model->urutan_contract = 1;
        $model->is_active = TRUE;

        if ($model->load(Yii::$app->request->post()) ) {
            $start = date_create($model->start_contract);
            $end = $start->add(New DateInterval("P{$model->duration_contract}M"));
            $model->end_contract= $end->format('Y-m-d');
            $cek = Contract::find()->where(['id_employee'=>$model->id_employee]);
            if ($cek->exists()){

            }else{  
                $model->doh = $model->start_contract;          
                if ($model->save()){
                    $employee = Employee::findOne($model->id_employee);
                    $employee->is_active = $model->is_active;
                    $employee->date_of_hired = $model->doh;
                    $employee->save();
                    $this->duplicateOne($model->id);
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function getUrutan($id){
        $model = ContractDetil::find()->where(['id_contract'=>$id])
        ->limit(1)
        ->orderBy(['urutan_contract'=>SORT_DESC]);
        if ($model->exists()){
            $x =$model->one();
            $urutan = $x->urutan_contract + 1;

        }else {
            $urutan = 1;
        }
        return $urutan;
    }

    public function duplicateOne($id_contract){
        $Contract = Contract::findOne($id_contract);
        $record_urut = ContractDetil::find()->where(['id_contract'=>$id_contract])->orderBy(['start_contract'=>SORT_ASC])->all();
        $urutan = $this->getUrutan($record_urut, $Contract->start_contract);
        $cek = ContractDetil::find()->where(['id_contract'=> $id_contract, 'number_contract'=>$Contract->number_contract]);
        
        if ($cek->exists()){                
           
            $Detil = $cek->one();
           
            $Detil->start_contract=$Contract->start_contract;
            $Detil->end_contract= $Contract->end_contract;
            $Detil->duration_contract = $Contract->duration_contract;
            $start_obj = date_create($Contract->start_contract);
            //$start_obj->add(New DateInterval('P{$dt->duration_contract}M'));
            //$Detil->end_contract =  date_format($start_obj,"Y-m-d");
            $Detil->urutan_contract = $urutan;
            $Detil->save();
        }else {
            $Detil = New ContractDetil;
            $Detil->id = $Detil->getLastId();
            $Detil->id_contract = $Contract->id;
            $Detil->number_contract = $Contract->number_contract;
            $Detil->start_contract=$Contract->start_contract;
            $Detil->duration_contract = $Contract->duration_contract;
            $start_obj = date_create($Contract->start_contract);
            $start_obj->add(New DateInterval("P{$Contract->duration_contract}M"));
            $Detil->end_contract =  $start_obj->format("Y-m-d");
            $Detil->urutan_contract = $urutan;
            $Detil->save();
        }

    }

    public function duplicateContract($id){
        foreach  (Contract::findAll(['is_active'=>True]) as $dt){
            $record_urut = ContractDetil::find()->where(['id_contract'=>$dt->id])->orderBy(['start_contract'=>SORT_ASC])->all();
            //$urutan = $this->getUrutan($record_urut, $dt->start_contract);
            $urutan = $this->getUrutan($id);
            $cek = ContractDetil::find()->where(['id_contract'=> $dt->id, 'number_contract'=>$dt->number_contract]);
            
            if ($cek->exists()){                
               
                $Detil = $cek->one();
               
                $Detil->start_contract=$dt->start_contract;
                $Detil->duration_contract = $dt->duration_contract;
                $start_obj = date_create($dt->start_contract);
                //$start_obj->add(New DateInterval('P{$dt->duration_contract}M'));
                $Detil->end_contract =  date_format($start_obj,"Y-m-d");
                $Detil->urutan_contract = $urutan;
                $Detil->save();
            }else {
                $Detil = New ContractDetil;
                $Detil->id = $Detil->getLastId();
                $Detil->id_contract = $dt->id;
                $Detil->number_contract = $dt->number_contract;
                $Detil->start_contract=$dt->start_contract;
                $Detil->duration_contract = $dt->duration_contract;
                $start_obj = date_create($dt->start_contract);
                //$start_obj->add(New DateInterval('P{$dt->duration_contract}M'));
                $Detil->end_contract =  date_format($start_obj,"Y-m-d");
                $Detil->urutan_contract = $urutan;
                $Detil->save();
            }
        }
    }

    /**
     * Updates an existing Contract model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $urutan = $this->getUrutan($id);
        $model->urutan_contract = $urutan;
        $model->is_active = TRUE;

        if ($model->load(Yii::$app->request->post())) {
           $start = date_create($model->start_contract);
           $end = $start->add(New DateInterval("P{$model->duration_contract}M"));
           $model->end_contract= $end->format('Y-m-d');
            if ($model->save()){
                
                $this->duplicateOne($model->id);
                //if (!$model->is_active){
                    $employee = Employee::findOne($model->id_employee);
                    //$employee->is_active = FALSE;
                    //$employee->save();
                    
                //}
                
                $employee->basic_salary = $model->basic_salary;
                $employee->date_of_hired = $model->doh;
                $employee->is_active = $model->is_active;
                $employee->save();
                
                return $this->redirect(['view', 'id' => $model->id]);
            }
            
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    public function getLastContract($id){
        $x = ContractDetil::find() //->select('max($end_contract)')
        ->where([
            'id_contract'=>$id,            
        ])
        ->orderBy(['end_contract'=>SORT_DESC])->limit(1)
        ->one();
        return $x;
    }

    public function getUrutanContract(){
        
    }

    public function actionPerpanjangan($id){

        $model = New ContractDetil;
        $model->id_contract = $id;
        $model->id = $model->getLastId();
        $last_contract =  $this->getLastContract($id);
      
        $start = date_create($last_contract->end_contract);
        $start->add(New DateInterval('P1D'));
        $model->start_contract = $last_contract->end_contract; //$start->format('Y-m-d');
        $model->urutan_contract = $model->getUrutanContract($id);
        
        if ($model->load(Yii::$app->request->post())){
           
            $end = date_create($model->start_contract);
            $end->add(New DateInterval("P{$model->duration_contract}M"));
            $model->end_contract = $end->format('Y-m-d');
            //$model->status_execute = 'ok';
            
            if ($model->validate() && $model->save()){
                $contract = Contract::findOne($id);
                $contract->start_contract = $model->start_contract;
                $contract->end_contract = $model->end_contract;
                $contract->duration_contract = $model->duration_contract;
                $contract->save();
                return $this->redirect(['view', 'id'=>$id]);
            }
            //return $this->redirect(['view', 'id'=>$id]);
            return $this->render('_form-detil',[
                'id'=>$id,
                'model'=>$model,    
            ]);
        }
        
        return $this->render('_form-detil',[
            'id'=>$id,
            'model'=>$model,    
        ]);

    }

    public function actionDeleteDetil($id, $id_contract){
        $model_del = ContractDetil::findOne($id);
        $master_id = $model_del->id_contract;
        $id_set = ContractDetil::find()->where(['urutan_contract'=>$model_del->urutan_contract -1])->scalar();
        if ($model_del->delete()){
            $model_set = ContractDetil::findOne($id_set);
            $master_contract = Contract::findOne($master_id);
            $master_contract->start_contract = $model_set->start_contract;
            $master_contract->duration_contract = $model_set->duration_contract;
            $master_contract->end_contract = $model_set->end_contract;
            $master_contract->urutan_contract = $model_set->urutan_contract;
            $master_contract->save();
            return $this->redirect(['view', 'id'=>$id_contract]);
        }
    }

    public function actionSetDeffault($id, $id_contract){
        $model_set = ContractDetil::findOne($id);
        $contract = Contract::findOne($model_set->id_contract);
        $contract->duration_contract = $model_set->duration_contract;
        $contract->start_contract = $model_set->start_contract;
        $contract->end_contract = $model_set->end_contract;
        $contract->urutan_contract = $model_set->urutan_contract;
        $contract->number_contract = $model_set->number_contract;
        
        if($contract->save()){
            return $this->redirect(['view', 'id'=>$id_contract]);
        }
        
        

    }

    /**
     * Deletes an existing Contract model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $id_employee = $model->id_employee;
       
        $model->delete();
        $employee = Employee::findOne($id_employee);
        $employee->is_active = FALSE;
        $employee->save();
        ContractDetil::deleteAll(['id_contract'=>$id]);
        

        return $this->redirect(['index']);
    }

    /**
     * Finds the Contract model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Contract the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Contract::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
