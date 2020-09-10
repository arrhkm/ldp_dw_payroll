<?php 
namespace app\models;

use  yii\base\Model;

class ModelFormComponentGroup extends \yii\base\Model
{
    public $id;

    public $id_employee=[];
    public $id_component_payroll;
    public $start_date;
    public $end_date;

    

    public function rules()
    {
        return [
            
            [['id_component_payroll', 'id_employee'], 'default', 'value' => null],
            [['id_component_payroll', 'id_employee'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            [['start_date', 'end_date', 'id_employee'], 'required'],
            //[['id_employee', 'id_component_payroll'], 'unique', 'targetAttribute' => ['id_employee', 'id_component_payroll']],
            //[['id'], 'unique'],
            [['id_component_payroll'], 'exist', 'skipOnError' => true, 'targetClass' => ComponentPayroll::className(), 'targetAttribute' => ['id_component_payroll' => 'id']],
            [['id_employee'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['id_employee' => 'id']],
        ];
    }

    
}