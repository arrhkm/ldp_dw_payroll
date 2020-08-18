<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "daily_component_detil".
 *
 * @property int $id
 * @property string|null $date_component
 * @property int|null $id_employee
 * @property int|null $id_daily_component
 *
 * @property DailyComponent $dailyComponent
 * @property Employee $employee
 */
class DailyComponentDetil extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'daily_component_detil';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'id_employee', 'id_daily_component'], 'default', 'value' => null],
            [['id', 'id_employee', 'id_daily_component'], 'integer'],
            [['date_component'], 'safe'],
            [['date_component', 'id_employee', 'id_daily_component'], 'unique', 'targetAttribute' => ['date_component', 'id_employee', 'id_daily_component']],
            [['id'], 'unique'],
            [['id_daily_component'], 'exist', 'skipOnError' => true, 'targetClass' => DailyComponent::className(), 'targetAttribute' => ['id_daily_component' => 'id']],
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
            'date_component' => 'Date Component',
            'id_employee' => 'Id Employee',
            'id_daily_component' => 'Id Daily Component',
        ];
    }

    /**
     * Gets query for [[DailyComponent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDailyComponent()
    {
        return $this->hasOne(DailyComponent::className(), ['id' => 'id_daily_component']);
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
