<?php
namespace app\components;

use app\models\Contract;
use app\models\Employee;
use yii\base\Component;
use yii\helpers\ArrayHelper;

class EmployeeList extends Component{
    static function getEmployeeActive(){
        
        $emp= Employee::find()->where(['is_active'=>TRUE])->with('coreperson')->alias('p')
            ->orderBy(['reg_number'=>SORT_ASC])            
            ->all();               
        $list = ArrayHelper::toArray($emp, [
            'app\models\Employee'=>[
                'id',
                'reg_number',
                'reg_plus'=>function($emp){
                    return $emp->reg_number." - ".$emp->coreperson->name;
                },
            ]
        ]);        
        
        $list_emp = ArrayHelper::map($list, 'id', 'reg_plus');
        return $list_emp;
    
    }
    static function getEmployee(){
        
        $emp= Employee::find()->with('coreperson')->alias('p')
            ->orderBy(['reg_number'=>SORT_ASC])            
            ->all();               
        $list = ArrayHelper::toArray($emp, [
            'app\models\Employee'=>[
                'id',
                'reg_number',
                'reg_plus'=>function($emp){
                    return $emp->reg_number." - ".$emp->coreperson->name;
                },
            ]
        ]);        
        
        $list_emp = ArrayHelper::map($list, 'id', 'reg_plus');
        return $list_emp;
    
    }

    public static function getEmployeeisNotContract(){
        $id_emp = [];
        foreach (Contract::find()->where(['is_active'=>TRUE])->all() as $dt){
            array_push($id_emp, $dt['id_employee']);
        }

        $emp= Employee::find()->with('coreperson')->alias('p')
            ->where(['NOT IN','id', $id_emp])
            ->orderBy(['reg_number'=>SORT_ASC])            
            ->all();               
        $list = ArrayHelper::toArray($emp, [
            'app\models\Employee'=>[
                'id',
                'reg_number',
                'reg_plus'=>function($emp){
                    return $emp->reg_number." - ".$emp->coreperson->name;
                },
            ]
        ]);        
        
        $list_emp = ArrayHelper::map($list, 'id', 'reg_plus');
        return $list_emp;
    } 


}