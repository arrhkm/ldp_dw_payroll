<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use Yii;

/**
 * This is the model class for table "payroll".
 *
 * @property int $id
 * @property string|null $reg_number
 * @property string|null $payroll_name
 * @property float|null $tg_all
 * @property float|null $t_msker
 * @property float|null $i_um
 * @property float|null $i_tidak_tetap
 * @property float|null $cicilan_kasbon
 * @property float|null $pot_safety
 * @property float|null $pengurangan
 * @property float|null $penambahan
 * @property int|null $id_payroll_group
 * @property int|null $id_period
 * @property int|null $no_rekening
 * @property int|null $id_employee
 * @property int|null $wt
 * @property int|null $pt
 * @property string|null $jabatan
 * @property float|null $pot_bpjs_kes
 * @property string|null $employee_name
 * @property float|null $grand_total_salary
 * @property string|null $dscription_kasbon
 * @property float|null $basic_salary
 *
 * @property Employee $employee
 * @property Period $period
 */
class Payroll extends \yii\db\ActiveRecord
{
    use SmartIncrementKeyDb;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payroll';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'id_payroll_group', 'id_period', 'no_rekening', 'id_employee', 'wt', 'pt'], 'default', 'value' => null],
            [['id', 'id_payroll_group', 'id_period', 'no_rekening', 'id_employee', 'wt', 'pt'], 'integer'],
            [['tg_all', 't_msker', 'i_um', 'i_tidak_tetap', 'cicilan_kasbon', 'pot_safety', 'pengurangan', 'penambahan', 'pot_bpjs_kes', 'grand_total_salary', 'basic_salary'], 'number'],
            [['reg_number'], 'string', 'max' => 20],
            [['payroll_name', 'jabatan', 'employee_name'], 'string', 'max' => 50],
            [['dscription_kasbon'], 'string', 'max' => 100],
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
            'reg_number' => 'Reg Number',
            'payroll_name' => 'Payroll Name',
            'tg_all' => 'Tg All',
            't_msker' => 'T Msker',
            'i_um' => 'I Um',
            'i_tidak_tetap' => 'I Tidak Tetap',
            'cicilan_kasbon' => 'Cicilan Kasbon',
            'pot_safety' => 'Pot Safety',
            'pengurangan' => 'Pengurangan',
            'penambahan' => 'Penambahan',
            'id_payroll_group' => 'Id Payroll Group',
            'id_period' => 'Id Period',
            'no_rekening' => 'No Rekening',
            'id_employee' => 'Id Employee',
            'wt' => 'Wt',
            'pt' => 'Pt',
            'jabatan' => 'Jabatan',
            'pot_bpjs_kes' => 'Pot Bpjs Kes',
            'employee_name' => 'Employee Name',
            'grand_total_salary' => 'Grand Total Salary',
            'dscription_kasbon' => 'Dscription Kasbon',
            'basic_salary' => 'Basic Salary',
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

    public function getPayrollGroup()
    {
        return $this->hasOne(PayrollGroup::className(), ['id' => 'id_payroll_group']);
    }

    public static function getTotal($provider, $fieldName)
    {
        $total = 0;

        foreach ($provider as $item) {
            $total += $item[$fieldName];
        }

        return $total;
    }
}
