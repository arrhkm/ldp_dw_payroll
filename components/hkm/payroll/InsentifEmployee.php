<?php
namespace app\components\hkm\payroll;

use app\models\Insentif;
use yii\base\Component;
use yii\db\Query;

class InsentifEmployee extends Component
{
    public static function getInsentif($id_employee, $date_insentif){
        $query = Insentif::find()->joinWith(['insentifMaster']);
        //$query->select(['id_employee', 'sum'=>'insentifMaster.value as jml']);
        $query->where([
            'id_employee'=>$id_employee,
            'date_insentif'=>$date_insentif,
        ]);
        //$query->groupBy('id_employee', 'date_insentif');
        $hasil = $query->all();
        $nilai =0;
        foreach ($hasil as $hasils){
            $nilai = $nilai + $hasils->insentifMaster->value;
        }
        return $nilai;

    }

    public static function getKet($id_employee, $date_start, $date_end){

        $query = New Query();
        $query->select(["count(id_insentif_master) as total", 'b.name']);
        $query->from('insentif a');
        $query->join('LEFT JOIN', 'insentif_master b', 'b.id = a.id_insentif_master');
        $query->where(['between', 'a.date_insentif', $date_start, $date_end]);
        $query->andWhere(['a.id_employee'=>$id_employee]);
        $query->groupBy(['a.id_insentif_master', 'b.name']);
        
        $nilai = "";

        foreach ($query->all() as $hasils){
            $nilai .= "{$hasils['name']} ({$hasils['total']}), ";
        }
        return $nilai;
        

    }

}
