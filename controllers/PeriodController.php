<?php

namespace app\controllers;

use app\components\hkm\DateRange;
use app\components\hkm\IntegrasiClass;
use app\components\hkm\IntegrateAttendance;
use app\components\hkm\LogIntegration;
use app\components\hkm\payroll\GajiPokok;

use app\models\Attendance;
use app\models\Cardlog;
//use app\models\DownloadMachineForm;
use app\models\Employee;
use app\models\Log;
use app\models\ModelFormPayroll;
use app\models\PayrollGroup;
use app\models\PayrollGroupEmployee;
use Yii;
use app\models\Period;
use app\models\PeriodSearch;
use app\models\TimeshiftDetil;
use app\models\TimeshiftEmployee;
use app\models\TimeshiftOption;
use yii\data\ArrayDataProvider;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;



/**
 * PeriodController implements the CRUD actions for Period model.
 */
class PeriodController extends Controller
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
     * Lists all Period models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PeriodSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Period model.
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
     * Creates a new Period model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Period();
        $model->id = $model->getLastId();
        $model->period_name = $model->end_date;
        if ($model->load(Yii::$app->request->post())){
            $model->period_name = $model->end_date;
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Period model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->period_name = $model->end_date;
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionSchedule($id){
        $period = Period::findOne($id);
        $timeshiftOption = TimeshiftOption::find()->all();
        $date_range = DateRange::getListDay($period->start_date, $period->end_date);
        $dt_schedule = [];
        foreach ($timeshiftOption as $to){

            foreach ($date_range as $date_now){
                $date_nows = date_create($date_now);
                $num_day =  date_format($date_nows, "N");
                $tdetil_1 = TimeshiftDetil::find()->where(['id_timeshift'=>$to->id_timeshift, 'num_day'=>$num_day]);
                if ($tdetil_1->exists()){
                    $tdetil = $tdetil_1->one();
                    /*if ($tdetil->is_dayoff == 7){
                        $d_off = 1;
                    } else {
                        $d_off = 0;
                    }*/


                    $timeshift_employee = TimeshiftEmployee::find()->where([
                        'id_period'=>$id,
                        'id_employee'=>$to->id_employee,
                        'date_shift'=>$date_now,
                    ]);
                    if ($timeshift_employee->exists()){
                        $Te = $timeshift_employee->one();
                        $Te->id_period = $id;
                        $Te->date_shift = $date_now;
                        $Te->id_employee = $to->id_employee;                    
                        $Te->start_hour = $tdetil->start_hour;
                        $Te->duration_hour = $tdetil->duration_hour;
                        $Te->is_dayoff = $tdetil->is_dayoff;
                        $Te->save();

                    }else {
                        //$tdetil = TimeshiftDetil::findOne(['id_timeshift'=>$to->id_timeshift, 'num_day'=>1]);
                       

                        $Te = New TimeshiftEmployee();
                        $Te->id = $Te->getLastId();
                        $Te->id_period = $id;
                        $Te->date_shift = $date_now;
                        $Te->id_employee = $to->id_employee;                    
                        $Te->start_hour = $tdetil->start_hour;
                        $Te->duration_hour = $tdetil->duration_hour;
                        $Te->is_dayoff = $tdetil->is_dayoff;
                        $Te->save();
                        
                        array_push($dt_schedule,[
                            //$Te->id = $Te->getLastId();
                            
                            'id_period' => $id,
                            'date_shift' => $date_now,
                            'num_day'=> date_format($date_nows, 'N'),
                            'id_employee' => $to->id_employee,                        
                            'start_hour' => $tdetil->start_hour,
                            'duration_hour' => $tdetil->duration_hour,
                            'is_dayoff' => $tdetil->is_dayoff,
                            
                        ]);
                    }


                }

            }
            
        }
        return $this->render('schedule', [
            'dt_schedule'=>$dt_schedule,
        ]);


    }

    public function actionTimeshiftemployee($id){
        $timeshift_employee = TimeshiftEmployee::find()->with('employee')
        //->where(['id_employee'=>48])
        ->orderBy(['id_employee'=>SORT_DESC, 'date_shift'=>SORT_ASC])->all();
        
        $provider = New ArrayDataProvider([
            'allModels'=>$timeshift_employee,
            'pagination'=>[
                'pageSize'=>5000,
            ]
        ]);

        return $this->render('timeshiftemployee',[
            'provider'=>$provider,
        ]);
    }

    /**
     * Deletes an existing Period model.
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

    public function actionIntegration($id){
        $period = $this->findModel($id);
        
        //$model = New DownloadMachineForm();

        //if ($model->load(Yii::$app->request->post())){
        //if (isset($period->start_date)){
            $absensi = Log::find()->where(['Between', 'date(timestamp)', $period->start_date, $period->end_date])->all();
            //$mylog = ArrayHelper::toArray($absensi);

            $myLog = [];
            foreach ($absensi as $log){
                array_push($myLog, [
                    'pin'=>$log->pin, 
                    'timestamp'=>$log->timestamp, 
                    'verification'=>$log->verification, 
                    'status'=>$log->status
                ]);
            }

            $list_day = Yii::$app->date_range->getListDay($period->start_date, $period->end_date);


            //VARIABLE 
            $emp_array=[];
            $integrated_log = [];
            //$cards = array();


            //Cari Employe yang aktif yang punya kartu absensi              
              
            foreach (Employee::find()->where(['is_active'=>True])->orderBy(['id'=>SORT_ASC])->all() as $emp) {
                //PIN dari masing2 employee bersifat uniq dan harus sama di semua mesin.
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
                //-----------------Matching data employee yg sudah punya kartu dg Log yang sudah diambil --------------------
                
                foreach ($list_day as $listday){ 
                    $shift = TimeshiftEmployee::find()->where([
                        'id_employee'=>$myEmp['id_employee'],
                        'date_shift'=>$listday,
                        'id_period'=>$id,
                    ])->one();
                    //echo "-----------------------------------------------------------------------------------------<br>";
                    //$iter = New LogIntegration($myLog, $myEmp['id_employee'], $myEmp['cards'], $listday);
                    $iter = New IntegrateAttendance($myLog, $myEmp['id_employee'], $myEmp['cards'], $listday, $shift->start_hour);
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
                            'start_hour'=>$shift->start_hour,
                            'duration'=>$shift->duration_hour,

                        ]);
                    }                     
                } 
                //end of loop date range
            }

            $providerIntegrated = New ArrayDataProvider([
                'allModels'=>$integrated_log,
            ]);

            /* MENYIMPAN DATA DARI ARRAY LOG YANG DIPEROLEH KE DATABASE */  
            
            //$lastId=0;
            //$lastId = \app\models\Absensi::getLastId();
            
            foreach ($integrated_log as $iLog){                        
                
                $absen = Attendance::find()->where(['id_employee'=>$iLog['id_employee'], 'date'=>$iLog['date_att']]);
                if ($absen->exists()){
                    $updateAbsen = Attendance::findOne(['id_employee'=>$iLog['id_employee'], 'date'=>$iLog['date_att']]);
                    $updateAbsen->logout = $iLog['punch_out'] ? date("Y-m-d H:i:s", strtotime($iLog['punch_out'])) : NULL;
                    $updateAbsen->login = $iLog['punch_in'] ? date("Y-m-d H:i:s", strtotime($iLog['punch_in'])) : NULL;  
                    $updateAbsen->hour_in = $iLog['punch_in'] ? date("H:i:s", strtotime($iLog['punch_in'])) : NULL;
                    $updateAbsen->hour_out = $iLog['punch_out'] ? date("H:i:s", strtotime($iLog['punch_out'])) : NULL;             
                    $updateAbsen->save();
                }else {
                    $insertAbsen = New Attendance();
                    $insertAbsen->id = $insertAbsen->getLastId();
                    $insertAbsen->id_employee = $iLog['id_employee'];
                    $insertAbsen->date = $iLog['date_att'];
                    $insertAbsen->login  = $iLog['punch_in']  ? date("Y-m-d H:i:s", strtotime($iLog['punch_in']))  : NULL;
                    $insertAbsen->logout = $iLog['punch_out'] ? date("Y-m-d H:i:s", strtotime($iLog['punch_out'])) : NULL;
                    $insertAbsen->hour_in = $iLog['punch_in'] ? date("H:i:s", strtotime($iLog['punch_in'])) : NULL;
                    $insertAbsen->hour_out = $iLog['punch_out'] ? date("H:i:s", strtotime($iLog['punch_out'])) : NULL;
                    $insertAbsen->save();
                }
            }
            
            /* END MENYIMPAN DATA KE DATABASE*/
            
            
            
            $providerEmp = New ArrayDataProvider([
                'allModels'=>$emp_array,
            ]);
            return $this->render('integration',[
                //'model'=>$model,
                //'tgl'=>$tgl,
                'absensi'=>$myLog,
                'emp_array'=>$emp_array,
                'integrated_log'=>$integrated_log,
                'providerIntegrated'=>$providerIntegrated,
                'providerEmp'=>$providerEmp,

            ]);
            
        //}

        return $this->render('integration',[
            'period'=> $period,
            //'integrated_log'=>$integrated_log,
            //'emp_aray'=>$emp_array,
        ]);
    }

    public function actionPilihgroup($id){
        $period = $this->findModel($id);
        $group = PayrollGroup::find()->all();
        $group_list = ArrayHelper::map($group, 'id', 'name');
        
        $model = New ModelFormPayroll();
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()){
            //Select Employee dalam group 
            $payroll_group = PayrollGroup::findOne($model->id_payroll_group);
            $payroll_group_employee = PayrollGroupEmployee::find()->where(['id_payroll_group'=>$model->id_payroll_group])->all(); 
            
            $shift_arr = [];
            $dt_arr = [];
            foreach ($payroll_group_employee as $employees){
                //P003/
                $employee = Employee::findOne($employees->id_employee);
                
                /*
                - looping tanggal 
                */
                
                $datePeriod = DateRange::getListDay($period->start_date, $period->end_date);
                foreach ($datePeriod as $date_now){

                    
                    /*
                    //tanggal 2020-08-08

                    - cari shift P003 tanggal 2020-08-08 
                    */
                    $shift = TimeshiftEmployee::find()->where(['date_shift'=>$date_now, 'id_employee'=>$employee->id, 'id_period'=>$period->id])->one();
                    $office_in = $shift->start_hour;
                    $is_dayoff = $shift->is_dayoff;
                    $office_ev = $shift->duration_hour;
                    //array_push($shift_arr, $shift->start_hour);
                    
                    $att = Attendance::find()->where(['id_employee'=>$employee->id, 'date'=>$date_now]);
                    if ($att->exists()){
                        $ket = "on";
                        $atts = $att->one();
                        if (empty($atts->login)){
                            $emp_in = Null;
        
                        }else {
                            $emp_in = $atts->login;
        
                        }
                        if (empty($atts->logout)){
                            $emp_out = Null;
        
                        }else {
                            $emp_out = $atts->logout;
                            
                        }
                        
                        
                    }else {
                        $emp_in = Null;
                        $emp_out = Null;
                        $ket = "off";
                        
                    }

                    $gaji = New GajiPokok($employee->basic_salary,$emp_in, $emp_out, $office_in, $is_dayoff, $office_ev, $date_now, $ket);

                    array_push($dt_arr, [
                        'id'=>$employee->id,
                        'name'=>$employee->coreperson->name,
                        'basic'=>$gaji->basic_day,
                        'person_in'=>$emp_in,
                        'person_out'=>$emp_out,
                        //'early_in'=>$gaji->earlyIn(),
                        //'lateOut'=>$gaji->lateOut(),
                        'office_in'=>$shift->start_hour,
                        'office_start'=>$gaji->getOfficeStart(),
                        'office_stop'=>$gaji->getOfficeStop(),
                        'o_ev'=>$shift->duration_hour,
                        'p_ev'=>$gaji->getDurationEvectifeHour(),
                        'ot'=>$gaji->getOvertime(),
                        'sal_ot'=>$gaji->getSalaryOverTime(),
                        'basic_salary'=>Yii::$app->formatter->asCurrency($gaji->getSalaryBasic(),'Rp.'),
                        'date_now'=>$date_now,
                        'is_doff'=>$shift->is_dayoff,
                        'ket'=>$ket,
                    ]);
                
                
                
                    /*
                    - jam masuk = ? durasi = istirahat = 1
                    -//Payroll
                    - hitung gaji pokok 
                    - hitung overtime jika ada
                    - hitung tunjangan masa kerja 
                    - hitung insentif Jika ada 
                    - hitung 



                */
                }  
            }
            $providerTest = New ArrayDataProvider([
                'allModels'=>$dt_arr,
            ]);
             
            return $this->render('_form_pilih_group',[
                'model'=>$model,
                'group_list'=>$group_list,
                'period'=>$period,
                'payroll_group'=>$payroll_group,
                'payroll_group_employee'=>$payroll_group_employee,
                'date_now'=>$datePeriod,
                //'shift'=>$shift_arr,
                'dt_arr'=>$dt_arr,
                'providerTest'=>$providerTest,
    
            ]);
        }
        

        return $this->render('_form_pilih_group',[
            'model'=>$model,
            'group_list'=>$group_list,
            'period'=>$period,
            //'group'=>$payroll_group,
            //'group_employee'=>$payroll_group_employee

        ]);
    }

    /**
     * Finds the Period model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Period the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Period::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
