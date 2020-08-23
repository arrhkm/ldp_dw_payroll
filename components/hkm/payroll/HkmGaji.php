<?php
namespace components\hkm\payroll;

use app\models\Employee;
use app\models\Period;

class HkmGaji {
    protected $id_employee;
    protected $id_period;

    public function __construct($id_employee, $id_period)
    {
        $this->id_employee = $id_employee;
        $this->id_period = $id_period;
    }

    public function getPeriod(){
        $period = Period::findOne($this->id_period);
        return $period;
    }

    public function getEmployee(){
        $employee = Employee::findOne($this->id_employee);
        return $employee;
    }

    public function getListDay(){
        $period = $this->getPeriod();
        $date1= date_create($period->start_date);//date_create($v_date1);
        $date2 = date_create($period->end_date);//date_create($v_date2);
        $diff = date_diff($date1, $date2);
        $range=$diff->days;
                
        $result_date = array();
        $tgl_ini = date_create($period->start_date);
        for ($i = 0; $i <= $range; $i++) {            
            array_push($result_date, date_format($tgl_ini, 'Y-m-d'));            
            date_add($tgl_ini, date_interval_create_from_date_string("1 days"));            
        }
        return $result_date;
    }

}