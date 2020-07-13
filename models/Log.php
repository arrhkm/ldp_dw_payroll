<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use Yii;

/**
 * This is the model class for table "log".
 *
 * @property int $id
 * @property int|null $pin
 * @property string|null $timestamp
 * @property int|null $status
 * @property int|null $verification
 * @property int|null $id_attmachine
 *
 * @property Attmachine $attmachine
 */
class Log extends \yii\db\ActiveRecord
{
    use SmartIncrementKeyDb;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'pin', 'status', 'verification', 'id_attmachine'], 'default', 'value' => null],
            [['id', 'pin', 'status', 'verification', 'id_attmachine'], 'integer'],
            [['timestamp'], 'safe'],
            [['id'], 'unique'],
            [['id_attmachine'], 'exist', 'skipOnError' => true, 'targetClass' => Attmachine::className(), 'targetAttribute' => ['id_attmachine' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pin' => 'Pin',
            'timestamp' => 'Timestamp',
            'status' => 'Status',
            'verification' => 'verification',
            'id_attmachine' => 'Id Attmachine',
        ];
    }

    /**
     * Gets query for [[Attmachine]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAttmachine()
    {
        return $this->hasOne(Attmachine::className(), ['id' => 'id_attmachine']);
    }
}
