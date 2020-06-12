<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use Yii;

/**
 * This is the model class for table "spl".
 *
 * @property int $id
 * @property string $date_spl
 * @property string $start_lembur
 * @property string $end_lembur
 * @property string $so
 * @property string $nama_pekerjaan
 * @property int $overtime_value
 * @property string $satuan
 * @property string $employee_emp_id
 *
 * @property Employee $employeeEmp
 */
class Spl extends \yii\db\ActiveRecord
{
    use SmartIncrementKeyDb;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'spl';
    }

    /**
     * {@inheritdoc}
     */

    const SCENARIOINPUT = 'scenarioinput';
    const SCENARIOCSV = 'scenariocsv';
    
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIOINPUT] = ['id', 'employee_emp_id', 'date_spl', 'so', 'overtime_value'];
        $scenarios[self::SCENARIOCSV] =   ['id', 'employee_emp_id', 'date_spl', 'so', 'overtime_value'];
        return $scenarios;
    }

    public function rules()
    {
        return [
            [['id', 'employee_emp_id', 'date_spl'], 'required'],//, 'on'=>'scenarioinput'],
            [['date_spl', 'employee_emp_id'], 'unique', 'targetAttribute' => ['date_spl', 'employee_emp_id']],//, 'on'=>self::SCENARIOINPUT],
            [['id', 'overtime_value'], 'integer'],
          
            [['date_spl', 'start_lembur', 'end_lembur'], 'safe'],
            [['so', 'nama_pekerjaan'], 'string', 'max' => 255],
            [['employee_emp_id'], 'string', 'max' => 11],
            ['overtime_value', 'validateJamOt'],
           
            [['id'], 'unique'],
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
            'start_lembur' => 'Start Lembur',
            'end_lembur' => 'End Lembur',
            'so' => 'So',
            'nama_pekerjaan' => 'Nama Pekerjaan',
            'overtime_value' => 'Overtime (dalam Jam)',
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

    public function validateJamOt($attribute, $params){
        if ($this->overtime_value > 7 ){
            $this->addError($attribute, 'Jam melebihi Limit Lembur');
        }
    }
    
}
