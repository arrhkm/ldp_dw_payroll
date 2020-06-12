<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hs_hr_emp_kartu".
 *
 * @property int $no_kartu
 * @property string $emp_number_kartu
 * @property int $staff_dw
 * @property string $lokasi
 */
class Kartu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hs_hr_emp_kartu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_kartu', 'emp_number_kartu', 'staff_dw', 'lokasi'], 'required'],
            [['no_kartu', 'staff_dw'], 'integer'],
            [['emp_number_kartu'], 'string', 'max' => 11],
            [['lokasi'], 'string', 'max' => 50],
            [['no_kartu', 'emp_number_kartu'], 'unique', 'targetAttribute' => ['no_kartu', 'emp_number_kartu']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'no_kartu' => 'No Kartu',
            'emp_number_kartu' => 'Emp Number Kartu',
            'staff_dw' => 'Staff Dw',
            'lokasi' => 'Lokasi',
        ];
    }
}
