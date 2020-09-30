<?php 
namespace app\components\hkm\payroll;

use app\models\AdjustmentSalary;
use app\models\Period;


class CppAdjustment {
   public $id_period, $id_employee;

   public function __construct($id_period, $id_employee)
   {
      $this->id_period = $id_period;
      $this->id_employee = $id_employee;
      
   }

   public function getPeriod(){
      $period = Period::findOne($this->id_period);
      return $period;
   }

   public function getKredit(){
      $period = Period::findOne($this->id_period);
      $kredit = AdjustmentSalary::find()
      ->select(['value'=>'SUM({{value_adjustment}})'])
      ->where(['between','date_adjustment',$period->start_date, $period->end_date])
      ->andWhere(['id_employee'=>$this->id_employee, 'code_adjustment'=>'K'])
      ->groupBy(['id_employee'])->asArray()->one();

     
      return isset($kredit['value'])?$kredit['value']:0;
   }
   public function getDebet(){
      $period = Period::findOne($this->id_period);
      $debet = AdjustmentSalary::find()
      ->select(['value'=>'SUM({{value_adjustment}})'])
      ->where(['between','date_adjustment',$period->start_date, $period->end_date])
      ->andWhere(['id_employee'=>$this->id_employee, 'code_adjustment'=>'D'])
      ->groupBy(['id_employee'])->asArray()->one();

      return isset($debet['value'])?$debet['value']:0;
   }

}