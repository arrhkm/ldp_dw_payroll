<?php
namespace app\models;

use yii\base\Model;

class ModelFormInsentifMultipleDate extends Model{
   public $date_insentif;
   public $id_insentif_master ;
   public $id_employee;

   public function rules()
   {
      return [
         [['date_insentif', 'id_insentif_master', 'id_employee'], 'required']

      ];
      
   }

}