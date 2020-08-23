<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "component_payroll".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $component_code
 *
 * @property ComponentGroup[] $componentGroups
 */
class ComponentPayroll extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'component_payroll';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'component_code'], 'default', 'value' => null],
            [['id', 'component_code'], 'integer'],          
            [['name'], 'string'],
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
            'component_code' => 'Component Code',
        ];
    }

    /**
     * Gets query for [[ComponentGroups]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComponentGroups()
    {
        return $this->hasMany(ComponentGroup::className(), ['id_component_payroll' => 'id']);
    }
}
