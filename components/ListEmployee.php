<?php
namespace app\components;

//use Yii;


use app\models\ChildForeman;
use yii\helpers\ArrayHelper;
//use yii\base\Components;
use app\models\Employee;
use app\models\Foreman;
use yii\db\conditions\InCondition;

class ListEmployee  {

    public function getEmpList(){
        $emp = Employee::find()
        
        ->all();
        return ArrayHelper::map($emp, 'emp_id', 'emp_name');
    }

    public function getForeman(){
        $emp = Foreman::find()->joinWith('leader')->all();
        return ArrayHelper::map($emp, 'id', 'leader.emp_name');

    }

    public function getNotEmpRegisteredChildForeman(){
        $child_foreman = ChildForeman::find()->all();
        $empSet = [];
        foreach ($child_foreman as $dt){
            array_push ($empSet, $dt->employee_emp_id);
        }
        $condition = New InCondition('emp_id', 'NOT IN', $empSet);
        $emp = Employee::find()->where($condition)->all();

        return ArrayHelper::map($emp, 'emp_id', 'emp_name');

    }

    public function getNotEmpRegisteredForeman(){
        $child_foreman = Foreman::find()->all();
        $empSet = [];
        foreach ($child_foreman as $dt){
            array_push ($empSet, $dt->leader_id);
        }
        $condition = New InCondition('emp_id', 'NOT IN', $empSet);
        $emp = Employee::find()->where($condition)->all();

        return ArrayHelper::map($emp, 'emp_id', 'emp_name');

    }
    

    


}