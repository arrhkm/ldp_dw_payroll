<?php

namespace app\controllers;

use Yii;
use app\models\Attmachine;
use app\models\AttmachineSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Log;
use app\models\Cardlog;
use app\components\hkm\HkmLib;
use Exception;
use yii\data\ArrayDataProvider;
use app\models\DownloadMachineForm;
use app\models\Employee;
use yii\helpers\ArrayHelper;
use app\components\hkm\LogIntegration;
use app\models\Attendance;

/**
 * AttmachineController implements the CRUD actions for Attmachine model.
 */
class AttmachineController extends Controller
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
     * Lists all Attmachine models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AttmachineSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Attmachine model.
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
     * Creates a new Attmachine model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Attmachine();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Attmachine model.
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
     * Deletes an existing Attmachine model.
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

    public function actionDownload($id)
    {
        $machine = $this->findModel($id);
        $ip  = $machine->ip;
        $port = $machine->port;
        $com = $machine->com_key;

        try {
            //$log_data = Yii::$app->hkmlib->download($ip, $port, $com);
            $x = New HkmLib();
            $log_data = $x->download($ip, $port, $com);


            
        } catch (Exception $e){
                echo $e->getMessage();
        } 

       
         
        $lastlog = Log::find()->where(['id_attmachine'=>$id])->max('timestamp');
         //Jika adalog
         if (!isset($log_data)){
            return $this->render('download',[        
                'rows'=> null, //$dataProvider,
                'machine' => $machine, 
                'array_log'=> null, //$array_log,
                'lastlog'=>$lastlog,
            ]);
        } 
        $array_log=array();
        $first_id = Log::getLastId();
        //Populate $log_data To Array $array_log with id_log Auto Increment
        foreach ($log_data['Row'] as $value){  
            if (strtotime($value['DateTime']) > strtotime($lastlog)){
                array_push($array_log,[    
                    'id'=>$first_id,               
                    'pin'=>$value['PIN'],
                    'timestamp'=>$value['DateTime'],
                    'verifikasi'=>$value['Verified'],
                    'status'=>$value['Status'],                   
                    'id_machine'=>$id,
                ]);
                $first_id++;
                
            }   
        }
        //var_dump($array_log);
        
        //-- INSERT Data INTO table Attlog with bacht insert PHP Yii2
        Yii::$app->db->createCommand()->batchInsert(
        'log', 
        [
            'id',
            'pin', 
            'timestamp', 
            'verification',
            'status',            
            'id_attmachine'
        ],$array_log)->execute();
        //--END INSERT
        //
        //var_dump($log_data);
        $dataProvider = new ArrayDataProvider([
            'allModels' => $array_log,//$log_data['Row'],
            'pagination' => [
                'pageSize' => 500,
            ],	

        ]);
        
        return $this->render('download',[        
            'rows'=>$dataProvider,
            'machine' => $machine, 
            'array_log'=>$array_log,
            'lastlog'=>$lastlog,
        ]);

    }

    public function actionIntegration(){
        $model = New DownloadMachineForm();

        if ($model->load(Yii::$app->request->post())){
            $tgl = $model->start_date." s/d ".$model->end_date;
            $absensi = Log::find()->where(['Between', 'date(timestamp)', $model->start_date, $model->end_date])->all();
            $mylog = ArrayHelper::toArray($absensi);

            $myLog = [];
            foreach ($absensi as $log){
                array_push($myLog, [
                    'pin'=>$log->pin, 
                    'timestamp'=>$log->timestamp, 
                    'verification'=>$log->verification, 
                    'status'=>$log->status
                ]);
            }

            $list_day = Yii::$app->date_range->getListDay($model->start_date, $model->end_date);


            //VARIABLE 
            $emp_array=[];
            $integrated_log = [];
            //$cards = array();


            //Cari Employe yang punya kartu absensi  
            
              
            foreach (Employee::find()->all() as $emp) {
            //foreach (Employee::find()->where(['id'=>161])->all() as $emp) {
            // $customer is a attcard object with the 'employee' relation populated
                $_card = Cardlog::find()->select(['pin', 'id_employee'])->where(['id_employee'=>$emp->id])->all();
                array_push($emp_array, [                    
                    'reg_number'=>$emp->reg_number,
                    'id_employee'=>$emp->id,
                    'emp_name'=>$emp->name,
                    'cards'=>$_card,
                ]);              
               
            }
            //-------------end loop employe yang punya kartu -----------------

            foreach ($emp_array as $myEmp){
                //------------------------------------------
                
                foreach ($list_day as $listday){ 
                    //echo "-----------------------------------------------------------------------------------------<br>";
                    $iter = New LogIntegration($myLog, $myEmp['id_employee'], $myEmp['cards'], $listday);
                    
                    $iter->getLog();
                    if ($iter->in!=NULL && $iter->out!=NULL){
                        if ($iter->in===$iter->out){
                            $in = date("Y-m-d H:i:s", $iter->in);                    
                            $out=NULL;
                            $jam_in = date("H:i:s", $iter->in);
                            $jam_out=NULL;                            
                           
                        } else {
                            $in = date("Y-m-d H:i:s", $iter->in);
                            $out = date("Y-m-d H:i:s", $iter->out);
                            $jam_in = date("H:i:s", $iter->in);
                            $jam_out = date("H:i:s", $iter->out);                            
                        }
                      
                        array_push ($integrated_log, [
                            'id_employee'=>$myEmp['id_employee'],
                            'reg_number'=>$myEmp['reg_number'],
                            'date_att'=>$listday,
                            'punch_in'=>$in, 
                            'punch_out'=>$out,
                            'emp_name'=>$myEmp['emp_name'],
                        ]);
                    }                     
                } 
                //end of loop date range
            }

            /* MENYIMPAN DATA DARI ARRAY LOG YANG DIPEROLEH KE DATABASE */  
            
            $lastId=0;
            //$lastId = \app\models\Absensi::getLastId();
            foreach ($integrated_log as $iLog){                        
                
                $absen = Attendance::find()->where(['id_employee'=>$iLog['id_employee'], 'date'=>$iLog['date_att']]);
                if ($absen->exists()){
                    $updateAbsen = Attendance::findOne(['id_employee'=>$iLog['id_employee'], 'date'=>$iLog['date_att']]);
                    $updateAbsen->logout = $iLog['punch_out'] ? date("Y-m-d H:i:s", strtotime($iLog['punch_out'])) : NULL;
                    $updateAbsen->login = $iLog['punch_in'] ? date("Y-m-d H:i:s", strtotime($iLog['punch_in'])) : NULL;               
                    $updateAbsen->save();
                }else {
                    $insertUbsen = New Attendance();
                    $insertUbsen->id = $insertUbsen->getLastId();
                    $insertUbsen->id_employee = $iLog['id_employee'];
                    $insertUbsen->date = $iLog['date_att'];
                    $insertUbsen->login  = $iLog['punch_in']  ? date("Y-m-d H:i:s", strtotime($iLog['punch_in']))  : NULL;
                    $insertUbsen->logout = $iLog['punch_out'] ? date("Y-m-d H:i:s", strtotime($iLog['punch_out'])) : NULL;
                    $insertUbsen->hour_in = date("H:i:s",strtotime($iLog['punch_in'])) ?? NULL;
                    $insertUbsen->hour_out = date("H:i:s", strtotime($iLog['punch_out'])) ?? NULL;
                    $insertUbsen->save();
                }
            }
            /* END MENYIMPAN DATA KE DATABASE*/
            
            

            return $this->render('integration',[
                'model'=>$model,
                'tgl'=>$tgl,
                'absensi'=>$mylog,
                'emp_array'=>$emp_array,
                'integrated_log'=>$integrated_log,
            ]);
            
        }

        return $this->render('integration',[
            'model'=>$model,
            //'integrated_log'=>$integrated_log,
            //'emp_aray'=>$emp_array,
        ]);
    }

    /**
     * Finds the Attmachine model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Attmachine the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Attmachine::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
