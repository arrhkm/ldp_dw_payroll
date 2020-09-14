<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use Yii;

/**
 * This is the model class for table "payroll_group".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $id_payroll_logic
 *
 * @property PayrollLogic $payrollLogic
 * @property PayrollGroupEmployee[] $payrollGroupEmployees
 */
class PayrollGroup extends \yii\db\ActiveRecord
{
    use SmartIncrementKeyDb;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payroll_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'id_payroll_logic'], 'default', 'value' => null],
            [['id', 'id_payroll_logic'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['id'], 'unique'],
            [['id_payroll_logic'], 'exist', 'skipOnError' => true, 'targetClass' => PayrollLogic::className(), 'targetAttribute' => ['id_payroll_logic' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'id_payroll_logic' => 'Id Payroll Logic',
        ];
    }

    /**
     * Gets query for [[PayrollLogic]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPayrollLogic()
    {
        return $this->hasOne(PayrollLogic::className(), ['id' => 'id_payroll_logic']);
    }

    /**
     * Gets query for [[PayrollGroupEmployees]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPayrollGroupEmployees()
    {
        return $this->hasMany(PayrollGroupEmployee::className(), ['id_payroll_group' => 'id']);
    }
}
