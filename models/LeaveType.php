<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "leave_type".
 *
 * @property int $id
 * @property string|null $name
 * @property bool|null $is_limited
 *
 * @property Leave[] $leaves
 */
class LeaveType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'leave_type';
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
            [['is_limited'], 'boolean'],
            [['name'], 'string', 'max' => 20],
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
            'is_limited' => 'Is Limited',
        ];
    }

    /**
     * Gets query for [[Leaves]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLeaves()
    {
        return $this->hasMany(Leave::className(), ['id_leave_type' => 'id']);
    }
}
