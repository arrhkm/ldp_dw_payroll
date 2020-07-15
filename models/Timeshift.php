<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use Yii;

/**
 * This is the model class for table "timeshift".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $dscription
 *
 * @property TimeshiftDetil[] $timeshiftDetils
 * @property TimeshiftOption[] $timeshiftOptions
 */
class Timeshift extends \yii\db\ActiveRecord
{
    use SmartIncrementKeyDb;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'timeshift';
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
            [['name'], 'string', 'max' => 32],
            [['dscription'], 'string', 'max' => 100],
            [['name'], 'unique'],
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
            'name' => 'Name',
            'dscription' => 'Dscription',
        ];
    }

    /**
     * Gets query for [[TimeshiftDetils]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTimeshiftDetils()
    {
        return $this->hasMany(TimeshiftDetil::className(), ['id_timeshift' => 'id']);
    }

    /**
     * Gets query for [[TimeshiftOptions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTimeshiftOptions()
    {
        return $this->hasMany(TimeshiftOption::className(), ['id_timeshift' => 'id']);
    }
}
