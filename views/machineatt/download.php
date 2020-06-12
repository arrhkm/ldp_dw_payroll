<?php 
use yii\helpers\Html;
use yii\grid\GridView; 

//Yii::$app->jancok->display('Hello kamu sedang coba apa Cokkk ');
//var_dump($x);

echo "ip :".$machine['ip']."<br>";
        //$port='80';
echo "port :".$machine['port']."<br>";		
        //$com=0;
echo "com  :".$machine['com']."<br>";

echo GridView::widget([
        'dataProvider' => $rows,
]);