<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "attmachine".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $ip
 * @property int|null $com_key
 * @property int|null $port
 *
 * @property Cardlog[] $cardlogs
 */
class Attmachine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'attmachine';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'com_key', 'port'], 'default', 'value' => null],
            [['id', 'com_key', 'port'], 'integer'],
            [['name'], 'string', 'max' => 32],
            [['ip'], 'string', 'max' => 15],
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
            'ip' => 'Ip',
            'com_key' => 'Com Key',
            'port' => 'Port',
        ];
    }

    /**
     * Gets query for [[Cardlogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCardlogs()
    {
        return $this->hasMany(Cardlog::className(), ['id_attmachine' => 'id']);
    }
}
