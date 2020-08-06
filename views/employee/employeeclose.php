<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EmployeeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employees';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Employee', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'reg_number',
            [
                'attribute'=>'person_name',
                'value'=>'coreperson.name',
            ],
            'basic_salary',
            'no_bpjstk',
            'no_bpjskes',
            'date_of_hired',
            
            'type',
            //'is_permanent:boolean',
            //'id_jobtitle',
            //'id_division',
            //'id_jobrole',
            //'id_department',
            //'id_coreperson',
            //'email:email',
            //'id_location',
            'is_active:boolean',
            //'id_job_alocation',
            'name',
            

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
