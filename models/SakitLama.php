<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use Yii;

/**
 * This is the model class for table "sakit_lama".
 *
 * @property int $id
 * @property string|null $start_sakit
 * @property string|null $dscription
 * @property bool|null $is_close
 * @property int|null $id_employee
 *
 * @property Employee $employee
 */
class SakitLama extends \yii\db\ActiveRecord
{
    use SmartIncrementKeyDb;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sakit_lama';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'start_sakit', 'id_employee'], 'required'],
            [['id', 'id_employee'], 'default', 'value' => null],
            [['id', 'id_employee'], 'integer'],
            [['start_sakit'], 'safe'],
            [['is_close'], 'boolean'],
            [['dscription'], 'string', 'max' => 100],
            [['id_employee', 'start_sakit'], 'unique', 'targetAttribute' => ['id_employee', 'start_sakit']],
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
            'start_sakit' => 'Start Sakit',
            'dscription' => 'Dscription',
            'is_close' => 'Is Close',
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
