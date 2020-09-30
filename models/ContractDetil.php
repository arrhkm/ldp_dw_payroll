<?php

namespace app\models;

use app\commands\SmartIncrementKeyDb;
use Yii;

/**
 * This is the model class for table "contract_detil".
 *
 * @property int $id
 * @property string|null $start_contract
 * @property int|null $duration_contract
 * @property string|null $end_contract
 * @property string|null $number_contract
 * @property int|null $urutan_contract
 * @property int|null $id_contract
 * @property string|null $status_execute
 *
 * @property Contract $contract
 */
class ContractDetil extends \yii\db\ActiveRecord
{
    use SmartIncrementKeyDb;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contract_detil';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id','start_contract', 'duration_contract', 'number_contract'], 'required'],
            [['id', 'duration_contract', 'urutan_contract', 'id_contract'], 'default', 'value' => null],
            [['id', 'duration_contract', 'urutan_contract', 'id_contract'], 'integer'],
            [['start_contract', 'end_contract'], 'safe'],
            ['urutan_contract', 'validateUrutanContract'],
            ['duration_contract', 'validateDurationContract'],

            [['number_contract'], 'string', 'max' => 100],
            [['status_execute'], 'string', 'max' => 50],
            [['id'], 'unique'],
            [['id_contract'], 'exist', 'skipOnError' => true, 'targetClass' => Contract::className(), 'targetAttribute' => ['id_contract' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'start_contract' => 'Start Contract',
            'duration_contract' => 'Duration Contract',
            'end_contract' => 'End Contract',
            'number_contract' => 'Number Contract',
            'urutan_contract' => 'Urutan Contract',
            'id_contract' => 'Id Contract',
            'status_execute' => 'Status Execute',
        ];
    }

    /**
     * Gets query for [[Contract]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContract()
    {
        return $this->hasOne(Contract::className(), ['id' => 'id_contract']);
    }


    public function getUrutanContract($id){
        $dt = $this->find()->select(['MAX(urutan_contract)'])
        ->where(['id_contract'=>$id])->scalar();
        return $dt+1;
    }

    public function validateDurationContract($attribute, $params, $validator){
        $max=1;
        if  ($this->urutan_contract == 1){
            $max = 2;
        }elseif($this->urutan_contract == 2){
            $max = 1;
        }elseif ($this->urutan_contract == 3){
            $max = 2;
        }
        if ($this->urutan_contract >3){
            $this->addError($attribute, "Urutan contract Maximum hanya 3 kali");
        }
        elseif ($this->$attribute > $max){
            $this->addError($attribute, "The Maximum duration contract it over limit! maximum {$max} Year");
        }
        
    }

    public function validateUrutanContract($attribute, $params, $validator){
        if ($this->$attribute > 3){
            $this->addError($attribute, 'The Maximum urutan contract it over limit!, maximum only 3 ');
        }
    }
}
