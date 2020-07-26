<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ModelFormPayroll extends Model
{
    public $id_period;
    public $id_payroll_group;

    public function rules()
    {
        return [
            [['id_payroll_group'], 'required'],
            
        ];
    }
}