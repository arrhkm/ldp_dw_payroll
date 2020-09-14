<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use Yii;

/**
 * This is the model class for table "kasbon_plan".
 *
 * @property int $id
 * @property string $date_kasbon_plan
 * @property int|null $id_kasbon
 * @property float $plan_value
 * @property bool|null $is_close
 *
 * @property Kasbon $kasbon
 */
class KasbonPlan extends \yii\db\ActiveRecord
{
    use SmartIncrementKeyDb;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kasbon_plan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'date_kasbon_plan', 'plan_value'], 'required'],
            [['id', 'id_kasbon'], 'default', 'value' => null],
            [['id', 'id_kasbon'], 'integer'],
            [['date_kasbon_plan'], 'safe'],
            [['plan_value'], 'number'],
            [['is_close'], 'boolean'],
            [['date_kasbon_plan', 'id_kasbon'], 'unique', 'targetAttribute' => ['date_kasbon_plan', 'id_kasbon']],
            [['id'], 'unique'],
            [['id_kasbon'], 'exist', 'skipOnError' => true, 'targetClass' => Kasbon::className(), 'targetAttribute' => ['id_kasbon' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_kasbon_plan' => 'Date Kasbon Plan',
            'id_kasbon' => 'Id Kasbon',
            'plan_value' => 'Plan Value',
            'is_close' => 'Is Close',
        ];
    }

    /**
     * Gets query for [[Kasbon]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKasbon()
    {
        return $this->hasOne(Kasbon::className(), ['id' => 'id_kasbon']);
    }
}
