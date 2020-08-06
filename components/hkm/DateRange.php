<?php
namespace app\components\hkm;

use yii\base\Component;

/**
 * Description of DateRange
 *
 * @author M. Arraf Hakam
 */
Class DateRange extends Component{
  
    
    public static function getListDay($v_date1, $v_date2){
        $date1= date_create($v_date1);
        $date2 = date_create($v_date2);
        $diff = date_diff($date1, $date2);
        $range=$diff->days;
                
        $result_date = array();
        $tgl_ini = date_create($v_date1);
        for ($i = 0; $i <= $range; $i++) {            
            array_push($result_date, date_format($tgl_ini, 'Y-m-d'));            
            date_add($tgl_ini, date_interval_create_from_date_string("1 days"));            
        }
        return $result_date;
        
        
    }

    /*
    public static function getListDayActive($v_date1, $v_date2){
        $date1= date_create($v_date1);
        $date2 = date_create($v_date2);
        $diff = date_diff($date1, $date2);
        $range=$diff->days;
                
        $result_date = array();
        $tgl_ini = date_create($v_date1);
        for ($i = 0; $i <= $range; $i++) {
            $_tgl_ini = date_format($tgl_ini, 'Y-m-d');
            $days = \common\models\Dayoff::find()->where(['IN', 'date_dayoff', $_tgl_ini]);
            if (! $days->exists()){
                $num_day = date("N", strtotime($_tgl_ini));
                if ($num_day < 6){
                    array_push($result_date, $_tgl_ini);
                }     
            }
                                  
            date_add($tgl_ini, date_interval_create_from_date_string("1 days"));            
        }
        
        return $result_date;
        
        
    }  */  
    
    public static function getDateInterval($intervalDate){
        $tgl_ini = date('Y-m-d');
        $date = date_create($tgl_ini);
        $date_prev = date_add($date, date_interval_create_from_date_string("-".$intervalDate." days"));
        return date_format($date_prev, 'Y-m-d');
    }
    
    public static function getRangeValueFromNow($date_param){
        $date_now = date_create(date('Y-m-d'));
        $date_target = date_create($date_param);
        $diff = date_diff($date_now, $date_target);       
        return $diff->format('%R%a');        
    }
   
    public static function getRange2Date($start, $end)
    {
        $date_start = date_create($start);
        $date_end = date_create($end);
        $diff = date_diff($date_start, $date_end);        
        return $diff->format('%R%a');
    }
    
}