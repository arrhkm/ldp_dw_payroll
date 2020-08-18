<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use Yii;

/**
 * This is the model class for table "component_group".
 *
 * @property int $id
 * @property int|null $id_component_payroll
 * @property int|null $id_employee
 *
 * @property ComponentPayroll $componentPayroll
 * @property Employee $employee
 */
class ComponentGroup extends \yii\db\ActiveRecord
{
    use SmartIncrementKeyDb;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'component_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'id_component_payroll', 'id_employee'], 'default', 'value' => null],
            [['id', 'id_component_payroll', 'id_employee'], 'integer'],
            [['id'], 'unique'],
            [['id_component_payroll'], 'exist', 'skipOnError' => true, 'targetClass' => ComponentPayroll::className(), 'targetAttribute' => ['id_component_payroll' => 'id']],
            [['id_employee'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['id_employee' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_component_payroll' => 'Id Component Payroll',
            'id_employee' => 'Id Employee',
        ];
    }

    /**
     * Gets query for [[ComponentPayroll]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComponentPayroll()
    {
        return $this->hasOne(ComponentPayroll::className(), ['id' => 'id_component_payroll']);
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
}
