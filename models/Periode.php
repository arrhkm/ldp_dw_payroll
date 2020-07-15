<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use Yii;

/**
 * This is the model class for table "periode".
 *
 * @property int $id
 * @property string $period_name
 * @property string $sart_date
 * @property string $end_date
 * @property int $pot_jamsos
 */
class Periode extends \yii\db\ActiveRecord
{
    use SmartIncrementKeyDb;
    /*public static function getLastId($index_name='id')
    {
        //put your code here
        $index = "MAX(".$index_name.")";
        $lat=SELF::find()->SELECT([$index])->scalar();
        if($lat){
            return (int)$lat+1;
        }else { return 1;}
    }*/ 
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'periode';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'period_name', 'sart_date', 'end_date'], 'required'],
            [['id', 'pot_jamsos'], 'integer'],
            [['sart_date', 'end_date'], 'safe'],
            [['period_name'], 'string', 'max' => 32],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Kd Periode',
            'period_name' => 'Nama Periode',
            'start_date' => 'Tgl Awal',
            'end_date' => 'Tgl Akhir',
            'pot_jamsos' => 'Potongan Jamsos',
        ];
    }
}
