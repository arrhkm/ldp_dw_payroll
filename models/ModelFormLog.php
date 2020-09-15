<?php 
namespace app\models;

use  yii\base\Model;

class ModelFormLog extends \yii\base\Model
{
    
    public $id_employee;
    public $date_log;
    public $time_log;
   


    public function rules()
    {
        return [
            [['id_employee'], 'integer'],
            ['date_log', 'date'],
            [['time_log'], 'time'],
        ];
    }

   
}