<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Kasbon */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Detil Plan Kasbon create: ';
$this->params['breadcrumbs'][] = ['label' => 'View Plan', 'url' => ['kasbon-plan', 'id'=>$kasbon->id]];
$this->params['breadcrumbs'][] = 'Create Plan';
?>

<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_form-plan', [
         'model'=>$model,
         'kasbon'=>$kasbon,
    ]) ?>


