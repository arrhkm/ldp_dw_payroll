<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use Yii;

/**
 * This is the model class for table "insentif".
 *
 * @property int $id
 * @property string|null $date_insentif
 * @property int|null $id_insentif_master
 * @property int|null $id_employee
 *
 * @property Employee $employee
 * @property InsentifMaster $insentifMaster
 */
class Insentif extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    use SmartIncrementKeyDb;
    public static function tableName()
    {
        return 'insentif';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'date_insentif', 'id_employee', 'id_insentif_master'], 'required'],
            [['id', 'id_insentif_master', 'id_employee'], 'default', 'value' => null],
            [['id', 'id_insentif_master', 'id_employee'], 'integer'],
            
            [['date_insentif'], 'safe'],
            [['date_insentif', 'id_employee', 'id_insentif_master'], 'unique', 'targetAttribute' => ['date_insentif', 'id_employee', 'id_insentif_master']],
            [['id'], 'unique'],
            [['id_employee'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['id_employee' => 'id']],
            [['id_insentif_master'], 'exist', 'skipOnError' => true, 'targetClass' => InsentifMaster::className(), 'targetAttribute' => ['id_insentif_master' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_insentif' => 'Date Insentif',
            'id_insentif_master' => 'Id Insentif Master',
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

    /**
     * Gets query for [[InsentifMaster]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInsentifMaster()
    {
        return $this->hasOne(InsentifMaster::className(), ['id' => 'id_insentif_master']);
    }
}
