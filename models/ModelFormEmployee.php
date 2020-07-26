<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ModelFormEmployee extends Model
{
    public $id_employee;
    public $id_payroll_group;

    public function rules()
    {
        return [
            [['id_employee', 'id_payroll_group'], 'required'],
            
        ];
    }
}