<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use Yii;

/**
 * This is the model class for table "dayoff".
 *
 * @property int $id
 * @property string|null $date_dayoff
 * @property string|null $dscription
 */
class Dayoff extends \yii\db\ActiveRecord
{
    use SmartIncrementKeyDb;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dayoff';
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
            [['date_dayoff'], 'safe'],
            [['dscription'], 'string', 'max' => 100],
            [['date_dayoff'], 'unique'],
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
            'date_dayoff' => 'Date Dayoff',
            'dscription' => 'Dscription',
        ];
    }
}
