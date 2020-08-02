<?php 
namespace app\components\hkm;

class NameDay {

    static function getName($date_now){
        $i = date_create($date_now);
        switch($i->format('N')){            
            case 1 : $hari = "Senin"; break;
            case 2 : $hari = "Selasa"; break;
            case 3 : $hari = "Rabu"; break;
            case 4 : $hari = "Kamis"; break;
            case 5 : $hari = "Jumat"; break;
            case 6 : $hari = "Sabtu"; break;
            case 7 : $hari = "Minggu"; break;
        }
        return $hari;
    }
}