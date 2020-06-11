<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use Yii;

/**
 * This is the model class for table "foreman".
 *
 * @property int $id
 * @property string $foreman_name
 * @property string $leader_id
 *
 * @property ChildForeman[] $childForemen
 * @property Employee $leader
 */
class Foreman extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    use SmartIncrementKeyDb;
    public static function tableName()
    {
        return 'foreman';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'leader_id'], 'required'],
            [['id'], 'integer'],
            [['foreman_name'], 'string', 'max' => 45],
            [['leader_id'], 'string', 'max' => 11],
            [['id'], 'unique'],
            [['leader_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['leader_id' => 'emp_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'foreman_name' => 'foreman Name',
            'leader_id' => 'Leader ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildForemen()
    {
        return $this->hasMany(ChildForeman::className(), ['foreman_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeader()
    {
        return $this->hasOne(Employee::className(), ['emp_id' => 'leader_id']);
    }
}
