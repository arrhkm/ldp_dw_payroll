<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use Yii;

/**
 * This is the model class for table "insentif_master".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $dscription
 * @property float|null $value
 *
 * @property Insentif[] $insentifs
 */
class InsentifMaster extends \yii\db\ActiveRecord
{
    use SmartIncrementKeyDb;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'insentif_master';
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
            [['value'], 'number'],
            [['name'], 'string', 'max' => 20],
            [['dscription'], 'string', 'max' => 100],
            [['name'], 'unique'],
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
            'name' => 'Name',
            'dscription' => 'Dscription',
            'value' => 'Value',
        ];
    }

    /**
     * Gets query for [[Insentifs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInsentifs()
    {
        return $this->hasMany(Insentif::className(), ['id_insentif_master' => 'id']);
    }

    
}
