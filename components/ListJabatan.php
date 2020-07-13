<?php
namespace app\components;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\Jabatan;


class ListJabatan {
    public function getJabatanList(){
        $emp = Jabatan::find()->all();
        return ArrayHelper::map($emp, 'kd_jabatan', 'nama_jabatan');
    }

}