<?php

namespace app\components\hkm\payroll;


use app\components\hkm\payroll\GajiHarian;

class CetakPayroll {

    public $data=[];
    /*public $id_employee,$reg_number, $date_now, $name_day, $emp_in, $emp_out, 
        $ev, $ot, $telat, $basic, $tmasakerja, $ot_salary, $insentif, $pot_telat,
        $pot_covid1, $pot_covid2, $salary_day;
    */
    public function tambahData(GajiHarian $gaji){
        $this->data[] = $gaji;
    }

    public function getSalaryPeriod(){
        $sal = 0;
        $pt=0;
        $ot=0;
        $wt=0;

        foreach ($this->data as $dt){
            $sal+= $dt->getSalaryDay();
            $wt+= $dt->getEffective();
            $ot+= $dt->getOverTime();
            //$pt+= ($wt+$ot);
        }
        return ['wt'=>$wt, 'pt'=>$wt+$ot, 'sal'=>$sal];
    }
    
}