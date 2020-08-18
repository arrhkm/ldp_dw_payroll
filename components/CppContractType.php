<?php
namespace app\components;

use app\models\ContractType;
use yii\helpers\ArrayHelper;

class CppContractType {
    static function getType(){
        $ContractType= ContractType::find()           
            ->all();               
        /*$list = ArrayHelper::toArray($emp, [
            'app\models\Employee'=>[
                'id',
                'reg_number',
                'reg_plus'=>function($emp){
                    return $emp->reg_number." - ".$emp->coreperson->name;
                },
            ]
        ]);*/        
        
        $list_contract = ArrayHelper::map($ContractType, 'id', 'name_contract');
        return $list_contract;
    }
}