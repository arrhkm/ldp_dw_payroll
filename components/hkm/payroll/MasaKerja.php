<?php 
namespace app\components\hkm\payroll;

use yii\base\Component;


class  MasaKerja extends Component{
    public $n;
    //public function __construct($n){
        //$this->n = $n;
    //}
    
    static function getMasakerja($doh){
        $today = date_create(date('Y-m-d'));
        $obj_doh = date_create($doh);
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
} 
