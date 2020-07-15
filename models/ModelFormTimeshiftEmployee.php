<?php 

namespace app\models;

use Yii;
use yii\base\Model;

class ModelFormTimeshiftEmployee extends Model
{
    public $id_employee;
    public $id_timeshift;

    public function rules()
    {
        return [
            [['id_employee', 'id_timeshift'], 'required'],
            
        ];
    }
}