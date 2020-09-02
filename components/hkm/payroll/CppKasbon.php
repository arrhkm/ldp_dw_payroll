<?php
namespace app\components\hkm\payroll;

use app\models\DetilKasbon;
use app\models\Kasbon;
use app\models\Period;
use yii\base\Component;


class CppKasbon extends Component
{
    public $id_employee;
    public $id_period;
    public $kasbon;
    public function __construct($id_employee, $id_period)
    {
        $this->id_employee = $id_employee;
        $this->id_period = $id_period;
        $this->kasbon = Kasbon::find()->where(['id_employee'=> $this->id_employee, 'is_active'=>TRUE]);
        
        
    }

    public function getKasbon()
    {
        //$kasbon = Kasbon::find()->where(['id_employee'=> $this->id_employee, 'is_active'=>TRUE]);
        if ($this->kasbon->exists()){
            $kasbon = $this->kasbon->one();
            $nilai_kasbon = $kasbon->nilai_kasbon;
        }else {
            $nilai_kasbon = 0;
        }
        return $nilai_kasbon;
    }
    public function getTotalCicilan(){
        if ($this->kasbon->exists()){
            $jml = 0;
            foreach ($this->kasbon->one()->detilKasbons as $dt){
                $jml += $dt->nilai_cicilan;
            }
            return $jml;
        }
        return 0;
    }

    public function getSisaKasbon(){
        if ($this->kasbon->exists()){
            $sisa = $this->getKasbon() - $this->getTotalCicilan();
            return $sisa;
        }
        return 0;
    }

    public function getPotonganKasbon(){
        if ($this->kasbon->exists()){
            $period = Period::find()->where(['id'=>$this->id_period])->one();
            $kasbon = $this->kasbon->one();
            $detil = DetilKasbon::find()->where(['id_kasbon'=>$kasbon->id])->andFilterWhere(['between', 'tgl_cicilan',$period->start_date, $period->end_date])->all();
            $jml=0;
            foreach ($detil as $detils){
                $jml += $detils->nilai_cicilan;
            }
            return $jml;
        }else{
            return 0;
        }
        
    }
    public function getKet(){
        return "#kasbon : {$this->getKasbon()} #sisa kasbon: {$this->getSisaKasbon()}";
    }
}