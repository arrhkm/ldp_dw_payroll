<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use Yii;

/**
 * This is the model class for table "leave".
 *
 * @property int $id
 * @property string|null $date_leave
 * @property int|null $id_employee
 * @property int|null $id_leave_type
 *
 * @property Employee $employee
 * @property LeaveType $leaveType
 */
class Leave extends \yii\db\ActiveRecord
{
    use SmartIncrementKeyDb;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'leave';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'id_employee', 'id_leave_type'], 'default', 'value' => null],
            [['id', 'id_employee', 'id_leave_type'], 'integer'],
            [['date_leave'], 'safe'],
            [['date_leave', 'id_employee'], 'unique', 'targetAttribute' => ['date_leave', 'id_employee']],
            [['id'], 'unique'],
            [['id_employee'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['id_employee' => 'id']],
            [['id_leave_type'], 'exist', 'skipOnError' => true, 'targetClass' => LeaveType::className(), 'targetAttribute' => ['id_leave_type' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_leave' => 'Date Leave',
            'id_employee' => 'Id Employee',
            'id_leave_type' => 'Id Leave Type',
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
     * Gets query for [[LeaveType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLeavetype()
    {
        return $this->hasOne(LeaveType::className(), ['id' => 'id_leave_type']);
    }
}
