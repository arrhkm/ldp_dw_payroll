<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use Yii;

/**
 * This is the model class for table "kasbon".
 *
 * @property int $id
 * @property string|null $date_kasbon
 * @property float|null $nilai_kasbon
 * @property bool|null $is_active
 * @property int|null $id_employee
 *
 * @property DetilKasbon[] $detilKasbons
 * @property Employee $employee
 */
class Kasbon extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['id_employee', 'validateRedudanceKasbon'];
        //$scenarios[self::SCENARIO_UPDATE] = ['username', 'email', 'password'];
        return $scenarios;
    }
    use SmartIncrementKeyDb;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kasbon';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nilai_kasbon'], 'required'],
            [['id', 'id_employee'], 'default', 'value' => null],
            [['id', 'id_employee'], 'integer'],
            [['id_employee'], 'validateRedudanceKasbon', 'on'=>self::SCENARIO_CREATE],
            [['date_kasbon'], 'safe'],
            [['nilai_kasbon'], 'number'],
            [['is_active'], 'boolean'],
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
            'date_kasbon' => 'Date Kasbon',
            'nilai_kasbon' => 'Nilai Kasbon',
            'is_active' => 'Is Active',
            'id_employee' => 'Id Employee',
        ];
    }

    /**
     * Gets query for [[DetilKasbons]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDetilKasbons()
    {
        return $this->hasMany(DetilKasbon::className(), ['id_kasbon' => 'id']);
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

    public function validateRedudanceKasbon(){
        if ($this->is_active=true){
            $kasbon = $this->find()->where(['id_employee'=>$this->id_employee, 'is_active'=>true]);
            if ($kasbon->count()>=1){
                //$this->addErrors('id', 'Employee sudah terdaftar kasbon active');
                $this->addError('id_employee', 'Employee sudah terdaftad active.');
            }
        }
        //return true;
        
    }
}
