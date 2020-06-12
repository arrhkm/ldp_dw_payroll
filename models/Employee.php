<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "employee".
 *
 * @property string $emp_id
 * @property string $emp_name
 * @property string $no_rekening
 * @property int $kd_jabatan
 * @property string $gaji_pokok
 * @property string $gaji_lembur
 * @property string $pot_jamsos
 * @property string $t_jabatan
 * @property string $t_masakerja
 * @property string $t_insentif
 * @property string $pot_telat
 * @property string $uang_makan
 * @property string $start_work
 * @property string $start_contract
 * @property string $end_contract
 * @property int $lama_contract
 * @property string $emp_group
 *
 * @property Forman[] $formen
 * @property Formanhasemployee[] $formanhasemployees
 * @property Forman[] $formen0
 * @property IkutProject[] $ikutProjects
 * @property Project[] $kdProjects
 * @property InsentifResiko[] $insentifResikos
 * @property JmHasEmployee[] $jmHasEmployees
 */
class Employee extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['emp_id', 'emp_name', 'no_rekening', 'kd_jabatan', 'gaji_pokok', 'gaji_lembur', 'pot_jamsos', 't_jabatan', 't_masakerja', 't_insentif', 'pot_telat', 'uang_makan', 'start_work', 'emp_group'], 'required'],
            [['kd_jabatan', 'lama_contract'], 'integer'],
            [['gaji_pokok', 'gaji_lembur', 'pot_jamsos', 't_jabatan', 't_masakerja', 't_insentif', 'pot_telat', 'uang_makan'], 'number'],
            [['start_work', 'start_contract', 'end_contract'], 'safe'],
            [['emp_id'], 'string', 'max' => 11],
            [['emp_name'], 'string', 'max' => 32],
            [['no_rekening'], 'string', 'max' => 15],
            [['emp_group'], 'string', 'max' => 10],
            [['emp_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'emp_id' => 'Emp ID',
            'emp_name' => 'Emp Name',
            'no_rekening' => 'No Rekening',
            'kd_jabatan' => 'Kd Jabatan',
            'gaji_pokok' => 'Gaji Pokok',
            'gaji_lembur' => 'Gaji Lembur',
            'pot_jamsos' => 'Pot Jamsos',
            't_jabatan' => 'T Jabatan',
            't_masakerja' => 'T Masakerja',
            't_insentif' => 'T Insentif',
            'pot_telat' => 'Pot Telat',
            'uang_makan' => 'Uang Makan',
            'start_work' => 'Start Work',
            'start_contract' => 'Start Contract',
            'end_contract' => 'End Contract',
            'lama_contract' => 'Lama Contract',
            'emp_group' => 'Emp Group',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormen()
    {
        return $this->hasMany(Forman::className(), ['emp_id' => 'emp_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormanhasemployees()
    {
        return $this->hasMany(Formanhasemployee::className(), ['emp_id' => 'emp_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormen0()
    {
        return $this->hasMany(Forman::className(), ['id' => 'forman_id'])->viaTable('formanhasemployee', ['emp_id' => 'emp_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIkutProjects()
    {
        return $this->hasMany(IkutProject::className(), ['emp_id' => 'emp_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKdProjects()
    {
        return $this->hasMany(Project::className(), ['kd_project' => 'kd_project'])->viaTable('ikut_project', ['emp_id' => 'emp_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInsentifResikos()
    {
        return $this->hasMany(InsentifResiko::className(), ['employee_emp_id' => 'emp_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJmHasEmployees()
    {
        return $this->hasMany(JmHasEmployee::className(), ['employee_emp_id' => 'emp_id']);
    }
}
