<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UbahGaji */
/* @var $form yii\widgets\ActiveForm */
?>
<h1><?php echo $update;?></h1>

<div class="employee-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'gaji_lama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gaji_baru')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php 
	if (isset($employee)){
		
		foreach ($employee as $data){?>
			<table "border=1" >
			<tr><td>
			<?php
				echo $data['emp_name']." -->".$data['pot_jamsos']." Jadi --> ".$model->gaji_baru; 
			?>
			</td></tr>
			</table>
			<?php 
		}  
	}
?>