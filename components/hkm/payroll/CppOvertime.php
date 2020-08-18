<?php
namespace app\components\hkm\payroll;
use app\models\Spkl;

class CppOvertime 
{
    public $id_employee;
    public $date_now;
    
    
    public $spkl_real_duration;

    public function __construct($id_employee, $date_now){
        //$this->spkl = Spkl::find()->where(['date_spkl'=>$date_now, 'id_employee'=>$id_employee]);
        $this->id_employee = $id_employee;
        $this->date_now = $date_now;
        //$this->spkl_real_duration = $spkl_real_duration;
        //$this->logika = $logika;
    }

    public function isOvertime(){
        $spkl = Spkl::find()->where(['date_spkl'=>$this->date_now, 'id_employee'=>$this->id_employee]);
        if ($spkl->exists()){
            return TRUE;
        }else {
            return FALSE;
        }
    }
    public function getSpklOfficeDuration(){
        if ($this->isOvertime()){
            $spkl = Spkl::find()->where(['date_spkl'=>$this->date_now, 'id_employee'=>$this->id_employee])->one();
            return $spkl->overtime_hour;
        }
    }

    /*public function getPolicySpklDuration(){
        if ($this->isOvertime()){
            if ($this->getPolicySpklDuration()< $this->spkl_real_duration){
                $duration = $this->getPolicySpklDuration();
            }else{
                $duration = $this->spkl_real_duration;
            }
            return $duration;
        }else {
            return 0;
        }
    }*/

    /*public function getGajipengaliLembur(){
        $jml_hari = 25;
        $emp = Employee::findOne($this->id_employee);
        $gaji_perhari = $emp->basic_salary;

        $rumus = ($gaji_perhari * $jml_hari) / 173;
        return $rumus;
    }*/

    /*public function getSalaryOvertime(){
        $v_gajilembur = $this->getGajipengaliLembur();
        $ot = $this->getPolicySpklDuration();
        
        if ($this->logika=="libur" OR $this->logika=="minggu") {		
			if ($ot==8){				
				$gj1=2*($v_gajilembur)*($ot-1);
				$gj2=3*($v_gajilembur)*1;
				$gaji_ot=$gj1+$gj2;
			}
			elseif ($ot >=9) {
				
				$gj1=2*($v_gajilembur)*7;
				$gj2=3*($v_gajilembur)*1;
				$gj3=4*($v_gajilembur)*($ot-8);
				$gaji_ot=$gj1+$gj2+$gj3;
				
			}
			else {
				$gaji_ot=2*($v_gajilembur)*$ot;
			}
			
		} else {
			if ($ot<=9 AND $ot>0){
				$part1=1.5*($v_gajilembur);
				$part2=2*($ot -1)*($v_gajilembur);
				$gaji_ot=$part1+$part2;
			}
			elseif ($ot>9){
				$part1=1.5*($v_gajilembur);
				$part2=2*8*($v_gajilembur);
				$part3=3*($ot-9)*($v_gajilembur);
				$gaji_ot=$part1+$part2+$part3;
			}else {
				$gaji_ot=0;
			}
        }
        return $gaji_ot;	
    }*/

    
}