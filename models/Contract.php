<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use Yii;

/**
 * This is the model class for table "contract".
 *
 * @property int $id
 * @property string|null $start_contract
 * @property int|null $duration_contract
 * @property int|null $id_contract_type
 * @property int|null $id_employee
 * @property int|null $id_department
 * @property int|null $id_job_alocation
 * @property int|null $id_jobtitle
 * @property int|null $id_jobrole
 * @property int|null $id_division
 * @property string|null $number_contract
 * @property float|null $basic_salary
 * @property string|null $doh
 * @property bool|null $is_active
 *
 * @property ContractType $contractType
 * @property Department $department
 * @property Division $division
 * @property Employee $employee
 * @property JobAlocation $jobAlocation
 * @property Jobrole $jobrole
 * @property Jobtitle $jobtitle
 */
class Contract extends \yii\db\ActiveRecord
{
    use SmartIncrementKeyDb;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contract';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'duration_contract', 'id_contract_type', 'id_employee', 'id_department', 'id_job_alocation', 'id_jobtitle', 'id_jobrole', 'id_division'], 'default', 'value' => null],
            [['id', 'duration_contract', 'id_contract_type', 'id_employee', 'id_department', 'id_job_alocation', 'id_jobtitle', 'id_jobrole', 'id_division'], 'integer'],
            [['start_contract', 'doh'], 'safe'],
            [['basic_salary'], 'number'],
            [['is_active'], 'boolean'],
            [['number_contract'], 'string', 'max' => 100],
            [['id_employee'], 'unique'],
            [['id'], 'unique'],
            [['id_contract_type'], 'exist', 'skipOnError' => true, 'targetClass' => ContractType::className(), 'targetAttribute' => ['id_contract_type' => 'id']],
            [['id_department'], 'exist', 'skipOnError' => true, 'targetClass' => Department::className(), 'targetAttribute' => ['id_department' => 'id']],
            [['id_division'], 'exist', 'skipOnError' => true, 'targetClass' => Division::className(), 'targetAttribute' => ['id_division' => 'id']],
            [['id_employee'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['id_employee' => 'id']],
            [['id_job_alocation'], 'exist', 'skipOnError' => true, 'targetClass' => JobAlocation::className(), 'targetAttribute' => ['id_job_alocation' => 'id']],
            [['id_jobrole'], 'exist', 'skipOnError' => true, 'targetClass' => Jobrole::className(), 'targetAttribute' => ['id_jobrole' => 'id']],
            [['id_jobtitle'], 'exist', 'skipOnError' => true, 'targetClass' => Jobtitle::className(), 'targetAttribute' => ['id_jobtitle' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'start_contract' => 'Start Contract',
            'duration_contract' => 'Duration Contract',
            'id_contract_type' => 'Id Contract Type',
            'id_employee' => 'Id Employee',
            'id_department' => 'Id Department',
            'id_job_alocation' => 'Id Job Alocation',
            'id_jobtitle' => 'Id Jobtitle',
            'id_jobrole' => 'Id Jobrole',
            'id_division' => 'Id Division',
            'number_contract' => 'Number Contract',
            'basic_salary' => 'Basic Salary',
            'doh' => 'Doh',
            'is_active' => 'Is Active',
        ];
    }

    /**
     * Gets query for [[ContractType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContractType()
    {
        return $this->hasOne(ContractType::className(), ['id' => 'id_contract_type']);
    }

    /**
     * Gets query for [[Department]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Department::className(), ['id' => 'id_department']);
    }

    /**
     * Gets query for [[Division]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDivision()
    {
        return $this->hasOne(Division::className(), ['id' => 'id_division']);
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
     * Gets query for [[JobAlocation]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJobAlocation()
    {
        return $this->hasOne(JobAlocation::className(), ['id' => 'id_job_alocation']);
    }

    /**
     * Gets query for [[Jobrole]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJobrole()
    {
        return $this->hasOne(Jobrole::className(), ['id' => 'id_jobrole']);
    }

    /**
     * Gets query for [[Jobtitle]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJobtitle()
    {
        return $this->hasOne(Jobtitle::className(), ['id' => 'id_jobtitle']);
    }
}
