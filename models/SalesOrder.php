<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use Yii;

/**
 * This is the model class for table "sales_order".
 *
 * @property int $id
 * @property string $so_number
 * @property string $so_name
 * @property string $dscription
 * @property int $is_active
 */
class SalesOrder extends \yii\db\ActiveRecord
{
    use SmartIncrementKeyDb;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sales_order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'is_active'], 'integer'],
            //[['is_active'], 'boolean'],
            [['so_number', 'so_name'], 'string', 'max' => 255],
            [['dscription'], 'string', 'max' => 255],
            [['so_number'], 'unique'],
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
            'so_number' => 'So Number',
            'so_name' => 'So Name',
            'dscription' => 'Dscription',
            'is_active' => 'Is Active',
        ];
    }
}
