<?php

use app\models\Period;
use kartik\base\Widget;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AdjustmentSalarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Adjustment Salaries';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adjustment-salary-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Adjustment Salary', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php $form = ActiveForm::begin(); ?>

    <?=$form->field($model, 'period_id')->widget(Select2::class,[
        'data'=>ArrayHelper::map(Period::find()->orderBy(['end_date'=>SORT_DESC])->all(), 'id', 'end_date'),
    ])?>

    <div class="form-group">
        <?= Html::submitButton('Go', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end();?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'date_adjustment',
            'value_adjustment',
            'code_adjustment',
            'description',
            //'id_employee',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
