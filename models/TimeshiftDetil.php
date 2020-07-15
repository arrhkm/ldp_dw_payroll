<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use Yii;

/**
 * This is the model class for table "timeshift_detil".
 *
 * @property int $id
 * @property string|null $start_hour
 * @property int|null $duration_hour
 * @property int|null $num_day
 * @property int|null $id_timeshift
 * @property bool|null $is_dayoff
 *
 * @property Timeshift $timeshift
 */
class TimeshiftDetil extends \yii\db\ActiveRecord
{
    use SmartIncrementKeyDb;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'timeshift_detil';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'duration_hour', 'num_day', 'id_timeshift'], 'default', 'value' => null],
            [['id', 'duration_hour', 'num_day', 'id_timeshift'], 'integer'],
            [['start_hour'], 'safe'],
            [['is_dayoff'], 'boolean'],
            [['num_day', 'id_timeshift'], 'unique', 'targetAttribute' => ['num_day', 'id_timeshift']],
            [['id'], 'unique'],
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
            'start_hour' => 'Start Hour',
            'duration_hour' => 'Duration Hour',
            'num_day' => 'Num Day',
            'id_timeshift' => 'Id Timeshift',
            'is_dayoff' => 'Is Dayoff',
        ];
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
