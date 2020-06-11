<?php 
namespace app\models;

use yii\base\Model;


class FormPlusmin extends Model
{
    public $kd_periode;
    public $excelFile;

    public function rules()
    {
        return [
            [['excelFile'], 'file', 'skipOnEmpty' => false, /*'extensions' => 'xls,xlsx,csv'*/],
            
            [['kd_periode'], 'string'],
        ];
    }
   
    
    public function upload()
    {
        if ($this->validate()) {
            $this->excelFile->saveAs('upload_file/' . $this->excelFile->baseName . '.' . $this->excelFile->extension);
            return true;
        } else {
            return false;
        }
    }
}
