<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use Yii;

/**
 * This is the model class for table "child_foreman".
 *
 * @property int $id
 * @property string $employee_emp_id
 * @property int $foreman_id
 *
 * @property Employee $employeeEmp
 * @property Foreman $foreman
 */
class ChildForeman extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    use SmartIncrementKeyDb;
    
    public static function tableName()
    {
        return 'child_foreman';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'employee_emp_id', 'foreman_id'], 'required'],
            [['id', 'foreman_id'], 'integer'],
            [['employee_emp_id'], 'string', 'max' => 11],
            [['id'], 'unique'],
            [['employee_emp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['employee_emp_id' => 'emp_id']],
            [['foreman_id'], 'exist', 'skipOnError' => true, 'targetClass' => Foreman::className(), 'targetAttribute' => ['foreman_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employee_emp_id' => 'Employee Emp ID',
            'foreman_id' => 'Foreman ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee::className(), ['emp_id' => 'employee_emp_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForeman()
    {
        return $this->hasOne(Foreman::className(), ['id' => 'foreman_id']);
    }
}
