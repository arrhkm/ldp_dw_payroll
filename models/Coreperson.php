<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use Yii;

/**
 * This is the model class for table "coreperson".
 *
 * @property int $id
 * @property string $name
 * @property string|null $birth_date
 * @property string|null $birth_city
 * @property string|null $id_card
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $bank_account
 * @property string|null $marital_status
 * @property string|null $status
 * @property string|null $tax_account
 * @property string|null $city
 * @property string|null $bank_name
 *
 * @property Employee[] $employees
 */
class Coreperson extends \yii\db\ActiveRecord
{
    use SmartIncrementKeyDb;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'coreperson';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['birth_date'], 'safe'],
            [['name', 'birth_city'], 'string', 'max' => 50],
            [['id_card', 'phone', 'bank_account', 'tax_account'], 'string', 'max' => 20],
            [['address'], 'string', 'max' => 125],
            [['marital_status'], 'string', 'max' => 1],
            [['status'], 'string', 'max' => 6],
            [['city', 'bank_name'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'birth_date' => 'Birth Date',
            'birth_city' => 'Birth City',
            'id_card' => 'Id Card',
            'phone' => 'Phone',
            'address' => 'Address',
            'bank_account' => 'Bank Account',
            'marital_status' => 'Marital Status',
            'status' => 'Status',
            'tax_account' => 'Tax Account',
            'city' => 'City',
            'bank_name' => 'Bank Name',
        ];
    }

    /**
     * Gets query for [[Employees]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployees()
    {
        return $this->hasMany(Employee::className(), ['id_coreperson' => 'id']);
    }
}
