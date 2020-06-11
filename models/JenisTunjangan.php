<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use Yii;

/**
 * This is the model class for table "jenis_tunjangan".
 *
 * @property int $id
 * @property string $nama_jenis
 * @property string $nilai_tunjangan
 *
 * @property Tunjangan[] $tunjangans
 */
class JenisTunjangan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    use SmartIncrementKeyDb;
    
    public static function tableName()
    {
        return 'jenis_tunjangan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['nilai_tunjangan'], 'number'],
            [['nama_jenis'], 'string', 'max' => 45],
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
            'nama_jenis' => 'Nama Jenis',
            'nilai_tunjangan' => 'Nilai Tunjangan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTunjangans()
    {
        return $this->hasMany(Tunjangan::className(), ['jenis_tunjangan_id' => 'id']);
    }
}
