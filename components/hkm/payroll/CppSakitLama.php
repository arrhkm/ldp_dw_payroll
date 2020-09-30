<?php 
namespace app\components\hkm\payroll;

use DateInterval;

class CppSakitLama 
{
   public 
      $date_start, 
      $date_now, 
      $basic,
      $t_start
      ;

   public function __construct($date_start, $date_now, $basic)
   {
      $this->date_start = date_create($date_start);
      $this->date_now = date_create($date_now);
      $this->basic = $basic;
      $this->t_start = $date_start;
   }
   public function getLamaBulan(){   
      $diff = $this->date_start->diff($this->date_now);       
      //$tahun_kerja = $diff->format('%R%y');
      $lama_bulan = ($diff->format('%y')*12) + ($diff->format('%m'));
      //$x = explode('-', $lama_bulan);
      
      return $lama_bulan;//($x[0]*12) + $x[1]; 
   }

   public function getBasic(){
      /*- 4 bulan sejak sakit = 100%;
      - 4 bulan ke2 = 75%;
      - 4 bulan ke3 = 50%
      -  bulan ke4 = 25%;
      */
      if ($this->getLamaBulan()>=4 AND $this->getLamaBulan() <8){
         $basic_basic = $this->basic *0.75;
      }elseif($this->getLamaBulan()>=8 AND $this->getLamaBulan() < 15){
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