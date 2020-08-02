<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use Yii;

/**
 * This is the model class for table "spkl".
 *
 * @property int $id
 * @property string|null $date_spkl
 * @property int|null $overtime_hour
 * @property int|null $id_employee
 *
 * @property Employee $employee
 */
class Spkl extends \yii\db\ActiveRecord
{
    use SmartIncrementKeyDb;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'spkl';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'overtime_hour', 'id_employee'], 'default', 'value' => null],
            [['id', 'overtime_hour', 'id_employee'], 'integer'],
            [['date_spkl'], 'safe'],
            [['date_spkl', 'id_employee'], 'unique', 'targetAttribute' => ['date_spkl', 'id_employee']],
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
            'date_spkl' => 'Date Spkl',
            'overtime_hour' => 'Overtime Hour',
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
