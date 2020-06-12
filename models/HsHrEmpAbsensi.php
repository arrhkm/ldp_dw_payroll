<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use Yii;

/**
 * This is the model class for table "hs_hr_emp_absensi".
 *
 * @property int $id
 * @property string $timestamp
 * @property int $verifikasi
 * @property int $status
 * @property int $id_machine
 */
class HsHrEmpAbsensi extends \yii\db\ActiveRecord
{
    use SmartIncrementKeyDb;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hs_hr_emp_absensi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_machine'], 'required'],
            [['id', 'verifikasi', 'status', 'id_machine'], 'integer'],
            [['timestamp'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'timestamp' => 'Timestamp',
            'verifikasi' => 'Verifikasi',
            'status' => 'Status',
            'id_machine' => 'Id Machine',
        ];
    }
}
