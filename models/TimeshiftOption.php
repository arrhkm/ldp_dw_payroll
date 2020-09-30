<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use Yii;

/**
 * This is the model class for table "timeshift_option".
 *
 * @property int $id
 * @property int|null $id_timeshift
 * @property int|null $id_employee
 *
 * @property Employee $employee
 * @property Timeshift $timeshift
 */
class TimeshiftOption extends \yii\db\ActiveRecord
{
    public $id_payroll_group;
    use SmartIncrementKeyDb;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'timeshift_option';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'id_timeshift', 'id_employee'], 'default', 'value' => null],
            [['id', 'id_timeshift', 'id_employee'], 'integer'],
            [['id'], 'unique'],
            [['id_employee'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['id_employee' => 'id']],
            [['id_timeshift'], 'exist', 'skipOnError' => true, 'targetClass' => Timeshift::className(), 'targetAttribute' => ['id_timeshift' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_timeshift' => 'Id Timeshift',
            'id_employee' => 'Id Employee',
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
     * Gets query for [[Timeshift]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTimeshift()
    {
        return $this->hasOne(Timeshift::className(), ['id' => 'id_timeshift']);
    }
}
