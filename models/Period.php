<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use Yii;

/**
 * This is the model class for table "period".
 *
 * @property int $id
 * @property string|null $period_name
 * @property string|null $start_date
 * @property string|null $end_date
 * @property bool|null $pot_jamsos
 *
 * @property TimeshiftEmployee[] $timeshiftEmployees
 */
class Period extends \yii\db\ActiveRecord
{
    use SmartIncrementKeyDb;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'period';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'default', 'value' => null],
            [['id'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            [['pot_jamsos'], 'boolean'],
            [['period_name'], 'string', 'max' => 32],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'period_name' => 'Period Name',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'pot_jamsos' => 'Pot Jamsos',
        ];
    }

    /**
     * Gets query for [[TimeshiftEmployees]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTimeshiftEmployees()
    {
        return $this->hasMany(TimeshiftEmployee::className(), ['id_period' => 'id']);
    }
}
