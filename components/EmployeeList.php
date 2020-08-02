<?php
namespace app\components;

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


}