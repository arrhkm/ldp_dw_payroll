<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use Yii;

/**
 * This is the model class for table "payroll_group".
 *
 * @property int $id
 * @property string|null $name
 *
 * @property PayrollGroupEmployee $payrollGroupEmployee
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
            [['id'], 'default', 'value' => null],
            [['id'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['id'], 'unique'],
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
        ];
    }

    /**
     * Gets query for [[PayrollGroupEmployee]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPayrollGroupEmployee()
    {
        return $this->hasOne(PayrollGroupEmployee::className(), ['id_payroll_group' => 'id']);
    }
}
