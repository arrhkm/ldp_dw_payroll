<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use Yii;

/**
 * This is the model class for table "adjustment_salary".
 *
 * @property int $id
 * @property string|null $date_adjustment
 * @property float|null $value_adjustment
 * @property string|null $code_adjustment
 * @property string|null $description
 * @property int|null $id_employee
 *
 * @property Employee $employee
 */
class AdjustmentSalary extends \yii\db\ActiveRecord
{
    use SmartIncrementKeyDb;
    public $period_id;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'adjustment_salary';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'id_employee'], 'default', 'value' => null],
            [['id', 'id_employee'], 'integer'],
            [['date_adjustment'], 'safe'],
            [['value_adjustment'], 'number'],
            [['code_adjustment'], 'string', 'max' => 1],
            [['description'], 'string', 'max' => 100],
            [['id'], 'unique'],
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
            'date_adjustment' => 'Date Adjustment',
            'value_adjustment' => 'Value Adjustment',
            'code_adjustment' => 'Code Adjustment',
            'description' => 'Description',
            'id_employee' => 'Id Employee',
            'period_id'=>'Period',
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
}
