<?php

use yii\data\ArrayDataProvider;
use yii\grid\GridView;

$provider = New ArrayDataProvider([
    'allModels'=>$dt_schedule,
]);

echo GridView::widget([
    'dataProvider'=>$provider,
]);