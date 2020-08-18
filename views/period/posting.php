<?php

use function app\components\hkm\println;

echo "success";
foreach ($dt_arr_emp as $dtku){
    foreach ($dtku['detil'] as $detil){
        print_r($detil);
    }
}