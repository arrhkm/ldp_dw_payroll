<?php

namespace app\controllers;

use Yii;
use app\components\fpdf\fpdf;
use app\components\hkm\DateRange;

use app\components\hkm\IntegrateAttendance;

use app\components\hkm\NameDay;
use app\components\hkm\payroll\CppKasbon;
use app\components\hkm\payroll\CppOvertime;
use app\components\hkm\payroll\GajiHarian;
use app\components\hkm\payroll\GajiPokok;
use app\components\hkm\payroll\InsentifEmployee;
use app\components\hkm\payroll\MasaKerja;
use app\models\Attendance;
use app\models\Cardlog;
use app\models\ComponentGroup;
use app\models\DailyComponentDetil;
use app\models\Dayoff;

use app\models\Employee;
use app\models\InsentifMaster;
use app\models\Kasbon;
use app\models\Log;
use app\models\ModelFormPayroll;
use app\models\Payroll;
use app\models\PayrollDay;
use app\models\PayrollGroup;
use app\models\PayrollGroupEmployee;
use app\models\PayrollSearch;

use app\models\Period;
use app\models\PeriodSearch;
use app\models\TimeshiftDetil;
use app\models\TimeshiftEmployee;
use app\models\TimeshiftEmployeeSearch;
use app\models\TimeshiftOption;
use app\components\hkm\payroll\CetakPayroll;
use DateTime;

use yii\data\ArrayDataProvider;

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
        $payroll_group = [];
        foreach (PayrollGroup::find()->all() as $groups){
            array_push($payroll_group,[
                'id_period'=>$id,
                'id'=>$groups->id,
                'name'=>$groups->name,
            ]);
        }
        $groupProvider = New ArrayDataProvider([
            'allModels'=>$payroll_group,
        ]);
        
        return $this->render('view', [
            'model' => $this->findModel($id),
            'groupProvider'=>$groupProvider,
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

    public function actionRemovetimeshift($id){
        //$this->findModel($id)->delete();
        TimeshiftEmployee::deleteAll(['id_period'=>$id]);

        return $this->redirect(['index']);
    }

    public function actionTimeshiftemployee($id){

        $searchTimeshiftEmployee = NEW TimeshiftEmployeeSearch();
        $dataProviderTimeshiftEmployee = $searchTimeshiftEmployee->searchByPeriod(Yii::$app->request->queryParams,$id);

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
            'provider'=>$dataProviderTimeshiftEmployee, //$provider,
            'searchModelTimeshiftEmployee'=>$searchTimeshiftEmployee,
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
        TimeshiftEmployee::deleteAll(['id_period'=>$id]);

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
                    /*$shift = TimeshiftEmployee::find()->where([
                        'id_employee'=>$myEmp['id_employee'],
                        'date_shift'=>$listday,
                        'id_period'=>$id,
                    ])->one();*/
                    
                    $shift = TimeshiftEmployee::find()->where(['id_employee'=>$myEmp['id_employee'], 'id_period'=>$id, 'date_shift'=>$listday]);
                    //echo "-----------------------------------------------------------------------------------------<br>";
                    if ($shift->exists()){
                        $shift = $shift->one();
                        //$iter = New LogIntegration($myLog, $myEmp['id_employee'], $myEmp['cards'], $listday);
                        $iter = New IntegrateAttendance($myLog, $myEmp['id_employee'], $myEmp['cards'], $listday, '08:00:00');
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
        
        //looping date period 
        $datePeriod = DateRange::getListDay($period->start_date, $period->end_date);
        
        if ($model->load(Yii::$app->request->post()) && $model->validate() && !empty($period)){
            //Select Employee dalam group 
            $payroll_group = PayrollGroup::findOne($model->id_payroll_group);
            $payroll_group_employee = PayrollGroupEmployee::find()->where(['id_payroll_group'=>$model->id_payroll_group])->all(); 
            
           
            
            $dt_arr_employee_payroll=[];
            foreach ($payroll_group_employee as $employees){

                //Looping employee
                $employee = Employee::findOne($employees->id_employee);

                //potongan covid 50%;
                $covid50 = ComponentGroup::find()->where(['id_employee'=>$employee->id, 'id_component_payroll'=>1]);

                //Masakerja Employee
                $start_kerja = New DateTime($employee->date_of_hired);
                $today = date("y-m-d");
                $obj_today = New DateTime($today);
                $diff_mskerja = $start_kerja->diff($obj_today);
                $masakerja = $diff_mskerja->format('%Y');
                $hasil_masakerja = MasaKerja::getMasakerja($employee->date_of_hired);
                
               //Kasbon
                $EmpKasbon = New CppKasbon($employee->id, $period->id);
                $kasbon = $EmpKasbon->getKasbon();
                $kasbon_total_cicilan = $EmpKasbon->getTotalCicilan();



               //end kasbon -------
                /*
                - looping tanggal 
                */
                $dt_arr = [];
                //$datePeriod = DateRange::getListDay($period->start_date, $period->end_date);

                //Insentif all 
                $insentif_master = InsentifEmployee::getKet($employee->id, $period->start_date, $period->end_date);

                $total_gaji=0;
                $wt=0;
                $pt=0;
                $emp_in = '00:00:00';
                $emp_out = '00:00:00';
                $ket = '';

                foreach ($datePeriod as $date_now){

                     //Insentif
                    
                    $ins = InsentifEmployee::getInsentif($employee->id, $date_now);

                    //$obj_datenow = date_create($date_now);
                    $num_day = NameDay::getName($date_now);//$obj_datenow->format('N');
                    $shift = TimeshiftEmployee::find()->where(['date_shift'=>$date_now, 'id_employee'=>$employee->id, 'id_period'=>$period->id])->one();
                    
                    $office_in = $shift->start_hour;
                    $is_dayoff = $shift->is_dayoff;
                    $office_ev = $shift->duration_hour;

                    //--Dayoff------
                    $LiburNasional = Dayoff::find()->where(['date_dayoff'=>$date_now]);


                    //array_push($shift_arr, $shift->start_hour);                   
                    $att = Attendance::find()->where(['id_employee'=>$employee->id, 'date'=>$date_now]);
                    
                    //dayOffCovid2
                    $covid2 = DailyComponentDetil::find()->where(['id_employee'=>$employee->id, 'id_daily_component'=>1, 'date_component'=>$date_now]);
                    
                    if ($LiburNasional->exists()){
                        $libur_nasional = TRUE;
                    }else {
                        $libur_nasional = FALSE;
                    }
                    
                   
                    if ($att->exists()){ //Jika ada absensis nya 
                        
                        $atts = $att->one();
                        if (empty($atts->login) || empty($atts->logout)){
                            
                            if (empty($atts->login) && !empty($atts->logout)){         
                                $emp_in = NULL;
                                $emp_out = $atts->logout;
                                if ($is_dayoff){
                                    $ket = "off";
                                }elseif($libur_nasional){
                                    $ket = "off_all";
                                }else{
                                    $ket = "alpha";
                                }
                            }
                            elseif (!empty($atts->login) && empty($atts->logout)){
                                $emp_in = $atts->login;
                                $emp_out = NULL;
                                if ($is_dayoff){
                                    $ket = "off";
                                }elseif($libur_nasional){
                                    $ket = "off_all";
                                }else{
                                    $ket = "alpha";
                                }
                            }
                            else //(empty($atts->login) && empty($atts->logout)){
                            {
                                
                                $emp_in = NULL;
                                $emp_out = NULL;
                                if ($is_dayoff){
                                    $ket = "off";
                                }elseif($libur_nasional){
                                    $ket = "off_all";
                                }else {
                                    $ket = "alpha";
                                }
                                
                            }
                        }                           
                        else { 
                            $emp_in = $atts->login;
                            $emp_out = $atts->logout;
                            
                            if ($is_dayoff){
                                $ket = "off";
                            }elseif($libur_nasional){
                                $ket = "off_all";
                            }else {
                                $ket = "on";
                            }
                            
                        }
                    }else{
                        $emp_in = NULL;
                        $emp_out = NULL;

                        if ($is_dayoff){
                            $ket = "off";
                        }elseif($libur_nasional){
                            $ket = "off_all";
                        }elseif ($covid2->exists()){
                            $ket = "covid2";
                        }
                        else {
                            $ket = "alpha";
                        }
                       
                    }
                    
                    //Overtime Approve
                    $ComponentOvertime = New CppOvertime($employee->id, $date_now);
                    $overtime_approve = $ComponentOvertime->getSpklOfficeDuration();
                    //end Overtime approve

                    $gaji = New GajiPokok($employee->id, $employee->basic_salary,$emp_in, $emp_out, 
                        $office_in, $is_dayoff, $office_ev, $date_now, $ket, $employee->date_of_hired, $ins, $overtime_approve, $libur_nasional);
                    
                    array_push($dt_arr, [
                        'id'=>$employee->id,
                        'name'=>$employee->coreperson->name,
                        'reg_number'=>$employee->reg_number,
                        'date_now'=>$date_now,
                        'name_day'=>$num_day,
                        'basic'=>$gaji->basic_day,
                        'person_in'=>$emp_in,
                        'person_out'=>$emp_out,
                        //'early_in'=>$gaji->earlyIn(),
                        //'lateOut'=>$gaji->lateOut(),
                        //'office_in'=>$shift->start_hour,
                        'office_start'=>$gaji->getOfficeStart(),
                        'office_stop'=>$gaji->getOfficeStop(),
                        'o_ev'=>$shift->duration_hour,
                        'p_ev'=>$gaji->getDurationEvectifeHour(),
                        'ot'=>$gaji->getOvertime(),
                        'sal_ot'=>$gaji->getSalaryOverTime(),
                        'basic_salary'=>$gaji->getSalaryBasic(),
                        
                        'is_doff'=>$gaji->is_dayoff,//$shift->is_dayoff,
                        'ket'=>$gaji->ket,//$ket,
                        'doh'=>$gaji->doh,//$employee->date_of_hired,
                        'mskerja'=>$masakerja,
                        't_masakerja'=> $gaji->getTmasakerja(),
                        'telat'=>$gaji->getTelat(),
                        'pot_telat'=>$gaji->getPotonganTelat(),
                        'ins'=>$gaji->getInsentif(),
                        'salary_day'=>$gaji->getSalaryDay(),
                        
                    ]);
                    $total_gaji = $total_gaji + $gaji->getSalaryDay();
                    $wt +=  $gaji->getDurationEvectifeHour();
                    $pt += $gaji->getDurationEvectifeHour()+$gaji->getOvertime();
                }
                $grand_total_gaji = $total_gaji -($EmpKasbon->getPotonanKasbon());
                array_push($dt_arr_employee_payroll,[
                    'reg_number'=>$employee->reg_number,
                    'employee_name'=>$employee->name,
                    'doh'=>$employee->date_of_hired,
                    'basic'=>$employee->basic_salary,
                    'ins_master'=>$insentif_master,
                    'total_gaji'=>$total_gaji,
                    'wt'=>$wt,
                    'pt'=>$pt,
                    'kasbon'=>$kasbon,
                    'kasbon_total_cicilan'=>$kasbon_total_cicilan,
                    'kasbon_kurang_bayar'=>$EmpKasbon->getSisaKasbon(),
                    'kasbon_potongan'=>$EmpKasbon->getPotonanKasbon(),
                    'grand_total_gaji'=>$grand_total_gaji,
                    'is_covid'=>$covid50->exists(),
                    'detil'=>$dt_arr,
                    

                ]);  
            }
            
            /*$providerTest = New ArrayDataProvider([
                'allModels'=>$dt_arr,
            ]);*/

            
             
            return $this->render('_form_pilih_group',[
                'model'=>$model,
                'group_list'=>$group_list,
                'period'=>$period,
                'payroll_group'=>$payroll_group,
                'payroll_group_employee'=>$payroll_group_employee,
                'date_now'=>$datePeriod,
                //'shift'=>$shift_arr,
                //'dt_arr'=>$dt_arr,
                //'providerTest'=>$providerTest,
                'dt_arr_payroll'=>$dt_arr_employee_payroll
    
            ]);
        }
        

        return $this->render('_form_pilih_group',[
            'model'=>$model,
            'group_list'=>$group_list,
            'period'=>$period,
         

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

    public function actionPosting($id_period, $id_payroll_group){
        $period = $this->findModel($id_period);
        $period->is_archive = TRUE;
        $period->save();
        $payroll_group = PayrollGroup::findOne($id_payroll_group);
        $payroll_group_employee = PayrollGroupEmployee::find()->where(['id_payroll_group'=>$id_payroll_group])->all();
        
        //looping date period 
        $datePeriod = DateRange::getListDay($period->start_date, $period->end_date);
        //---------------------------------------------------------
        $dt_arr_employee_payroll=[];
        foreach ($payroll_group_employee as $employees){

            //Looping employee
            $employee = Employee::findOne($employees->id_employee);

            //Masakerja Employee
            $start_kerja = New DateTime($employee->date_of_hired);
            $today = date("y-m-d");
            $obj_today = New DateTime($today);
            $diff_mskerja = $start_kerja->diff($obj_today);
            $masakerja = $diff_mskerja->format('%Y');
            //$hasil_masakerja = MasaKerja::getMasakerja($employee->date_of_hired);
            
            //Kasbon
            $EmpKasbon = New CppKasbon($employee->id, $period->id);
            $kasbon = $EmpKasbon->getKasbon();
            $kasbon_total_cicilan = $EmpKasbon->getTotalCicilan();



            //end kasbon -------
            
            $dt_arr = [];
            

            //Insentif all 
            $insentif_master = InsentifEmployee::getKet($employee->id, $period->start_date, $period->end_date);

            $total_gaji=0;
            $wt=0;
            $pt=0;
            $emp_in = '00:00:00';
            $emp_out = '00:00:00';
            $ket = '';

            foreach ($datePeriod as $date_now){

                //Insentif                
                $ins = InsentifEmployee::getInsentif($employee->id, $date_now);

                //$obj_datenow = date_create($date_now);
                $num_day = NameDay::getName($date_now);//$obj_datenow->format('N');
                $shift = TimeshiftEmployee::find()->where(['date_shift'=>$date_now, 'id_employee'=>$employee->id, 'id_period'=>$period->id])->one();
                
                $office_in = $shift->start_hour;
                $is_dayoff = $shift->is_dayoff;
                $office_ev = $shift->duration_hour;
                
                
                //--Dayoff------
                $LiburNasional = Dayoff::find()->where(['date_dayoff'=>$date_now]);
                
                $att = Attendance::find()->where(['id_employee'=>$employee->id, 'date'=>$date_now]);
                /*if ($att->exists()){
                    $ket = "on";
                    $atts = $att->one();
                    if (empty($atts->login) || empty($atts->logout)){
                        $ket = "off";
                    }elseif (empty($atts->login)){
                        $emp_in = Null;
                        $ket = "off";
    
                    }else {
                        $emp_in = $atts->login;
    
                    }
                    if (empty($atts->logout)){
                        $emp_out = Null;
                        $ket = "off";
    
                    }else {
                        $emp_out = $atts->logout;
                        
                    }
                    
                    
                }else {
                    if ($is_dayoff){
                        $emp_in = Null;
                        $emp_out = Null;
                        $ket = "off";
                    }else{
                        $emp_in = Null;
                        $emp_out = Null;
                        $ket = "alpha";
                    }
                    
                }*/
                if ($LiburNasional->exists()){
                    $libur_nasional = TRUE;
                }else {
                    $libur_nasional = FALSE;
                }
                
               
                if ($att->exists()){ //Jika ada absensis nya 
                    
                    $atts = $att->one();
                    if (empty($atts->login) || empty($atts->logout)){
                        
                        if (empty($atts->login) && !empty($atts->logout)){         
                            $emp_in = NULL;
                            $emp_out = $atts->logout;
                            if ($is_dayoff){
                                $ket = "off";
                            }elseif($libur_nasional){
                                $ket = "off_all";
                            }else{
                                $ket = "alpha";
                            }
                        }
                        elseif (!empty($atts->login) && empty($atts->logout)){
                            $emp_in = $atts->login;
                            $emp_out = NULL;
                            if ($is_dayoff){
                                $ket = "off";
                            }elseif($libur_nasional){
                                $ket = "off_all";
                            }else{
                                $ket = "alpha";
                            }
                        }
                        else //(empty($atts->login) && empty($atts->logout)){
                        {                            
                            $emp_in = NULL;
                            $emp_out = NULL;
                            if ($is_dayoff){
                                $ket = "off";
                            }elseif($libur_nasional){
                                $ket = "off_all";
                            }else {
                                $ket = "alpha";
                            }                            
                        }
                    }                           
                    else { 
                        $emp_in = $atts->login;
                        $emp_out = $atts->logout;
                        
                        if ($is_dayoff){
                            $ket = "off";
                        }elseif($libur_nasional){
                            $ket = "off_all";
                        }else {
                            $ket = "on";
                        }                        
                    }
                }else{
                    $emp_in = NULL;
                    $emp_out = NULL;

                    if ($is_dayoff){
                        $ket = "off";
                    }elseif($libur_nasional){
                        $ket = "off_all";
                    }else {
                        $ket = "alpha";
                    }                   
                }
                //Overtime Approve
                $ComponentOvertime = New CppOvertime($employee->id, $date_now);
                $overtime_approve = $ComponentOvertime->getSpklOfficeDuration();
                //end Overtime approve

                $gaji = New GajiPokok($employee->id, $employee->basic_salary,$emp_in, $emp_out, 
                    $office_in, $is_dayoff, $office_ev, $date_now, $ket, $employee->date_of_hired, $ins, $overtime_approve,
                    $libur_nasional);
                
                array_push($dt_arr, [
                    'id'=>$employee->id,
                    'id_period'=>$period->id,
                    'id_payroll_group'=>$id_payroll_group,
                    'name'=>$employee->coreperson->name,
                    'reg_number'=>$employee->reg_number,
                    'date_now'=>$date_now,
                    'name_day'=>$num_day,
                    'basic'=>$gaji->basic_day,
                    'person_in'=>$emp_in,
                    'person_out'=>$emp_out,
                    
                    'office_start'=>$gaji->getOfficeStart(),
                    'office_stop'=>$gaji->getOfficeStop(),
                    'o_ev'=>$shift->duration_hour,
                    'p_ev'=>$gaji->getDurationEvectifeHour(),
                    'ot'=>$gaji->getOvertime(),
                    'sal_ot'=>$gaji->getSalaryOverTime(),
                    'basic_salary'=>$gaji->getSalaryBasic(),
                    
                    'is_doff'=>$gaji->is_dayoff,//$shift->is_dayoff,
                    'ket'=>$gaji->ket,//$ket,
                    'doh'=>$gaji->doh,//$employee->date_of_hired,
                    'mskerja'=>$masakerja,
                    't_masakerja'=> $gaji->getTmasakerja(),
                    'telat'=>$gaji->getTelat(),
                    'pot_telat'=>$gaji->getPotonganTelat(),
                    'ins'=>$gaji->getInsentif(),
                    'salary_day'=>$gaji->getSalaryDay(),
                    
                ]);
                $total_gaji = $total_gaji + $gaji->getSalaryDay();
                $wt +=  $gaji->getDurationEvectifeHour();
                $pt += $gaji->getDurationEvectifeHour()+$gaji->getOvertime();
            }
            $grand_total_gaji = $total_gaji -($EmpKasbon->getPotonanKasbon());
            array_push($dt_arr_employee_payroll,[
                'id_employee'=>$employee->id,
                'id_period'=>$id_period,
                'id_payroll_group'=>$id_payroll_group,
                'payroll_name'=>"{$payroll_group->name} {$period->end_date}",
                'reg_number'=>$employee->reg_number,
                'employee_name'=>$employee->name,
                'basic'=>$employee->basic_salary,
                'doh'=>$employee->date_of_hired,
                'basic'=>$employee->basic_salary,
                'ins_master'=>$insentif_master,
                'total_gaji'=>$total_gaji,
                'wt'=>$wt,
                'pt'=>$pt,
                'kasbon'=>$kasbon,
                'kasbon_total_cicilan'=>$EmpKasbon->getTotalCicilan(),
                'kasbon_kurang_bayar'=>$EmpKasbon->getSisaKasbon(),
                'kasbon_potongan'=>$EmpKasbon->getPotonanKasbon(),
                'grand_total_salary'=>$grand_total_gaji,
                'no_rekening'=>$employee->coreperson->bank_account,
                'detil'=>$dt_arr,
                
                

            ]);  
        }
        foreach($dt_arr_employee_payroll as $pays){
            $modelPay = Payroll::find()->where(['id_employee'=>$pays['id_employee'], 'id_period'=>$id_period]);
            if ($modelPay->exists()){
                $modelPay = $modelPay->one();

                $modelPay->reg_number = $pays['reg_number'];
                $modelPay->employee_name = $pays['employee_name'];
                $modelPay->id_period = $pays['id_period'];
                $modelPay->id_payroll_group = $pays['id_payroll_group'];
                $modelPay->tg_all = $pays['total_gaji'];
                $modelPay->grand_total_salary = $pays['grand_total_salary'];
                $modelPay->wt = $pays['wt'];
                $modelPay->pt = $pays['pt'];
                $modelPay->pot_bpjs_kes = 0; 
                $modelPay->payroll_name = $pays['payroll_name'];
                $modelPay->cicilan_kasbon = $pays['kasbon_potongan'];
                $modelPay->dscription_kasbon = $pays['ins_master'];
                $modelPay->basic_salary = $pays['basic'];
                $modelPay->no_rekening = $pays['no_rekening'];
                $modelPay->save();

            }else{
                $modelPay = New Payroll;
                $modelPay->id = $modelPay->getLastId();
                $modelPay->id_employee = $pays['id_employee'];
                $modelPay->id_period = $pays['id_period'];
                $modelPay->id_payroll_group = $pays['id_payroll_group'];
                $modelPay->reg_number = $pays['reg_number'];
                $modelPay->employee_name = $pays['employee_name'];                
                $modelPay->tg_all = $pays['total_gaji'];
                $modelPay->grand_total_salary = $pays['grand_total_salary'];
                $modelPay->wt = $pays['wt'];
                $modelPay->pt = $pays['pt'];
                $modelPay->pot_bpjs_kes = 0; 
                $modelPay->payroll_name = $pays['payroll_name'];
                $modelPay->cicilan_kasbon = $pays['kasbon_potongan'];
                $modelPay->dscription_kasbon = $pays['ins_master'];
                $modelPay->basic_salary = $pays['basic'];
                $modelPay->no_rekening = $pays['no_rekening'];

                $modelPay->save();
            }

            foreach ($pays['detil'] as $detils){
                $modelDetil = PayrollDay::find()->where(['id_employee'=>$pays['id_employee'], 'id_period'=>$pays['id_period'], 'date_payroll'=>$detils['date_now']]);
                if ($modelDetil->exists()){
                    $detil = $modelDetil->one();
                    
                    $detil->date_payroll = $detils['date_now'];
                    $detil->basic_per_hour = $detils['basic'];
                    $detil->ev_hour = $detils['p_ev'];
                    $detil->ot_hour = $detils['ot'];
                    $detil->basic_salary = $detils['basic_salary'];
                    $detil->overtime_salary = $detils['sal_ot'];
                    $detil->t_masakerja = $detils['t_masakerja'];
                    $detil->insentif = $detils['ins'];
                    $detil->pot_telat = $detils['pot_telat'];
                    $detil->name_day = $detils['name_day'];
                    $detil->logika_day = $detils['ket'];
                    $detil->total_gaji = $detils['salary_day'];
                    
                    $detil->save();
                    
                }else {
                   
                    $detil = New PayrollDay();
                    $detil->id = $detil->getLastId();
                    $detil->id_employee= $detils['id'];
                    $detil->id_period= $detils['id_period'];
                    $detil->id_payroll_group = $pays['id_payroll_group'];
                    $detil->date_payroll = $detils['date_now'];
                    $detil->basic_per_hour = $detils['basic'];
                    $detil->ev_hour = $detils['p_ev'];
                    $detil->ot_hour = $detils['ot'];
                    $detil->basic_salary = $detils['basic_salary'];
                    $detil->overtime_salary = $detils['sal_ot'];
                    $detil->t_masakerja = $detils['t_masakerja'];
                    $detil->insentif = $detils['ins'];
                    $detil->pot_telat = $detils['pot_telat'];
                    $detil->name_day = $detils['name_day'];
                    $detil->logika_day = $detils['ket'];
                    $detil->total_gaji = $detils['salary_day'];
                    
                    $detil->save();
                }
            }
        }
        
        //------------------------end------------------------------
        
        return $this->render('posting',[
            'dt_arr_emp'=>$dt_arr_employee_payroll,

        ]);
    }

    public function actionArchivepayroll($id_period){
        $period = $this->findModel($id_period);
        $group = PayrollGroup::find()->all();
        $group_list = ArrayHelper::map($group, 'id', 'name');
        
        $model = New ModelFormPayroll();

        $PayrollPeriod = Payroll::find()->select(['id_period', 'id_payroll_group'])->distinct(['id_period', 'id_payroll_group'])
        ->where(['id_period'=>$period->id])->all();
        $provider = New ArrayDataProvider([
            'allModels'=>$PayrollPeriod,
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->validate() && !empty($period)){
            //Select Employee dalam group 
            $payroll_group = PayrollGroup::findOne($model->id_payroll_group);
            //$payroll_group_employee = PayrollGroupEmployee::find()->where(['id_payroll_group'=>$model->id_payroll_group])->all(); 
            $srcPayrollModel = New PayrollSearch();
            $dataprovider = $srcPayrollModel->searchByGroup(Yii::$app->request->queryParams, $payroll_group->id, $period->id);
            return $this->render('indexarchivepayroll',[
                'period'=>$period,
                'searchModel'=>$srcPayrollModel,
                'dataProvider'=>$dataprovider,
                //'PayrollGroup'=>$payroll_group,
                
            ]);

        }

        return $this->render('archivepayroll', [
            'model'=>$model,
            'group_list'=>$group_list,
            'provider'=>$provider,
        ]);

    }
    public function actionPayrollperiod($id_period, $id_payroll_group){
        $period = Period::findOne($id_period);
        $PayrollGroup = PayrollGroup::findOne($id_payroll_group);
        $srcPayrollModel = New PayrollSearch();
        $dataprovider = $srcPayrollModel->searchByGroup(Yii::$app->request->queryParams, $id_payroll_group, $id_period);
        return $this->render('indexarchivepayroll',[
            'period'=>$period,
            'searchModel'=>$srcPayrollModel,
            'dataProvider'=>$dataprovider,
            'PayrollGroup'=>$PayrollGroup,
            
        ]);
    }

    public function actionPayrollpdf($id_period, $id_payroll_group){
        $period = Period::findOne($id_period);
       
        
        $pdf=new fpdf('P','mm','A4');
        $pdf->SetMargins(5,5,5);
        $pdf->SetFillColor(224,224,224);//Grey
        //$pdf->SetTopMargin(10);
        //$pdf->SetButtomMargin(10);
        $t_baris=2.5;//tinggi baris
        $pdf->SetFont('courier','',6);
        $pdf->AddPage();
        $header = array('Tanggal', 'Hari', 'GP/jam', 'EV', 'OT', 'Gj.Pokok', 'Gj.Lmbr', 'Insentif', 'T. Msker', 'P.Telat', 'P.Safety', 'Total');
        // Column widths
        $w = array(16, 15, 15, 6, 6, 20, 20, 20, 20, 20, 20, 20);
        //select attribut payroll
        /*$qry_attribut=mysql_query("select * from attribut_payroll");
        $row_attribut=mysql_fetch_array($qry_attribut);
        */
        $payroll = Payroll::find()->where(['id_period'=>$id_period, 'id_payroll_group'=>$id_payroll_group])->all();
                
                //:::::::::::::::::::::::    PERULANGAN ALL KARYAWAN  :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
                $page =0;
                //while ($row_emp=mysql_fetch_array($rs_emp)) { 	
                foreach ($payroll as $payrolls){	
                //Kasbon 
                //Kasbon
                $EmpKasbon = New CppKasbon($payrolls->id_employee, $payrolls->id_period);
                
                
                //end kasbon 
                
                $pdf->SetFont('','B','');
                $pdf->Cell($w[0]+$w[1]+$w[2]+$w[3],$t_baris,"Nama: ".$payrolls->employee_name." Basic:".Yii::$app->formatter->asCurrency($payrolls->basic_salary,''),1,0,'L',1);
                $pdf->SetFont('','B','');
                $pdf->Cell($w[4]+$w[5]+$w[6]+$w[7]+$w[8]+$w[9],$t_baris+$t_baris,"SLIP GAJI MANPOWER {$payrolls->payroll_name}",1,0,'C',1);
                $pdf->SetFont('','B','');
                $pdf->Cell($w[10]+$w[11],$t_baris,$period->period_name,1,0,'R',1);
                $pdf->Ln();
                $pdf->Cell($w[0]+$w[1]+$w[2]+$w[3],$t_baris,"Jabatan: [jabatan]",1,0,'L',1);		
                $pdf->Cell($w[4]+$w[5]+$w[6]+$w[7]+$w[8]+$w[9],0,'',0,0,'C');
                $pdf->Cell($w[10]+$w[11],$t_baris,"Reg Number : ".$payrolls->reg_number,1,0,'R',1);
                $pdf->Ln();
                $pdf->SetFont('','','');
                for($hi=0;$hi<count($header);$hi++) {
                $pdf->Cell($w[$hi],$t_baris,$header[$hi],1,0,'C');		
                }
                $pdf->Ln();
                
                //::::::::::::::::::::::::::::::::::::::::::::::  PERULANGAN WAKTU DALAM SATU PERODE :::::::::::::::::::::::::::::::::::::::::::::::::
                
               
                $PDay = PayrollDay::find()->where(['id_employee'=>$payrolls->id_employee,'id_period'=>$payrolls->id_period,'id_payroll_group'=>$payrolls->id_payroll_group])->all();
                //while ($row_posDetil=mysql_fetch_assoc($rs_posDetil)) 
                foreach ($PDay as $PayrollDay)
                { 	
                    
                    $GP2=number_format($PayrollDay->basic_salary,2,',','.');
                    $GL2=number_format($PayrollDay->overtime_salary,2,',','.');
                    //$UM2=number_format(0,2,',','.');
                    $potongan_telat2=number_format($PayrollDay->pot_telat,2,',','.');
                    $p_safety2=number_format(0,2,',','.');
                    $t_msker2=number_format($PayrollDay->t_masakerja,2,',','.');
                    $GT2=number_format($PayrollDay->total_gaji,2,',','.');
                    $pdf->SetFont('','','');
                    $pdf->Cell($w[0],$t_baris,$PayrollDay->date_payroll,1,0,'L');
                    $pdf->Cell($w[1],$t_baris,$PayrollDay->name_day,1,0,'C');
                    $pdf->Cell($w[2],$t_baris,ceil($PayrollDay->basic_per_hour),1,0,'R');
                    $pdf->Cell($w[3],$t_baris,$PayrollDay->ev_hour,1,0,'C');			
                    $pdf->Cell($w[4],$t_baris,$PayrollDay->ot_hour,1,0,'C');
                    $pdf->Cell($w[5],$t_baris,$GP2,1,0,'R');
                    $pdf->Cell($w[6],$t_baris,$GL2,1,0,'R');
                    $pdf->Cell($w[7],$t_baris,$PayrollDay->insentif,1,0,'R');
                    $pdf->Cell($w[8],$t_baris,$t_msker2,1,0,'R');
                    $pdf->Cell($w[9],$t_baris,$potongan_telat2,1,0,'R');
                    $pdf->Cell($w[10],$t_baris,$p_safety2,1,0,'R');
                    $pdf->Cell($w[11],$t_baris,$GT2,1,0,'R');
                    $pdf->Ln();
                    
                  
                    
                }            
                
                $pdf->Cell($w[0]+$w[1],$t_baris,'Jumlah',1,0,'L',1);//jumlah
                $pdf->Cell($w[2],$t_baris,'WT/PT',1,0,'L',1);
                $pdf->Cell($w[3],$t_baris,$payrolls->wt,1,0,'C',1);
                
                $pdf->Cell($w[4],$t_baris,$payrolls->pt,1,0,'C',1);
                $pdf->Cell($w[5],$t_baris,0,1,0,'R',1);
                $pdf->Cell($w[6],$t_baris,0,1,0,'R',1);
                $pdf->Cell($w[7],$t_baris,0,1,0,'R',1);
                $pdf->Cell($w[8],$t_baris,0,1,0,'R',1);
                $pdf->Cell($w[9],$t_baris,0,1,0,'R',1);
                $pdf->Cell($w[10],$t_baris,0,1,0,'R',1);		
                $pdf->Cell($w[11],$t_baris,0,1,0,'R',1);
                $pdf->Ln();		
                $pdf->Cell($w[0]+$w[1]+$w[2]+$w[3]+$w[4]+$w[5]+$w[6],$t_baris,"Insentif : {$payrolls->dscription_kasbon}",0,0,'C');
                $pdf->Cell($w[7],$t_baris,'Kasbon',1,0,'L');
                $pdf->Cell($w[8],$t_baris,Yii::$app->formatter->asCurrency($EmpKasbon->getKasbon(),''),1,0,'R');
                $pdf->Cell($w[9]+$w[10],$t_baris,'Potongan Cicilan kasbon',1,0,'L');
                $pdf->Cell($w[11],$t_baris,Yii::$app->formatter->asCurrency($payrolls->cicilan_kasbon,''),1,0,'R');
                $pdf->Ln();		
                $pdf->Cell($w[0]+$w[1]+$w[2]+$w[3]+$w[4]+$w[5]+$w[6],$t_baris,'',0,0,'C');
                $pdf->Cell($w[7],$t_baris,'Total Cicilan',1,0,'L');
                $pdf->Cell($w[8],$t_baris,Yii::$app->formatter->asCurrency($EmpKasbon->getTotalCicilan(),''),1,0,'R');
                $pdf->Cell($w[9]+$w[10],$t_baris,'Jamsostek',1,0,'L');
                $pdf->Cell($w[11],$t_baris,0,1,0,'R');
                $pdf->Ln();				
                
                //$pdf->Cell($w[0]+$w[1]+$w[2]+$w[3]+$w[4]+$w[5]+$w[6]+$w[7]+$w[8],$t_baris,'',0,0,'C');
                $pdf->Cell($w[0]+$w[1]+$w[2]+$w[3]+$w[4]+$w[5]+$w[6],$t_baris,'',0,0,'C');
                $pdf->Cell($w[7],$t_baris,'Sisa Kasbon',1,0,'L');
                $pdf->Cell($w[8],$t_baris,Yii::$app->formatter->asCurrency($EmpKasbon->getSisaKasbon(),''),1,0,'R');
                $pdf->Cell($w[9]+$w[10],$t_baris,'Kelebihan Gaji',1,0,'L');
                $pdf->Cell($w[11],$t_baris,0,1,0,'R');
                $pdf->Ln();
                $pdf->Cell($w[0]+$w[1]+$w[2]+$w[3]+$w[4]+$w[5]+$w[6]+$w[7]+$w[8],$t_baris,'',0,0,'C');
                $pdf->Cell($w[9]+$w[10],$t_baris,'Kekurangan Gaji',1,0,'L');
                $pdf->Cell($w[11],$t_baris,0,1,0,'R');
                $pdf->Ln();	
                
                                
            
                
                $pdf->Cell($w[0]+$w[1]+$w[2]+$w[3]+$w[4]+$w[5]+$w[6]+$w[7]+$w[8],$t_baris,'',0,0,'C');
                $pdf->Cell($w[9]+$w[10],$t_baris,'Total Gaji',1,0,'L',1);
                $pdf->Cell($w[11],$t_baris,number_format($payrolls->grand_total_salary,2,',','.'),1,0,'R',1);
                $pdf->Ln();		
                $pdf->Ln();
                $pdf->Ln();
                //MultiCell(float w, float h, string txt [, mixed border [, string align [, boolean fill]]];
                //Line(float x1, float y1, float x2, float y2);
                //$pdf->MultiCell( 170, 1,'',1,'');
                $page++;
                if ($page%5==0)
                $pdf->AddPage();		
                }			
        //------------------
        $pdf->Output("$period->period_name.pdf",'I');
        
    }

    
    
    
    public function actionSummarypdf($id_period, $id_payroll_group){
        $payroll = Payroll::find()->joinWith('employee a')->join('LEFT JOIN', 'coreperson b', 'b.id = a.id_coreperson')->where(['id_period'=>$id_period, 'id_payroll_group'=>$id_payroll_group])->all();      
        $PayrollGroup = PayrollGroup::findOne($id_payroll_group);
        $period = Period::findOne($id_period);
        
        $pdf = New fpdf("P",'mm', 'A4');
        $pdf->SetMargins(30,10,5);
       
        $t_baris=3;//tinggi baris
        $pdf->SetFont('arial','',7);
        $pdf->AddPage();
        $header = array('BAGED ID', 'NAMA', 'JABATAN', 'GAJI', 'WT', 'PT', 'NO. REKENING');
        // Column widths
        $w = array(20, 40, 35, 25, 10, 10, 30);
        
        $pdf->SetFont('','B',10);
        $pdf->SetFillColor(224,224,224);//Grey
        $pdf->Cell($w[0]+$w[1]+$w[2]+$w[3]+$w[4]+$w[5]+$w[6],6,"Summary Gaji DW Project {$PayrollGroup->name} {$period->period_name}",0,0,'C');
        $pdf->Ln();
        $pdf->SetFont('','',7);		
        for($hi=0;$hi<count($header);$hi++) {
        $pdf->Cell($w[$hi],6,$header[$hi],1,0,'C',1);		
        }
        $pdf->Ln();	  
        $SUM_GJ_BERSIH=0;
       $SUM_WT=0;
       $SUM_PT=0;
       
        foreach ($payroll as $payrolls){
            $pdf->Cell($w[0],$t_baris,$payrolls->reg_number,1,0,'C');
            $pdf->Cell($w[1],$t_baris,$payrolls->employee_name,1,0,'L');
            $pdf->Cell($w[2],$t_baris,"{$payrolls->jabatan}",1,0,'L');
            $pdf->Cell($w[3],$t_baris, Yii::$app->formatter->asCurrency($payrolls->tg_all,''),1,0,'R');
            $pdf->Cell($w[4],$t_baris,$payrolls->wt,1,0,'C');
            $pdf->Cell($w[5],$t_baris,$payrolls->pt,1,0,'C');
            $pdf->Cell($w[6],$t_baris,"{$payrolls->employee->coreperson->bank_account}",1,0,'C');			
            $pdf->Ln();
            $SUM_GJ_BERSIH+=$payrolls->tg_all;
            $SUM_WT+= $payrolls->wt;
            $SUM_PT+= $payrolls->pt;
        }
        
            
       
        $pdf->Cell($w[0],$t_baris,'',0,0,'C');
        $pdf->Cell($w[1],$t_baris,'',0,0,'C');
        $pdf->SetFont('','B',7);
        $pdf->Cell($w[2],$t_baris,'Total',1,0,'C');		
        $pdf->Cell($w[3],$t_baris,Yii::$app->formatter->asCurrency($SUM_GJ_BERSIH.''),1,0,'R');//Numeric
        $pdf->Cell($w[4],$t_baris,$SUM_WT,1,0,'C');
        $pdf->Cell($w[5],$t_baris,$SUM_PT,1,0,'C');
        $pdf->SetFont('','',7);
        $pdf->Cell($w[6],$t_baris,'',0,0,'C');
        $pdf->Ln();
        $pdf->Ln();
        
        //----------------------------------------
        $pdf->Cell(35,7,'',0,0,'C');//ADI
        $pdf->Cell(10,7,'',0,0,'C');
        $pdf->Cell(35,7,'',0,0,'C');//EMIL
        $pdf->Cell(10,7,'',0,0,'C');
        $pdf->Cell(35,7,'',0,0,'C');//JOICE
        $pdf->Cell(10,7,'',0,0,'C');$hari_ini=date("d M Y");
        $pdf->Cell(35,7,"Surabaya, $hari_ini",0,0,'C');//ANDRE
        $pdf->Ln();
        //--------------------------------------------
        $pdf->Cell(35,7,'',0,0,'C');//ADI
        $pdf->Cell(10,7,'',0,0,'C');
        $pdf->Cell(35,7,'Acknowledge By,',0,0,'C');//EMIL
        $pdf->Cell(10,7,'',0,0,'C');
        $pdf->Cell(35,7,'',0,0,'C');//JOICE
        $pdf->Cell(10,7,'',0,0,'C');
        $pdf->Cell(35,7,'Prepared By,',0,0,'C');//ANDRE
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        //----------------------------------------
        $pdf->SetFont('','U','');
        $pdf->Cell(35,3,'ADI IRMANTYO',0,0,'C');
        $pdf->Cell(10,3,'',0,0,'C');
        $pdf->Cell(35,3,'penanggung jawab',0,0,'C');
        $pdf->Cell(10,3,'',0,0,'C');
        $pdf->Cell(35,3, 'Bondan Chayadi',0,0,'C');
        $pdf->Cell(10,3,'',0,0,'C');
        $pdf->Cell(35,3,'Faris Hibatur',0,0,'C');
        $pdf->Ln();
        //----------------------------------------
        $pdf->SetFont('','','');
        $pdf->Cell(35,3,'Deputi Administrative Operation',0,0,'C');
        $pdf->Cell(10,3,'',0,0,'C');
        $pdf->Cell(35,3,'Jabatan',0,0,'C');
        $pdf->Cell(10,3,'',0,0,'C');
        $pdf->Cell(35,3,'Manager HRD',0,0,'C');
        $pdf->Cell(10,3,'',0,0,'C');
        $pdf->Cell(35,3,'Payroll HR',0,0,'C');
        $pdf->Ln();
        $pdf->Ln();
        //----------------------------------------
        $pdf->SetFont('','','');
        $pdf->Cell(45,7,'',0,0,'C');
        $pdf->Cell(80,7,'Approved By,',0,0,'C');
        $pdf->Cell(45,7,'',0,0,'C');		
        $pdf->Ln(20);
        //----------------------------------------
        $pdf->SetFont('','U','');
        $pdf->Cell(45,3,'',0,0,'C');
        $pdf->Cell(80,3,'LION MOEDJIONO / NURUL KAHIR,',0,0,'C');
        $pdf->Cell(45,3,'',0,0,'C');		
        $pdf->Ln();
        //----------------------------------------
        $pdf->SetFont('','','');
        $pdf->Cell(45,3,'',0,0,'C');
        $pdf->Cell(80,3,'Director',0,0,'C');
        $pdf->Cell(45,3,'',0,0,'C');		
        $pdf->Ln();
        //----------------------------------------------
        $pdf->Output("Summary_.pdf",'I');
        //-----------------------end--------------------------------------------------------------
    }

    

    public function actionTes($id, $id_payroll_group){
        //$id_payroll_group = 1;
        $period = Period::findOne($id);
        //-----------------------------------------------data period-------------------------------------------------------
        $data_period = [];
        $payroll_group_employee = PayrollGroupEmployee::find()->where(['id_payroll_group'=>$id_payroll_group])->limit(20)->all();
        foreach ($payroll_group_employee as $group){
            $employee = Employee::findOne($group->id_employee);
            $EmpKasbon = New CppKasbon($employee->id, $id);
        
            $DateRange = DateRange::getListDay($period->start_date, $period->end_date);
            //----------------------------------------------------------------------------
            $attendance = [];
            $Cetak = New CetakPayroll;
            $sal_day = 0;
            foreach ($DateRange as $date_now){
                $gaji = New GajiHarian($employee->id, $employee->basic_salary, $date_now, $employee->date_of_hired);
                $data= [
                    'date_now'=>$gaji->date_now,
                    'name_day'=>$gaji->getNameDay(),
                    'in'=>$gaji->getAttendance()['emp_in'],
                    'out'=>$gaji->getAttendance()['emp_in'],
                    //'office_start'=>$gaji->getOfficeStart(),
                    //'office_stop'=>$gaji->getOfficeStop(),
                    'id_employee'=>$gaji->id_employee,            
                    'date_now'=>$gaji->date_now,
                    'office_duration'=>$gaji->shift_office_duration,
                    'isDayOffNational'=>$gaji->isDayOffNational(),
                    'isDayOff'=>$gaji->shift_dayoff,
                    'attendance'=> $gaji->getAttendance(),
                    'ev'=>$gaji->getEffective(),
                    'ot'=>$gaji->getOverTime(),
                    'telat'=>$gaji->getTelat(),
                    'basic'=>$gaji->getBasic(),
                    't_masakerja'=>$gaji->getTmasakerja(),
                    'ot_salary'=>$gaji->getSalaryOvertime(),
                    'insentif'=>$gaji->getInsentif(), 
                    //'potongan_telat'=>$gaji->getPotonganTelat(),    
                    //'potongan_covid2'=>$gaji->getPotonganCovid2(),        
                    'potongan'=>$gaji->getPotongan(),                    
                    'ket'=>$gaji->getDscription(),
                    'salary_day'=>$gaji->getSalaryDay(),       
                ];
                
                $Cetak->tambahData($gaji);
                array_push($attendance, $data);
                //$sal_day+= $gaji->getSalaryDay();
            }
            //--------------------------------------------------------------------------------

            $data_array = [
                'reg_number'=>$employee->reg_number,
                'name'=>$employee->name,
                'doh'=>$employee->date_of_hired,
                'list_hari'=>$attendance,
                'salary_period'=>$Cetak->getSalaryPeriod(),
                'potongan_kasbon'=>$EmpKasbon->getPotonganKasbon(),
                'salary_period_total'=>$Cetak->getSalaryPeriod()-$EmpKasbon->getPotonganKasbon(),
            ];
            array_push($data_period, $data_array);
            


        }
        return $this->render('coba',[
            'data_period'=>$data_period,
        ]);
        //var_dump($data_employee);

    }

}
