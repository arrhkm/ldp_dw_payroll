<?php

use function app\components\hkm\println;

echo "success";
foreach ($dt_arr_emp as $dtku){
    foreach ($dtku['list_hari'] as $detil){
        print_r($detil);
    }
}