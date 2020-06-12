<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use Yii;

/**
 * This is the model class for table "spl_detil".
 *
 * @property int $id
 * @property string $so
 * @property int $jam
 * @property int $spl_id
 *
 * @property Spl $spl
 */
class SplDetil extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    use SmartIncrementKeyDb;
    
    public static function tableName()
    {
        return 'spl_detil';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'spl_id', 'so', 'jam'], 'required'],
            [['id', 'jam', 'spl_id'], 'integer'],
            [['spl_id', 'so'], 'unique', 'targetAttribute'=>['so']],
            ['jam', 'validateJam'],
            [['so'], 'string', 'max' => 45],
            [['id', 'spl_id'], 'unique', 'targetAttribute' => ['id', 'spl_id']],
            [['spl_id'], 'exist', 'skipOnError' => true, 'targetClass' => Spl::className(), 'targetAttribute' => ['spl_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'so' => 'So',
            'jam' => 'Jam',
            'spl_id' => 'Spl ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpl()
    {
        return $this->hasOne(Spl::className(), ['id' => 'spl_id']);
    }

    


    public function validateJam($attribute){
        //$x = $this->getSpl();
        $test = 10000;
        if (($this->cekData() + $this->jam) > $this->spl->overtime_value){
            $this->addError($attribute, "Jam pada item SO melebihi Jam SPKL (".$this->cekData().")");
        }
    }
    public function cekData(){
        $x = $this->find()->where(['spl_id'=>$this->spl_id])->all();
        $dt_count = 0;
        foreach($x as $y){
            $dt_count = $dt_count+ $y['jam'];
        }
        return $dt_count;
    }

}
