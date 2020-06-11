<?php

namespace app\controllers;

use app\components\hkm\HkmLib;
use app\components\hkm\LogIntegration;
use app\models\Absensi;
use app\models\DownloadMachineForm;
use app\models\HsHrEmpAbsensi;
use Yii;
use app\models\MachineAtt;
use app\models\MachineAttSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use app\models\Employee;
use app\models\Kartu;

/**
 * MachineattController implements the CRUD actions for MachineAtt model.
 */
class MachineattController extends Controller
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
     * Lists all MachineAtt models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MachineAttSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MachineAtt model.
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
     * Creates a new MachineAtt model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MachineAtt();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MachineAtt model.
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
     * Deletes an existing MachineAtt model.
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
     * Finds the MachineAtt model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MachineAtt the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MachineAtt::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionDownload($id)
    {
        $machine = $this->findModel($id);  
        //$machine = Machineattendance::findOne($id);
        
        //$ip = '192.168.4.138';
        $ip = $machine->ip;

        //$port='80';
        $port= $machine->port;		
        //$com=0;
        $com = $machine->com;

        try {
                //$log_data = Yii::$app->hkmlib->download($ip, $port, $com);
                $x = New HkmLib();
                $log_data = $x->download($ip, $port, $com);


                
        } catch (Exception $e){
                echo $e->getMessage();
        } 
        
        //var_dump($log_data);
        
        $lastlog = HsHrEmpAbsensi::find()->where(['id_machine'=>$id])->max('timestamp');
        
        $array_log=array();
        $first_id = HsHrEmpAbsensi::getLastId();
        //Populate $log_data To Array $array_log with id_log Auto Increment
        foreach ($log_data['Row'] as $value){  
            if (strtotime($value['DateTime']) > strtotime($lastlog)){
                array_push($array_log,[                   
                    'id'=>$value['PIN'],
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
        'hs_hr_emp_absensi', 
        [
            'id',
            'timestamp', 
            'verifikasi',
            'status',            
            'id_machine'
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
            'x'=>$log_data,
            'array_log'=>$array_log,
            'lastlog'=>$lastlog,
        ]);
       
         	
    }

    public function actionIntegrasi(){
        $model = New DownloadMachineForm();

        if ($model->load(Yii::$app->request->post())){
            $tgl = $model->start_date." s/d ".$model->end_date;
            $absensi = HsHrEmpAbsensi::find()->where(['Between', 'date(timestamp)', $model->start_date, $model->end_date])->all();
            $mylog = ArrayHelper::toArray($absensi);

            $myLog = [];
            foreach ($absensi as $log){
                array_push($myLog, [
                    'id'=>$log->id, 
                    'timestamp'=>$log->timestamp, 
                    'verifikasi'=>$log->verifikasi, 
                    'status'=>$log->status
                ]);
            }

            $list_day = Yii::$app->date_range->getListDay($model->start_date, $model->end_date);


            //VARIABLE 
            $emp_array=[];
            $integrated_log = [];
            $cards = array();


            //Cari Employe yang punya kartu absensi  
            
              
            foreach (Employee::find()->all() as $emp) {
            //foreach (Employee::find()->where(['id'=>161])->all() as $emp) {
            // $customer is a attcard object with the 'employee' relation populated
                $_card = Kartu::find()->select(['no_kartu', 'emp_number_kartu'])->where(['emp_number_kartu'=>$emp->emp_id])->all();
                array_push($emp_array, [                    
                    'reg_number'=>$emp->emp_id,
                    'id_employee'=>$emp->emp_id,
                    'emp_name'=>$emp->emp_name,
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
                            //'id_employee'=>$myEmp['id_employee'],
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
                /*Yii::$app->db->createCommand()                
                ->upsert('absensi', [                        
                        'emp_id'=>$iLog['reg_number'],
                        'tgl'=>$iLog['date_att'],
                        'jam_in'=>$iLog['punch_in'],                        
                        'jam_out'=>$iLog['punch_out'],
                    ], [
                        //'id'=>$lastId,
                        'emp_id'=>$iLog['reg_number'],
                        'tgl'=>$iLog['date_att'],
                        'jam_in'=>$iLog['punch_in'],
                        'jam_out'=>$iLog['punch_out'],
                    ])->execute();
                       
                $lastId++;
                */
                $absen = Absensi::find()->where(['emp_id'=>$iLog['reg_number'], 'tgl'=>$iLog['date_att']]);
                if ($absen->exists()){
                    $updateAbsen = Absensi::findOne(['emp_id'=>$iLog['reg_number'], 'tgl'=>$iLog['date_att']]);
                    $updateAbsen->jam_in = date("H:i:s", strtotime($iLog['punch_in']));
                    $updateAbsen->jam_in = date("H:i:s", strtotime($iLog['punch_out']));
                    $updateAbsen->save();
                }else {
                    $insertUbsen = New Absensi();
                    $insertUbsen->emp_id = $iLog['reg_number'];
                    $insertUbsen->tgl = $iLog['date_att'];
                    $insertUbsen->jam_in = date("H:i:s",strtotime($iLog['punch_in']));
                    $insertUbsen->jam_out = date("H:i:s", strtotime($iLog['punch_out']));
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
        ]);
    }
}
