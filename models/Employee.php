<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use Yii;

/**
 * This is the model class for table "employee".
 *
 * @property int $id
 * @property string $reg_number
 * @property string|null $no_bpjstk
 * @property string|null $no_bpjskes
 * @property string|null $date_of_hired
 * @property string|null $type
 * @property bool|null $is_permanent
 * @property int|null $id_jobtitle
 * @property int|null $id_division
 * @property int|null $id_jobrole
 * @property int|null $id_department
 * @property int|null $id_coreperson
 * @property string|null $email
 * @property int|null $id_location
 * @property bool|null $is_active
 * @property int|null $id_job_alocation
 * @property string|null $name
 * @property float|null $basic_salary
 *
 * @property Attendance[] $attendances
 * @property Cardlog $cardlog
 * @property Contract $contract
 * @property ContractHistories[] $contractHistories
 * @property Coreperson $coreperson
 * @property Division $division
 * @property JobAlocation $jobAlocation
 * @property Jobrole $jobrole
 * @property Jobtitle $jobtitle
 * @property Location $location
 * @property EmployeeDepartement $employeeDepartement
 * @property MandorEmployee $mandorEmployee
 * @property MandorLeader $mandorLeader
 * @property TimeshiftEmployee[] $timeshiftEmployees
 * @property TimeshiftOption[] $timeshiftOptions
 */
class Employee extends \yii\db\ActiveRecord
{
    use SmartIncrementKeyDb;
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
            [['reg_number'], 'required'],
            [['date_of_hired'], 'safe'],
            [['is_permanent', 'is_active'], 'boolean'],
            [['id_jobtitle', 'id_division', 'id_jobrole', 'id_department', 'id_coreperson', 'id_location', 'id_job_alocation'], 'default', 'value' => null],
            [['id_jobtitle', 'id_division', 'id_jobrole', 'id_department', 'id_coreperson', 'id_location', 'id_job_alocation'], 'integer'],
            [['basic_salary'], 'number'],
            [['reg_number'], 'string', 'max' => 25],
            [['no_bpjstk', 'no_bpjskes'], 'string', 'max' => 20],
            [['type'], 'string', 'max' => 7],
            [['email'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 50],
            [['id_job_alocation'], 'unique'],
            [['reg_number'], 'unique'],
            [['id_coreperson'], 'exist', 'skipOnError' => true, 'targetClass' => Coreperson::className(), 'targetAttribute' => ['id_coreperson' => 'id']],
            [['id_division'], 'exist', 'skipOnError' => true, 'targetClass' => Division::className(), 'targetAttribute' => ['id_division' => 'id']],
            [['id_job_alocation'], 'exist', 'skipOnError' => true, 'targetClass' => JobAlocation::className(), 'targetAttribute' => ['id_job_alocation' => 'id']],
            [['id_jobrole'], 'exist', 'skipOnError' => true, 'targetClass' => Jobrole::className(), 'targetAttribute' => ['id_jobrole' => 'id']],
            [['id_jobtitle'], 'exist', 'skipOnError' => true, 'targetClass' => Jobtitle::className(), 'targetAttribute' => ['id_jobtitle' => 'id']],
            [['id_location'], 'exist', 'skipOnError' => true, 'targetClass' => Location::className(), 'targetAttribute' => ['id_location' => 'id']],
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
            'no_bpjstk' => 'No Bpjstk',
            'no_bpjskes' => 'No Bpjskes',
            'date_of_hired' => 'Date Of Hired',
            'type' => 'Type',
            'is_permanent' => 'Is Permanent',
            'id_jobtitle' => 'Id Jobtitle',
            'id_division' => 'Id Division',
            'id_jobrole' => 'Id Jobrole',
            'id_department' => 'Id Department',
            'id_coreperson' => 'Id Coreperson',
            'email' => 'Email',
            'id_location' => 'Id Location',
            'is_active' => 'Is Active',
            'id_job_alocation' => 'Id Job Alocation',
            'name' => 'Name',
            'basic_salary' => 'Basic Salary',
        ];
    }

    /**
     * Gets query for [[Attendances]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAttendances()
    {
        return $this->hasMany(Attendance::className(), ['id_employee' => 'id']);
    }

    /**
     * Gets query for [[Cardlog]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCardlog()
    {
        return $this->hasOne(Cardlog::className(), ['id_employee' => 'id']);
    }

    /**
     * Gets query for [[Contract]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContract()
    {
        return $this->hasOne(Contract::className(), ['id_employee' => 'id']);
    }

    /**
     * Gets query for [[ContractHistories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContractHistories()
    {
        return $this->hasMany(ContractHistories::className(), ['id_employee' => 'id']);
    }

    /**
     * Gets query for [[Coreperson]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCoreperson()
    {
        return $this->hasOne(Coreperson::className(), ['id' => 'id_coreperson']);
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

    /**
     * Gets query for [[Location]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(Location::className(), ['id' => 'id_location']);
    }

    public function getPayrollGroupEmployee()
    {
        return $this->hasOne(PayrollGroupEmployee::className(),['id_employee'=>'id']);
    }

    /**
     * Gets query for [[EmployeeDepartement]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeDepartement()
    {
        return $this->hasOne(EmployeeDepartement::className(), ['id_employee' => 'id']);
    }

    /**
     * Gets query for [[MandorEmployee]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMandorEmployee()
    {
        return $this->hasOne(MandorEmployee::className(), ['id_employee' => 'id']);
    }

    /**
     * Gets query for [[MandorLeader]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMandorLeader()
    {
        return $this->hasOne(MandorLeader::className(), ['id_employee' => 'id']);
    }

    /**
     * Gets query for [[TimeshiftEmployees]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTimeshiftEmployees()
    {
        return $this->hasMany(TimeshiftEmployee::className(), ['id_employee' => 'id']);
    }

    /**
     * Gets query for [[TimeshiftOptions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTimeshiftOptions()
    {
        return $this->hasMany(TimeshiftOption::className(), ['id_employee' => 'id']);
    }
}
