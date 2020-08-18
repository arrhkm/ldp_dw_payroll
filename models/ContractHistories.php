<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use Yii;

/**
 * This is the model class for table "contract_histories".
 *
 * @property int $id
 * @property string|null $start_contract
 * @property int|null $duration_contract
 * @property int|null $id_employee
 * @property string|null $number_contract
 * @property string|null $doh
 * @property float|null $basic_salary
 * @property bool|null $set_default
 *
 * @property Employee $employee
 */
class ContractHistories extends \yii\db\ActiveRecord
{
    use SmartIncrementKeyDb;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contract_histories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'duration_contract', 'id_employee'], 'default', 'value' => null],
            [['id', 'duration_contract', 'id_employee'], 'integer'],
            [['start_contract', 'doh'], 'safe'],
            [['basic_salary'], 'number'],
            [['set_default'], 'boolean'],
            [['number_contract'], 'string', 'max' => 100],
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
            'start_contract' => 'Start Contract',
            'duration_contract' => 'Duration Contract',
            'id_employee' => 'Id Employee',
            'number_contract' => 'Number Contract',
            'doh' => 'Doh',
            'basic_salary' => 'Basic Salary',
            'set_default' => 'Set Default',
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
