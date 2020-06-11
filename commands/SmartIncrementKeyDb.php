<?php 

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\commands;

/**
 * Description of SmartIncrementKeyDb
 *
 * @author it
 */
trait SmartIncrementKeyDb {
    public static function getLastId($index_name='id')
    {
        //put your code here
        $index = "MAX(".$index_name.")";
        $lat=SELF::find()->SELECT([$index])->scalar();
        if($lat){
            return (int)$lat+1;
        }else { return 1;}
    } 
    
    
}
