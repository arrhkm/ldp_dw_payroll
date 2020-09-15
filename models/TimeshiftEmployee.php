<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use Yii;

/**
 * This is the model class for table "timeshift_employee".
 *
 * @property int $id
 * @property string|null $date_shift
 * @property int|null $id_period
 * @property int|null $id_employee
 * @property string|null $start_hour
 * @property int|null $duration_hour
 * @property bool|null $is_dayoff
 * @property string|null $class_name_payroll_logic
 *
 * @property Employee $employee
 * @property Period $period
 */
class TimeshiftEmployee extends \yii\db\ActiveRecord
{
    use SmartIncrementKeyDb;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'timeshift_employee';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'id_period', 'id_employee', 'duration_hour'], 'default', 'value' => null],
            [['id', 'id_period', 'id_employee', 'duration_hour'], 'integer'],
            [['date_shift', 'start_hour'], 'safe'],
            [['is_dayoff'], 'boolean'],
            [['class_name_payroll_logic'], 'string', 'max' => 100],
            [['id'], 'unique'],
            [['id_employee'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['id_employee' => 'id']],
            [['id_period'], 'exist', 'skipOnError' => true, 'targetClass' => Period::className(), 'targetAttribute' => ['id_period' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_shift' => 'Date Shift',
            'id_period' => 'Id Period',
            'id_employee' => 'Id Employee',
            'start_hour' => 'Start Hour',
            'duration_hour' => 'Duration Hour',
            'is_dayoff' => 'Is Dayoff',
            'class_name_payroll_logic' => 'Class Name Payroll Logic',
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
     * Gets query for [[Period]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPeriod()
    {
        return $this->hasOne(Period::className(), ['id' => 'id_period']);
    }
}
