<?php 
namespace app\models;

use yii\base\Model;


class ModelFormImportBpjs extends Model
{
    
    public $excelFile;

    public function rules()
    {
        return [
            [['excelFile'], 'file', 'skipOnEmpty' => false, /*'extensions' => 'xls,xlsx,csv'*/],
            
            
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
