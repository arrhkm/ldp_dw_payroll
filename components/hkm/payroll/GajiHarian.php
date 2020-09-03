<?php 
namespace app\components\hkm\payroll;

use app\components\hkm\DateRange;
use app\components\hkm\NameDay;
use app\components\hkm\payroll\InsentifEmployee;
use app\models\Attendance;
use app\models\ComponentGroup;
use app\models\DailyComponentDetil;
use app\models\Dayoff;
use app\models\Leave;
use app\models\Spkl;
use app\models\TimeshiftEmployee;
use DateInterval;
use DateTime;

class GajiHarian {
    public
    $id_employee,
    $basic,
    $date_now,
    $doh,
    $shift_office_start,
    $shift_office_ev,
    $shift_office_duration,
    $shift_dayoff,
    $ada_shift,
    $isDayOffNational,
    $att_login,
    $insentif,
    $component_payroll,    
    $att_logout,
    $overtime_approve,
    $isCovid25, 
    $isCovid80,
    $is_annual_leave,
    $is_sick,
    $is_permit,
    $is_sepecial_permit
    ;

    public function __construct($id_employee, $basic, $date_now, $doh, $isDayOffNational)
    {
        $this->id_employee = $id_employee;
        $this->basic = $basic;
        $this->date_now = $date_now;
        $this->doh = $doh;
        $this->isDayOffNational = $isDayOffNational;

        //Leave
        $DtLeave = Leave::find()->where(['id_employee'=>$id_employee, 'date_leave'=>$date_now]);
        $this->is_annual_leave=false;
        $this->is_sick= false;    
        $this->is_permit=false;
        $this->is_sepecial_permit=false;

        if ($DtLeave->exists()){
            $leave = $DtLeave->one();
            switch ($leave->id_leave_type) {
                case 1:  
                    $this->is_annual_leave = true;
                    break;
                case 2:  
                    $this->is_sick = true;
                    break;
                case 3:  
                    $this->is_permit = true;
                    break;
                case 4:  
                    $this->is_sepecial_permit = true;
                    break;
              
            }
        }
        
        //--------------end-Leave---------------
        $this->isCovid25 = DailyComponentDetil::find()->where(['id_employee'=>$this->id_employee, 'date_component'=>$this->date_now, 'id_daily_component'=>1])->exists();
        $this->isCovid80 = DailyComponentDetil::find()->where(['id_employee'=>$this->id_employee, 'date_component'=>$this->date_now, 'id_daily_component'=>2])->exists();
        $spkl = Spkl::find()->where(['date_spkl'=>$this->date_now, 'id_employee'=>$this->id_employee])->one();
        $this->overtime_approve = $spkl?$spkl->overtime_hour:0;
        $this->insentif = InsentifEmployee::getInsentif($this->id_employee, $this->date_now);
        $att = Attendance::find()->where(['id_employee'=>$this->id_employee, 'date'=>$this->date_now]);
        if ($att->exists()){
            $att= $att->one();
            $this->att_login = $att->login;
            $this->att_logout = $att->logout;
        }else{
            $this->att_login = NULL;
            $this->att_logout = NULL;
        }
       
        $Shift = TimeshiftEmployee::find()->where(['date_shift'=>$date_now, 'id_employee'=>$id_employee])->one();
        if(empty($Shift)) {
            $this->ada_shift = FALSE;
            $this->shift_office_start = '08:00:00';
            $this->shift_office_duration = 0;
            $this->shift_dayoff = TRUE;
            
        }
        else{
            $this->ada_shift= TRUE;           
            $this->shift_office_start = $Shift->start_hour;  
            $this->shift_office_duration =  $Shift->duration_hour;         
            $this->shift_dayoff = $Shift->is_dayoff;
            

        }

        $this->component_payroll = ComponentGroup::find()->where(['id_employee'=>$this->id_employee, 'id_component_payroll'=>1])->one();
  
    }

    public function isDirumahkan(){
        //$dirumahkan = ComponentGroup::find()->where(['id_employee'=>$this->id_employee, 'id_component_payroll'=>1]);
        //if ($dirumahkan->exists()){
        if (!empty($this->component_payroll)){
            //$x = $dirumahkan->one();
            $list = DateRange::getListDay($this->component_payroll->start_date, $this->component_payroll->end_date);
            if(in_array($this->date_now,  $list)){
                return TRUE;
            }
        }
        return false;
    }

    public function getLeave(){
        $leave = Leave::find()->where(['id_employee'=>$this->id_employee, 'date_leave'=>$this->date_now]);
        return $leave;
    }

    public function getAnualLeave(){
        //if ($this->getLeave()->exists()){
            //$x = $this->getLeave()->one();
            //if ($x->id_leave_type==1){
            //if($this->$is_annual_leave){
            //    return True;
            //}else return false;
        //}else return false;
        return $this->is_annual_leave;
    }

    public function isSakit(){
        /*if ($this->getLeave()->exists()){
            $x = $this->getLeave()->one();
            if ($x->id_leave_type==2){
                return True;
            }else return false;
        }else return false;*/
        return $this->is_sick;
    }

    public function getIjin(){
        /*if ($this->getLeave()->exists()){
            $x = $this->getLeave()->one();
            if ($x->id_leave_type==3){
                return True;
            }else return false;
        }else return false;
        */
        return $this->is_permit;
    }

    public function getIjinKhusus(){
        /*if ($this->getLeave()->exists()){
            $x = $this->getLeave()->one();
            if ($x->id_leave_type==4){
                return True;
            }else return false;
        }else return false;
        */
        return $this->is_sepecial_permit;
    }

    public function getNameDay(){
        return NameDay::getName($this->date_now);
    }
    public function getOfficeStart(){
        $str_office_in = $this->date_now." ".$this->shift_office_start;
        return $str_office_in;
    }

    public function getOfficeStop(){
        $str_office_in = $this->date_now." ".$this->shift_office_start;
        $obj_office_out = New DateTime($str_office_in);

        if ($this->shift_office_duration==7){
            $diffev = 8;
            //$diffInterval = 'PT'.$diffev.'H';
        }elseif ($this->shift_office_duration == 5){
            $diffev = 5;
            //$diffInterval = 'PT'.$diffev.'H';
        }else {
            $diffev = 0;
        }
        $diffInterval = 'PT'.$diffev.'H';        
        $obj_office_out->add(New DateInterval($diffInterval));
        return $obj_office_out->format("Y-m-d H:i:s");
    }

    /*public function isDayOffNational{
        $LiburNasional = Dayoff::find()->where(['date_dayoff'=>$this->date_now]);
        if($LiburNasional->exists()){
            return TRUE;
        }
        return FALSE;
    }*/

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

        if ($this->shift_dayoff){
            if ($this->getOverTime()>0){
                return  $nilai;
            }else {
                return 0;
            }
        }elseif ($this->isDayOffNational){
            if($this->getOverTime()>0){
                return $nilai;
            }else {
                return 0;
            }
        }elseif ($this->isSakit()){
            return 0;
        }else{
            return round($nilai);
        }
        
        //return $nilai;
        

    }

    public function getEffective(){
        if ( $this->shift_dayoff || $this->isDayOffNational || (empty($this->att_login) || $this->att_logout==NULL)){
            $ev = 0;
        }else {
            $obj_person_in = New DateTime($this->att_login);
            $obj_person_out = New DateTime($this->att_logout);
            
            $obj_office_in = New DateTime($this->getOfficeStart());
            $obj_office_out = New DateTime($this->getOfficeStop());

            $o_in = $obj_office_in->format('H');
            $o_out = $obj_office_out->format('H');
            $p_in = $obj_person_in->format('H');
            $p_out = $obj_person_out->format('H');
            
            $diff_sio = $obj_person_in->diff($obj_person_out);    
            $diff_si = $obj_person_in->diff($obj_office_in);        
            $diff_so = $obj_person_out->diff($obj_office_out);
            
            $fsio = $p_out - $p_in;//$diff_sio->format('%H');
            $fsi = $o_in - $p_in; //$diff_si->format('%H');
            $fso = $p_out - $o_out; //$diff_so->format('%H');
                 
            if ($this->shift_office_duration != 5 ){
                $ev = $fsio-($fsi+$fso+1);       
            }else{
                $ev= $fsio-($fsi+$fso);       
            }
        }
        return $ev;
    }

    public function getOverTimeApprove(){      
        return $this->overtime_approve; 
    }

    //Overtime
    public function getOverTime(){
        $spkl= $this->getOverTimeApprove();
              
        if($spkl>0){
            if ($this->shift_dayoff || $this->isDayOffNational){
                if (!empty($this->att_login) || !empty($this->att_logout)){
                    //$obj_office_stop = new DateTime($this->getOfficeStop());
                    $obj_person_in = New DateTime($this->att_login);
                    $obj_person_out = New DateTime($this->att_logout);
                    $diff_ot = $obj_person_in->diff($obj_person_out);
                    $ot = $diff_ot->format('%h');
                    
                }else {
                    $ot =0;
                }
            }
           
            elseif($this->getEffective() > 0) { //$this->shift_office_ev){
                if (!empty($this->att_login) || !empty($this->att_logout)){
                    $obj_office_stop = new DateTime($this->getOfficeStop());
                    $obj_person_out = New DateTime($this->att_logout);
                    $diff_ot = $obj_office_stop->diff($obj_person_out);
                    $ot = $diff_ot->format('%h');
                    //return $ot;
                }else {
                    $ot = 0;
                }
                
            }else {
                $ot = 0;
            }
        }else {
            $ot = 0;
        }

        if ($spkl < $ot){
            $policy_ot = $this->overtime_approve;
        }else {
            $policy_ot = $ot;
        }
        return $policy_ot;
    }

    public function getSalaryOvertime(){
        
        $const_hari = 25;
        $v_gajilembur = ($this->basic * $const_hari)/173;

        if ($this->isDayOffNational OR $this->shift_dayoff) { //Jika Libur Nasional & Libur Mingguan
           
            if ($this->getOverTime()==8){
                //$gaji_ot=3*($this->gaji/7)*$this->getOvertime();
                $gj1=2*($v_gajilembur)*($this->getOvertime()-1);
                $gj2=3*($v_gajilembur)*1;
                $gaji_ot=$gj1+$gj2;
            }
           
            elseif ($this->getOvertime() >=9) {
                $gaji_ot=4*($this->gaji/7)*$this->getOvertime();
                $gj1=2*($v_gajilembur)*7;
                $gj2=3*($v_gajilembur)*1;
                $gj3=4*($v_gajilembur)*($this->getOvertime()-8);
                $gaji_ot=$gj1+$gj2+$gj3;                
            }
            else {
                $gaji_ot=2*($v_gajilembur)*$this->getOvertime();
            }
            
        }elseif($this->att_login ==NULL && $this->att_logout ==NULL){
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
                $gaji_ot=round ($part1+$part2+$part3);
            }else {
                $gaji_ot=0;
            }
        }
        return $gaji_ot;
    }

    public function getTelat(){
        //$att = $this->getAttendance();
        if ($this->shift_dayoff || empty($att['emp_in']) || empty($this->att_logout) || $this->isDayOffNational){
            $telat = "00:00:00";
        }else {
            $obj_p_in = New DateTime($this->att_login);
            $obj_o_in = New DateTime($this->getOfficeStart()); 

            $diff_start = $obj_p_in->diff($obj_o_in);
        
            $late  = $diff_start->format('%R1');
            $late_in = $late < 0 ?True:False;
            if ($late_in) {
                
                $telat =  $diff_start->format('%H:%I:%S');
            }else{
                $telat = '00:00:00';
            }
        }
        
        return  $telat;
    }

    public function getPotonganTelat(){
        
        $basic_hour = $this->basic / $this->shift_office_duration;
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
       
        //return 0;
    }
    /*
    public function isCovid2(){ //potongan 0.25
        $covid = DailyComponentDetil::find()->where(['id_employee'=>$this->id_employee, 'date_component'=>$this->date_now, 'id_daily_component'=>1]);
         return $covid->exists();
    }
    */
    /*public function isCovidOff(){ //potongan 0.80 
        $covid = DailyComponentDetil::find()->where(['id_employee'=>$this->id_employee, 'date_component'=>$this->date_now, 'id_daily_component'=>2]);
         return $covid->exists();
    }*/

    public function getPotonganCovid(){
        $salary = $this->basic + $this->getSalaryOvertime() + $this->getTmasakerja()+ $this->insentif;
        if ($this->isCovid25){
            $potongan = $salary * 0.25;
        }
        elseif($this->isCovid80){
            $potongan = $salary * 0.80;
        }
        else {
            $potongan = 0;
        }
        return $potongan;
    }

    public function getPotonganDirumahkan(){
        $potongan_rumah =0;
        $salary = $this->basic + $this->getSalaryOvertime() + $this->getTmasakerja()+ $this->insentif;
        if ($this->isDirumahkan()){
            if ($this->shift_dayoff || $this->isDayOffNational){
                $potongan_rumah= 0;
            }else{
                $potongan_rumah= $salary * 0.5;
            }
        }       
        return $potongan_rumah;
    }

    public function getBasic(){
        if($this->shift_dayoff){
            return  0;
        }else{
            return $this->basic;
        }
    }
    public function getPotongan(){
        
        $x1 = $this->getPotonganDirumahkan();
        $x2 = $this->getPotonganCovid();
        $x3 = $this->getPotonganTelat();
        return $x1+$x2+$x3;
    }

    public function getDscription(){
        $ket = "";
        if ($this->isDayOffNational){
            $ket .=' #Libur nasional';
        }
        if ($this->shift_dayoff){
            $ket .=' #DayOff';
        }
        if($this->getAnualLeave()){
            $ket .=' #Cuti';
        }
        if($this->getIjin()){
            $ket .=' #Ijin';
        }
        if($this->isSakit()){
            $ket .='#sakit';
        }
        if($this->getIjinKhusus()){
            $ket .= ' #IjinKhusus';
        }
        if ($this->isCovid25){
            $ket .= ' #Covid25%';
        }
        if ($this->isCovid80){
            $ket .= ' #Covid80%';
        }
        if ($this->isDirumahkan()){
            $ket .= ' #Dirumahkan';
        }
        return $ket;
    }

     //Gaji Total per Hari 
     public function getSalaryDay(){
       
        $salary = $this->getBasic() + $this->getSalaryOvertime() + $this->getTmasakerja() 
        + $this->insentif
        - ( $this->getPotonganTelat()+$this->getPotonganCovid() + $this->getPotonganDirumahkan());
        return round($salary);
    }



}
