<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cardlog".
 *
 * @property int $id
 * @property int|null $pin
 * @property int|null $id_attmachine
 * @property int|null $id_employee
 *
 * @property Attmachine $attmachine
 * @property Employee $employee
 */
class Cardlog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cardlog';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'pin', 'id_attmachine', 'id_employee'], 'default', 'value' => null],
            [['id', 'pin', 'id_attmachine', 'id_employee'], 'integer'],
            [['id_employee'], 'unique'],
            [['id'], 'unique'],
            [['id_attmachine'], 'exist', 'skipOnError' => true, 'targetClass' => Attmachine::className(), 'targetAttribute' => ['id_attmachine' => 'id']],
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
            'pin' => 'Pin',
            'id_attmachine' => 'Id Attmachine',
            'id_employee' => 'Id Employee',
        ];
    }

    /**
     * Gets query for [[Attmachine]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAttmachine()
    {
        return $this->hasOne(Attmachine::className(), ['id' => 'id_attmachine']);
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
