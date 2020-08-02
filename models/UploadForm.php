<?php
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model{
    public $excelFile;
    
    public function rules()
    {
        return [
            [['excelFile'], 'file', 'skipOnEmpty' => false, /*'extensions' => 'xls,xlsx,csv'*/],
            //[['id_period'], 'integer'],
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