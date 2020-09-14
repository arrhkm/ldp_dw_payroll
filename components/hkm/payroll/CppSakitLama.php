<?php 
namespace app\components\hkm\payroll;

class CppSakitLama 
{
   public $date_start, $date_now, $basic;
   public function __construct($date_start, $date_now, $basic)
   {
      $this->date_start = date_create($date_start);
      $this->date_now = date_create($date_now);
      $this->basic = $basic;
   }
   public function getLamaBulan(){   
      $diff = date_diff($this->date_now, $this->date_start);       
      //$tahun_kerja = $diff->format('%R%y');
      $lama_bulan = $diff->format('%y-%m');
      $x = explode('-', $lama_bulan);
      
      return ($x[0]*12) + $x[1]; 
   }

   public function getBasic(){
      /*- 4 bulan sejak sakit = 100%;
      - 4 bulan ke2 = 75%;
      - 4 bulan ke3 = 50%
      -  bulan ke4 = 25%;
      */
      if ($this->getLamaBulan()>=4 AND $this->getLamaBulan() <8){
         $basic_basic = $this->basic *0.75;
      }elseif($this->getLamaBulan()>=8 AND $this->getLamaBulan() < 16){
         $basic_basic = $this->basic*0.5;
      }
      elseif($this->getLamaBulan()>=8 AND $this->getLamaBulan() < 16){
         $basic_basic = $this->basic*0.25;
      }
      elseif ($this->getLamaBulan()>=16){
         $basic_basic = 0;
      }
      else {
         $basic_basic = $this->basic;
      }
      return $basic_basic;
   }


}