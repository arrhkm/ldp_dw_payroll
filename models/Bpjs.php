<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use Yii;

/**
 * This is the model class for table "bpjs".
 *
 * @property int $id
 * @property string|null $bpjs_kes
 * @property string|null $bpjs_tkerja
 * @property int|null $id_employee
 *
 * @property Employee $employee
 */
class Bpjs extends \yii\db\ActiveRecord
{
    use SmartIncrementKeyDb;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bpjs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'id_employee'], 'default', 'value' => null],
            [['id', 'id_employee'], 'integer'],
            [['bpjs_kes', 'bpjs_tkerja'], 'string', 'max' => 100],
            [['id_employee'], 'unique'],
            [['id'], 'unique'],
            [['id_employee'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['id_employee' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bpjs_kes' => 'Bpjs Kes',
            'bpjs_tkerja' => 'Bpjs Tkerja',
            'id_employee' => 'Id Employee',
        ];
    }

    /**
     * Gets query for [[Employee]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee::className(), ['id' => 'id_employee']);
    }
}
