<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use Yii;

/**
 * This is the model class for table "insentif_resiko".
 *
 * @property int $id
 * @property string $value
 * @property string $dscription
 * @property string $date_insentif
 * @property string $employee_emp_id
 *
 * @property Employee $employeeEmp
 */
class InsentifResiko extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    use SmartIncrementKeyDb;
    public static function tableName()
    {
        return 'insentif_resiko';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'employee_emp_id'], 'required'],
            [['id'], 'integer'],
            [['value'], 'number'],
            [['date_insentif'], 'safe'],
            [['date_insentif'], 'unique', 'targetAttribute'=>['date_insentif', 'employee_emp_id']],
            [['dscription'], 'string', 'max' => 45],
            [['employee_emp_id'], 'string', 'max' => 11],
            [['id'], 'unique'],
            [['employee_emp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['employee_emp_id' => 'emp_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Value',
            'dscription' => 'Dscription',
            'date_insentif' => 'Date Insentif',
            'employee_emp_id' => 'Employee Emp ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee::className(), ['emp_id' => 'employee_emp_id']);
    }
}
