<?php 
namespace app\models;

use  yii\base\Model;

class ModelFormContract extends \yii\base\Model
{
    public $id;

    public $id_employee;
    public $start_contract;
    public $duration_contract;
    public $number_contract;


    public function rules()
    {
        return [
            [['id', 'id_employee','duration_contract'], 'integer'],
            ['start_contract', 'date'],
            [['number_contract'], 'string'],
        ];
    }

    public function getLastId(){
        return ContractHistories::getLastId();
    }
}