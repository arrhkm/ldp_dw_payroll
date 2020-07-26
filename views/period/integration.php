<?php

use yii\data\ArrayDataProvider;
use yii\grid\GridView;



    echo GridView::widget([
        'dataProvider'=>$providerIntegrated,
    ]);
/*

if (isset($emp_array)){
    //var_dump($emp_array);
    echo GridView::widget([
        'dataProvider'=>$providerEmp,
    ]);
}
*/
/*
$providerAbsensi = New ArrayDataProvider([
    'allModels'=>$absensi,
]);



echo GridView::widget([
    'dataProvider'=>$providerAbsensi,
]);
*/
/*
foreach ($emp_array as $emp){
    
    echo $emp['reg_number'];
    echo "<br>";
    foreach ($emp['cards'] as $card){
        echo "pin : ".$card['pin']."<br>";

    }
    echo "<br>";
}
*/

//var_dump($integrated_log);