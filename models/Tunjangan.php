<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use Yii;

/**
 * This is the model class for table "tunjangan".
 *
 * @property int $id
 * @property string $tanggal

 * @property string $employee_emp_id
 * @property int $jenis_tunjangan_id
 *
 * @property Employee $employeeEmp
 * @property JenisTunjangan $jenisTunjangan
 */
class Tunjangan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    use SmartIncrementKeyDb;
    
    public static function tableName()
    {
        return 'tunjangan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'employee_emp_id', 'jenis_tunjangan_id'], 'required'],
            [['id', 'jenis_tunjangan_id'], 'integer'],
            [['tanggal'], 'safe'],
           
            [['employee_emp_id'], 'string', 'max' => 11],
            [['tanggal', 'employee_emp_id', 'jenis_tunjangan_id'], 'unique', 'targetAttribute' => ['tanggal', 'employee_emp_id', 'jenis_tunjangan_id']],
            [['id'], 'unique'],
            [['employee_emp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['employee_emp_id' => 'emp_id']],
            [['jenis_tunjangan_id'], 'exist', 'skipOnError' => true, 'targetClass' => JenisTunjangan::className(), 'targetAttribute' => ['jenis_tunjangan_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tanggal' => 'Tanggal',
           
            'employee_emp_id' => 'Employee Emp ID',
            'jenis_tunjangan_id' => 'Jenis Tunjangan ID',
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
    public function getJenisTunjangan()
    {
        return $this->hasOne(JenisTunjangan::className(), ['id' => 'jenis_tunjangan_id']);
    }
}
