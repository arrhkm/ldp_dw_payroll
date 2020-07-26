<?php
namespace app\components\hkm;

use app\models\Log;
use app\models\Period;
use app\models\TimeshiftEmployee;

//date_default_timezone_set('UTC');


/**
 * Description of integrasiClass
 *
 * @Hakam itlintech
 */

class IntegrateAttendance {
    public $log = array();
    public $card = array();
    public $date_integration;
    public $id_emp;
    public $start_hour;
    
    public $in;
    public $out;
    
    function __construct($c_log, $c_id_emp, $c_card, $c_date, $start_hour) {
        $this->log=$c_log;
        $this->card = $c_card;
        $this->date_integration=$c_date;
        $this->id_emp=$c_id_emp;
        $this->start_hour = $start_hour;
    }
    public function timestampTodate($datetime){
        return substr($datetime, 0,10);
    }
    public function timeInToDateTime($time_integer){ //merubah time ke dateTime format
        return date("Y-m-d H:i:s", $time_integer);
    }
    public function getLog()
    {
        //Set frame login in 1 day 
        //$card = Attcard::find()->where(['id_employee'=>$this->id_emp])->all();
        $office_start = $this->date_integration." ".$this->start_hour;

        $DayStart = date('Y-m-d H:i:s',strtotime('-3 hours', strtotime($office_start)));



        $punchDate = $this->date_integration;                      
        //$DayStart = $punchDate." 05:00:00";// Batas awal cek IN OUT absensi per emloye per 1 day
        $DayStartTime = strtotime($DayStart);
        $dn = strtotime($DayStart."+1 day");
        $DayNext = $this->timeInToDateTime($dn);
        
        $DayNextTime = strtotime($DayNext);
        $vlog = array();
        $log_emp_day = array();//declare variable
        
        //foreach ($card as $dtcard){
        foreach ($this->card as $dtcard){
            foreach ($this->log as $vlog){
                if (($vlog['pin']==$dtcard['pin'])){ //Jika id log mesin sama dengan id log employee
                    //if ($vlog['id_attmachine']==$dtcard['id_attmachine']){
                        $x = $this->timestampTodate($vlog['timestamp']);// conversi log time ke date                
                        if ($x==$this->date_integration){
                            if (strtotime($vlog['timestamp'])>=$DayStartTime && (strtotime($vlog['timestamp'])< $DayNextTime)){   
                                array_push($log_emp_day, strtotime($vlog['timestamp']));                        
                            }
                        }
                    //}
                    
                }

            }
        }
        
        if (isset($log_emp_day) && count($log_emp_day)>0){
            $this->out = max($log_emp_day);        
            $this->in = min($log_emp_day);
        }else {
            $this->in= '';
            $this->out= '';
        }
        
        //return $log_emp_day;
    }
    
}
