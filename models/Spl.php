<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use Yii;

/**
 * This is the model class for table "spl".
 *
 * @property int $id
 * @property string $date_spl
 * @property int $overtime_value
 * @property string $start_lembur
 * @property string $end_lembur
 * @property string $so
 * @property string $nama_pekerjaan
 * @property string $employee_emp_id
 *
 * @property Employee $employeeEmp
 * @property SplDetil[] $splDetils
 */
class Spl extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    use SmartIncrementKeyDb;
    public static function tableName()
    {
        return 'spl';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'employee_emp_id', 'date_spl'], 'required'],//, 'on'=>'scenarioinput'],
            [['id', 'overtime_value'], 'integer'],
            [['date_spl', 'employee_emp_id'], 'unique', 'targetAttribute' => ['date_spl', 'employee_emp_id']],
            [['date_spl', 'start_lembur', 'end_lembur'], 'safe'],
            [['so'], 'string', 'max' => 45],
            [['nama_pekerjaan'], 'string', 'max' => 255],
            [['employee_emp_id'], 'string', 'max' => 11],
            [['id'], 'unique'],
            ['overtime_value', 'validateJamOt'],
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
            'date_spl' => 'Date Spl',
            'overtime_value' => 'Overtime Value',
            'start_lembur' => 'Start Lembur',
            'end_lembur' => 'End Lembur',
            'so' => 'So',
            'nama_pekerjaan' => 'Nama Pekerjaan',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSplDetils()
    {
        return $this->hasMany(SplDetil::className(), ['spl_id' => 'id']);
    }

    public function validateJamOt($attribute, $params){
        if ($this->overtime_value > 7 ){
            $this->addError($attribute, 'Jam melebihi Limit Lembur');
        }
    }

    public function getEmpty(){     
        if ( count($this->splDetils) > 0) {
            return FALSE;
        }
        return TRUE;
    }
}
