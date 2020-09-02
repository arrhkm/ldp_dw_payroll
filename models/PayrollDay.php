<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use Yii;

/**
 * This is the model class for table "payroll_day".
 *
 * @property int $id
 * @property string|null $date_payroll
 * @property float|null $basic_per_hour
 * @property int|null $ev_hour
 * @property int|null $ot_hour
 * @property float|null $basic_salary
 * @property float|null $overtime_salary
 * @property float|null $uang_makan
 * @property float|null $pot_telat
 * @property float|null $pot_safety
 * @property float|null $insentif
 * @property float|null $t_masakerja
 * @property float|null $total_gaji
 * @property string|null $logika_day
 * @property string|null $description_leave
 * @property int|null $id_employee
 * @property int|null $id_period
 * @property int|null $id_payroll_group
 * @property string|null $name_day
 * @property float|null $potongan
 * @property string|null $description
 * @property string|null $punch_in
 * @property string|null $punch_out
 *
 * @property Employee $employee
 * @property Period $period
 */
class PayrollDay extends \yii\db\ActiveRecord
{
    use SmartIncrementKeyDb;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payroll_day';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'ev_hour', 'ot_hour', 'id_employee', 'id_period', 'id_payroll_group'], 'default', 'value' => null],
            [['id', 'ev_hour', 'ot_hour', 'id_employee', 'id_period', 'id_payroll_group'], 'integer'],
            [['date_payroll', 'punch_in', 'punch_out'], 'safe'],
            [['basic_per_hour', 'basic_salary', 'overtime_salary', 'uang_makan', 'pot_telat', 'pot_safety', 'insentif', 't_masakerja', 'total_gaji', 'potongan'], 'number'],
            [['logika_day', 'description_leave'], 'string', 'max' => 50],
            [['name_day'], 'string', 'max' => 20],
            [['description'], 'string', 'max' => 100],
            [['id_employee', 'date_payroll'], 'unique', 'targetAttribute' => ['id_employee', 'date_payroll']],
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
            'date_payroll' => 'Date Payroll',
            'basic_per_hour' => 'Basic Per Hour',
            'ev_hour' => 'Ev Hour',
            'ot_hour' => 'Ot Hour',
            'basic_salary' => 'Basic Salary',
            'overtime_salary' => 'Overtime Salary',
            'uang_makan' => 'Uang Makan',
            'pot_telat' => 'Pot Telat',
            'pot_safety' => 'Pot Safety',
            'insentif' => 'Insentif',
            't_masakerja' => 'T Masakerja',
            'total_gaji' => 'Total Gaji',
            'logika_day' => 'Logika Day',
            'description_leave' => 'Description Leave',
            'id_employee' => 'Id Employee',
            'id_period' => 'Id Period',
            'id_payroll_group' => 'Id Payroll Group',
            'name_day' => 'Name Day',
            'potongan' => 'Potongan',
            'description' => 'Description',
            'punch_in' => 'Punch In',
            'punch_out' => 'Punch Out',
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
