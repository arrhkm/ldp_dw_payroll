<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "jabatan".
 *
 * @property int $kd_jabatan
 * @property string $nama_jabatan
 */
class Jabatan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jabatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kd_jabatan', 'nama_jabatan'], 'required'],
            [['kd_jabatan'], 'integer'],
            [['nama_jabatan'], 'string', 'max' => 32],
            [['kd_jabatan'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kd_jabatan' => 'Kd Jabatan',
            'nama_jabatan' => 'Nama Jabatan',
        ];
    }
}
