<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "daily_component".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $component_code
 *
 * @property DailyComponentDetil[] $dailyComponentDetils
 */
class DailyComponent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'daily_component';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'component_code'], 'default', 'value' => null],
            [['id', 'component_code'], 'integer'],
            [['name'], 'string', 'max' => 20],
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
            'component_code' => 'Component Code',
        ];
    }

    /**
     * Gets query for [[DailyComponentDetils]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDailyComponentDetils()
    {
        return $this->hasMany(DailyComponentDetil::className(), ['id_daily_component' => 'id']);
    }
}
