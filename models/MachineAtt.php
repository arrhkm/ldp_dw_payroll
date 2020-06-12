<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "machine_att".
 *
 * @property int $id
 * @property string $ip
 * @property int $port
 * @property int $com
 */
class MachineAtt extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'machine_att';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ip', 'port', 'com'], 'required'],
            [['id', 'port', 'com'], 'integer'],
            [['ip'], 'string', 'max' => 45],
            [['ip'], 'unique'],
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
            'ip' => 'Ip',
            'port' => 'Port',
            'com' => 'Com',
        ];
    }
}
