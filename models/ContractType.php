<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contract_type".
 *
 * @property int $id
 * @property string|null $name_contract
 * @property string|null $dscription
 *
 * @property Contract[] $contracts
 */
class ContractType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contract_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'default', 'value' => null],
            [['id'], 'integer'],
            [['name_contract'], 'string', 'max' => 20],
            [['dscription'], 'string', 'max' => 50],
            [['name_contract'], 'unique'],
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
            'name_contract' => 'Name Contract',
            'dscription' => 'Dscription',
        ];
    }

    /**
     * Gets query for [[Contracts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContracts()
    {
        return $this->hasMany(Contract::className(), ['id_contract_type' => 'id']);
    }
}
