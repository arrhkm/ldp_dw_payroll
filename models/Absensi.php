<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "absensi".
 *
 * @property string $tgl
 * @property string $emp_id
 * @property string|null $jam_in
 * @property string|null $jam_out
 * @property string|null $ket_absen
 * @property int|null $timestamp_diff
 * @property string|null $status
 * @property string|null $loc_code
 * @property string|null $datetime_in
 * @property string|null $datetime_out
 */
class Absensi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'absensi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tgl', 'emp_id'], 'required'],
            [['tgl', 'jam_in', 'jam_out', 'datetime_out'], 'safe'],
            [['timestamp_diff'], 'integer'],
            [['status'], 'string'],
            [['emp_id'], 'string', 'max' => 15],
            [['ket_absen'], 'string', 'max' => 3],
            [['loc_code'], 'string', 'max' => 20],
            [['datetime_in'], 'string', 'max' => 45],
            [['tgl', 'emp_id'], 'unique', 'targetAttribute' => ['tgl', 'emp_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tgl' => 'Tgl',
            'emp_id' => 'Emp ID',
            'jam_in' => 'Jam In',
            'jam_out' => 'Jam Out',
            'ket_absen' => 'Ket Absen',
            'timestamp_diff' => 'Timestamp Diff',
            'status' => 'Status',
            'loc_code' => 'Loc Code',
            'datetime_in' => 'Datetime In',
            'datetime_out' => 'Datetime Out',
        ];
    }
}
