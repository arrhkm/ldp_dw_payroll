<?php
namespace app\commands;


use yii\console\Controller;
use Yii;

class HakamController extends Controller 
{
    public $message;
    
    public function options($actionID)
    {
        return ['message'];
    }
    
    public function optionAliases()
    {
        return ['m' => 'message'];
    }
    
    public function actionIndex()
    {
        if (empty($this->message)){
            $this->message = "Hello World";
        }
        echo $this->message . "\n";
    }

    public function actionMasakerja(){
               

        $sql = "UPDATE employee SET is_active=TRUE WHERE id =3";
        Yii::$app->db->createCommand($sql)->execute();
       
        /*foreach ($command as $t){
            echo $t['id'];
        }*/
    }
}

