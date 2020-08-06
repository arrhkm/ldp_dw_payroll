<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use Yii;
use yii\validators\Validator;

/**
 * This is the model class for table "detil_kasbon".
 *
 * @property int $id
 * @property float|null $nilai_cicilan
 * @property string|null $tgl_cicilan
 * @property int|null $id_employee
 * @property int|null $id_kasbon
 *
 * @property Employee $employee
 * @property Kasbon $kasbon
 */
class DetilKasbon extends \yii\db\ActiveRecord
{
    use SmartIncrementKeyDb;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'detil_kasbon';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tgl_cicilan', 'nilai_cicilan'], 'required'],
            [['id', 'id_employee', 'id_kasbon'], 'default', 'value' => null],
            [['id', 'id_employee', 'id_kasbon'], 'integer'],
            [['nilai_cicilan'], 'number'],
            [['nilai_cicilan'], 'validateNilaiCicilan'],
            [['tgl_cicilan'], 'safe'],
            [['id'], 'unique'],
            [['id_employee'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['id_employee' => 'id']],
            [['id_kasbon'], 'exist', 'skipOnError' => true, 'targetClass' => Kasbon::className(), 'targetAttribute' => ['id_kasbon' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nilai_cicilan' => 'Nilai Cicilan',
            'tgl_cicilan' => 'Tgl Cicilan',
            'id_employee' => 'Id Employee',
            'id_kasbon' => 'Id Kasbon',
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
     * Gets query for [[Kasbon]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKasbon()
    {
        return $this->hasOne(Kasbon::className(), ['id' => 'id_kasbon']);
    }

    public function validateNilaiCicilan(){
        $kasbon = Kasbon::findOne($this->id_kasbon);
        $jml_cicil = 0;
        foreach ($kasbon->detilKasbons as $nilai){
            $jml_cicil += $nilai->nilai_cicilan;
        }
        if ($jml_cicil+$this->nilai_cicilan > $kasbon->nilai_kasbon){
            $this->addError('nilai_cicilan', 'Nilai cicilan :'.($jml_cicil+$this->nilai_cicilan).'> nilai kasbon '.$kasbon->nilai_kasbon);
        }
    }
    
}


