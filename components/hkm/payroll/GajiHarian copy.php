<?php
//namespace components\hkm\payroll;

use app\components\hkm\payroll\InsentifEmployee;
use app\models\Attendance;
use app\models\Dayoff;
use app\models\Spkl;
use app\models\TimeshiftEmployee;
use DateInterval;
use DateTime;

class GajiHarianCopy
{
    public
    $id_employee,
    $basic,
    $date_now,
    $doh,
    $shift_office_start,
    $shift_office_ev,
    $shift_dayoff;
    //$name_day,
    //$ev,
    //$ot,
    //$t_masakerja,
    //$insentif,
    //$potongan_telat,
    //$potongan_covid,
    
    //$list_insentif,
    //$list_schedule,
    //property Time Shift----------
    
    //$shift_office_stop,
    
    //---------end Timeshift--------
    //$salary_day;
        

    public function __construct($id_employee, $basic, $date_now, $doh)
    {
        $this->id_employee = $id_employee;
        $this->basic = $basic;
        $this->date_now = $date_now;
        $this->doh = $doh;
        //$this->list_insentif = $list_insentif;
        //$this->list_schedule = $list_schedule;

        $adaShift = TimeshiftEmployee::find()->where(['date_shift'=>$date_now, 'id_employee'=>$id_employee]);
        if ($adaShift->exists()){
            $shift = $adaShift->one();
            $this->shift_office_start = $shift->office_start;
            $this->shift_office_ev = $shift->duration_hour;
            $this->shift_dayoff = $shift->is_dayoff;

        }else {
            $this->shift_office_start = '08:00:00';
            $this->shift_office_ev = 0;
            $this->shift_dayoff = TRUE;
        }

    }

 
public function getOfficeStart(){
            $str_office_in = $this->date_now." ".$this->shift_office_start;
            return $str_office_in;
        }
    
        public function getOfficeStop(){
            $str_office_in = $this->date_now." ".$this->shift_office_start;
            $obj_office_out = New DateTime($str_office_in);
            if ($this->shift_office_ev >=7){
                $diffev = $this->shift_office_ev+1;
                $diffInterval = 'PT'.$diffev.'H';
            }else {
                $diffev = $this->shift_office_ev;
                $diffInterval = 'PT'.$diffev.'H';
            }
            $obj_office_out->add(New DateInterval($diffInterval));
            return $obj_office_out->format("Y-m-d H:i:s");
        }

        public function isDayOffNational(){
            $LiburNasional = Dayoff::find()->where(['date_dayoff'=>$this->date_now]);
            if($LiburNasional->exists()){
                return TRUE;
            }
            return FALSE;
        }
       
        public function getAttendance(){
            $att=['emp_in'=>NULL, 'emp_out'=>NULL, 'ket'=>'off'];

            $att = Attendance::find()->where(['id_employee'=>$this->id_employee, 'date'=>$this->date_now]);
                   
            if ($att->exists()){ //Jika ada absensis nya 
                
                $atts = $att->one();
                if (empty($atts->login) && empty($atts->logout)){
                    $emp_in = NULL;
                    $emp_out = NULL;
                    $ket = 'alpha';

                }elseif (empty($atts->login) && !empty($atts->logout)){
                    $emp_in = $atts->login;
                    $emp_out = NULL;
                    
                }elseif (!empty($atts->login) && empty($atts->logout)){
                    $emp_in = NULL ;
                    $emp_out = $atts->logout;
                }else {
                    $emp_in = $atts->login;
                    $emp_out = $atts->logout;
                    $ket='on';
                }                                        
                
            }else{
                $emp_in = NULL;
                $emp_out = NULL;               
                
            }
            if ($this->shift_dayoff){
                $ket = 'off';
            }elseif($this->isDayOffNational()){
                $ket = 'off_national';
            }
            
            $att= ['emp_in'=> $emp_in,'emp_out'=> $emp_out, 'ket'=>$ket];
            return $att;          
            
        }

        public function earlyIn(){
            if ($this->shift_dayoff){
                return false;
            }
            $obj_office_start = New DateTime($this->getOfficeStart());
            $obj_person_in = New DateTime($this->person_start);
            $diff_start = $obj_person_in->diff($obj_office_start);
        
            $early_in  = $diff_start->format('%R1');
            $early = $early_in >0 ?True:False;
            return $early;
        }
    
        public function  lateOut(){
            if ($this->ket=="off"){
                return false;
            }
            $obj_office_stop = New DateTime($this->getOfficeStop());
            $obj_person_out = New DateTime($this->person_stop);
            $diff_out = $obj_office_stop->diff($obj_person_out);
    
            $late_out  = $diff_out->format('%R1');
            $lateout = $late_out >0 ?True:False;
            return $lateout;
        }

        public function getDurationEv(){
            $att = $this->getAttendance();
            if ($att['ket'] == "off"){
                $person_ev = 0;
            }else {
                if (empty($att['emp_in']) || empty($att['emp_out'])){
                    $person_ev = 0;
                }else {
    
                    //Jika telat 
                    $obj_person_in = New DateTime($att['emp_in']);
                    $obj_person_out = New DateTime($att['emp_out']);
                  
                    $obj_office_start = New DateTime($this->getOfficeStart());
                    $obj_office_stop = New DateTime($this->getOfficeStop());
    
                   
                    if($this->earlyIn() && $this->lateOut()){ //if ($early_in  && late_out)              
                        $person_ev = $this->office_ev;
                    }
                    elseif(!$this->earlyIn() && !$this->lateOut()) {//else if (!$early_in && !late_out)
                        //ev = diff($person_in,person_out );
                        $diff_ev = $obj_person_in->diff($obj_person_out);
                        $person_ev = $diff_ev->format('%H');
                        if($this->office_ev >=7){
                            $person_ev = $person_ev -1;//-1 jam istirahat
                        }
                        
                    }
                    elseif($this->earlyIn() && !$this->lateOut()) {//else if ($early_in && !late_out)
                        //ev= dif(office_in,$person_out);     
                        $diff_ev = $obj_office_start->diff($obj_person_out);
                        $person_ev = $diff_ev->format('%H');
                        if($this->office_ev >=7){
                            $person_ev = $person_ev -1;//-1 jam istirahat
                        }
                        
                        
                    }
                    else {//else pasti datang telat dan pulang tepat waktu
                        //ev = diff(person_out, offic_out)
                        $diff_ev = $obj_person_in->diff($obj_office_stop);
                        $person_ev = $diff_ev->format('%H');
    
                        if($this->office_ev >=7){
                            $person_ev = $person_ev -1;//-1 jam istirahat
                        }    
                    }     
    
                }
            }
            return $person_ev;
        }

        //Overtime
        public function getOverTime(){
            $spkl= $this->getOverTimeApprove();
            $att = $this->getAttendance();
           
            if($spkl>0){
                if ($this->shift_dayoff || $this->isDayOffNational()){
                    if (!empty($att['emp_in']) || !empty($att['emp_out'])){
                        //$obj_office_stop = new DateTime($this->getOfficeStop());
                        $obj_person_in = New DateTime($att['emp_in']);
                        $obj_person_out = New DateTime($att['emp_out']);
                        $diff_ot = $obj_person_in->diff($obj_person_out);
                        $ot = $diff_ot->format('%h');
                    }else {
                        $ot =0;
                    }
                }
               
                elseif($this->getDurationEv()>0) { //$this->shift_office_ev){
                    $obj_office_stop = new DateTime($this->getOfficeStop());
                    $obj_person_out = New DateTime($att['emp_out']);
                    $diff_ot = $obj_office_stop->diff($obj_person_out);
                    $ot = $diff_ot->format('%h');
                    //return $ot;
                }else {
                    $ot = 0;
                }
            }else {
                $ot = 0;
            }

            if ($this->overtime_approve < $ot){
                $policy_ot = $this->overtime_approve;
            }else {
                $policy_ot = $ot;
            }
            return $policy_ot;
        }

        //T Masakerja 
        public function getTmasakerja(){
            $today = date_create($this->date_now);
            $obj_doh = date_create($this->doh);
            $diff_doh = $obj_doh->diff($today);
            $n = $diff_doh->format('%Y');
            $nilai = 0;
            if ($n<2){
                $nilai = 0;
            }else
            {
                $n_kerja = 0;
                for ($i=0;$i<=$n;$i++){
                    
                    if ($i%2==0){
                        $n_kerja  ++;

                    }
                }
                $nilai = $n_kerja * 1000;
            
            }
            return $nilai;
            

        }

        public function getOverTimeApprove(){
            $spkl = Spkl::find()->where(['date_spkl'=>$this->date_now, 'id_employee'=>$this->id_employee]);
            if ($spkl->exists()){
                $ot = Spkl::find()->where(['date_spkl'=>$this->date_now, 'id_employee'=>$this->id_employee])->one();
                return $ot->overtime_hour;
            }else {
                return 0;
            }
        }

        public function getSalaryOvertime(){
            $att = $this->getAttendance();
            $const_hari = 25;
            $v_gajilembur = ($this->basic * $const_hari)/173;

            //$shift = $this->getShift();

            if ($this->isDayOffNational OR $this->shift_dayoff) { //Jika Libur Nasional & Libur Mingguan
                //$ot=$this->getOvertime();
                //$gaji_ot=2*($this->gaji/7)*$this->getOvertime();
                if ($this->getOverTime()==8){
                    //$gaji_ot=3*($this->gaji/7)*$this->getOvertime();
                    $gj1=2*($v_gajilembur)*($this->getOvertime()-1);
                    $gj2=3*($v_gajilembur)*1;
                    $gaji_ot=$gj1+$gj2;
                }
                //elseif ($ot>=9) {
                elseif ($this->getOvertime() >=9) {
                    $gaji_ot=4*($this->gaji/7)*$this->getOvertime();
                    $gj1=2*($v_gajilembur)*7;
                    $gj2=3*($v_gajilembur)*1;
                    $gj3=4*($v_gajilembur)*($this->getOvertime()-8);
                    $gaji_ot=$gj1+$gj2+$gj3;
                    //$gaji_ot=100;
                }
                else {
                    $gaji_ot=2*($v_gajilembur)*$this->getOvertime();
                }
                
            }elseif($att['ket']=="alpha"){
                $gaji_ot = 0;
            }             
            else {
                if ($this->getOvertime()<=9 AND $this->getOvertime()>0){
                    $part1=1.5*($v_gajilembur);
                    $part2=2*($this->getOvertime() -1)*($v_gajilembur);
                    $gaji_ot=$part1+$part2;
                }
                elseif ($this->getOvertime()>9){
                    $part1=1.5*($v_gajilembur);
                    $part2=2*8*($v_gajilembur);
                    $part3=3*($this->getOvertime()-9)*($v_gajilembur);
                    $gaji_ot=$part1+$part2+$part3;
                }else {
                    $gaji_ot=0;
                }
            }
            return $gaji_ot;
        }

        public function getTelat(){
            $att = $this->getAttendance();
            if ($att['ket']=="off" || empty($att['emp_in']) || empty($att['emp_out'])){
                $telat = "00:00:00";
            }else {
                $obj_p_s = New DateTime($att['emp_in']);
                $obj_o_s = New DateTime($this->getOfficeStart()); 
    
                $diff_start = $obj_p_s->diff($obj_o_s);
            
                $late  = $diff_start->format('%R1');
                $late_in = $late < 0 ?True:False;
                if ($late_in) {
                    //$late_h = $diff_start->format('%H');
                    //$late_m = $diff_start->format('%m');
                    $telat =  $diff_start->format('%H:%I:%S');
                }else{
                    $telat = '00:00:00';
                }
            }
            
            return  $telat;
        }

        public function getPotonganTelat(){
            $basic_hour = $this->basic/$this->shift_office_ev;
            $potongan = 0;
            $x = $this->getTelat();
            $y = explode(":", $x);
            if ($y[0]==0){
                if ($y[1]>5 && $y[1]<=25){
                    //Potongan 1 jam ;
                    $potongan = $basic_hour; //$this->getBasicHour();
                }elseif($y[1]>=26){
                    //potongan 2 * jam ;
                    $potongan = 2* $basic_hour; //$this->getBasicHour();
                }
            }elseif($y[0]==1){
                //potongan 2 jam;
                $potongan = 2* $basic_hour; //$this->getBasicHour()*2;
            }elseif($y[0]>=2){
                $potongan = $y[0] * $basic_hour; //this->getBasicHour()*$y[0];
            }else {
                $potongan = 0;
            }
            
           return $potongan;
        }

        //Insentif Karyawan
        public function getInsentif(){
            $ins = InsentifEmployee::getInsentif($this->id_employee, $this->date_now);
            return $ins;
        }   

        //Gaji Total per Hari 
        public function getSalaryDay(){
            $salary = $this->basic + $this->getSalaryOvertime() + $this->getTmasakerja() 
            + $this->getInsentif()
            - $this->getPotonganTelat();
            return $salary;
        }

        public function getPotonganCovid(){

        }
        
}