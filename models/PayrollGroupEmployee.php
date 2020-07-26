<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use Yii;

/**
 * This is the model class for table "payroll_group_employee".
 *
 * @property int $id
 * @property int|null $id_employee
 * @property int|null $id_payroll_group
 *
 * @property Employee $employee
 * @property PayrollGroup $payrollGroup
 */
class PayrollGroupEmployee extends \yii\db\ActiveRecord
{
    use SmartIncrementKeyDb;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payroll_group_employee';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'id_employee', 'id_payroll_group'], 'default', 'value' => null],
            [['id', 'id_employee', 'id_payroll_group'], 'integer'],
            [['id_employee'], 'unique'],
            [['id'], 'unique'],
            [['id_employee'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['id_employee' => 'id']],
            [['id_payroll_group'], 'exist', 'skipOnError' => true, 'targetClass' => PayrollGroup::className(), 'targetAttribute' => ['id_payroll_group' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_employee' => 'Id Employee',
            'id_payroll_group' => 'Id Payroll Group',
        ];
    }

    /**
     * Gets query for [[Employee]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee::className(), ['id' => 'id_employee']);
    }

    /**
     * Gets query for [[PayrollGroup]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPayrollGroup()
    {
        return $this->hasOne(PayrollGroup::className(), ['id' => 'id_payroll_group']);
    }
}
