<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CorepersonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Corepeople';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coreperson-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Coreperson', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'birth_date',
            'birth_city',
            'id_card',
            //'phone',
            //'address',
            //'bank_account',
            //'marital_status',
            //'status',
            //'tax_account',
            //'city',
            //'bank_name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
