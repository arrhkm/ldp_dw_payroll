<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use Yii;

/**
 * This is the model class for table "payroll_logic".
 *
 * @property int $id
 * @property string $name
 * @property string|null $dscription
 *
 * @property PayrollGroup[] $payrollGroups
 */
class PayrollLogic extends \yii\db\ActiveRecord
{
    use SmartIncrementKeyDb;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payroll_logic';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['id'], 'default', 'value' => null],
            [['id'], 'integer'],
            [['name', 'dscription'], 'string', 'max' => 100],
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
            'dscription' => 'Dscription',
        ];
    }

    /**
     * Gets query for [[PayrollGroups]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPayrollGroups()
    {
        return $this->hasMany(PayrollGroup::className(), ['id_payroll_logic' => 'id']);
    }
}
