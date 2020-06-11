<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use Yii;

/**
 * This is the model class for table "tarif_tunjangan_masakerja".
 *
 * @property int $id
 * @property int $masa_kerja
 * @property string $nilai_tunjangan
 */
class TarifTunjanganMasakerja extends \yii\db\ActiveRecord
{
    use SmartIncrementKeyDb;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tarif_tunjangan_masakerja';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'masa_kerja'], 'integer'],
            [['nilai_tunjangan'], 'number'],
            [['id'], 'unique'],
            [['masa_kerja'], 'unique']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'masa_kerja' => 'Masa Kerja',
            'nilai_tunjangan' => 'Nilai Tunjangan',
        ];
    }
}
