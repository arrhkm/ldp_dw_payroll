<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

use yii\i18n\Formatter;

/* @var $tdis yii\web\View */
/* @var $model app\models\Employee */
/* @var $form yii\widgets\ActiveForm */
$formater = New Formatter();

?>

<?php $this->params['breadcrumbs'][] = ['label'=>'period', 'url'=>['index','id_period']];?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="employee-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_payroll_group')->widget(Select2::className(),[
        'data'=>$group_list,
    ]) ?>

    

    <div class="form-group">
        <?= Html::submitButton('Proses', ['class' => 'btn btn-success']) ?>
        <?php 
        if (isset($model->id_payroll_group) /*&& !$period->is_archive*/){
            echo Html::a('Posting Payroll', ['/period/posting', 'id_period'=>$period->id, 'id_payroll_group'=>$model->id_payroll_group], ['class' => 'btn btn-success']);
        }
    ?>
    </div>

    <?php ActiveForm::end(); ?>
   

</div>

<?php
if (isset($model->id_payroll_group)){
    //var_dump($group->payrollGroupEmployee->employee->reg_number);
    /*
    $provider1 = New ArrayDataProvider([
        'allModels'=>$payroll_group_employee,
        
    ]);

    echo GridView::widget([
        'dataProvider'=>$provider1,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'id_employee', 
            'employee.reg_number',
            'employee.coreperson.name',
            'employee.basic_salary',
            'employee.date_of_hired',
            'id_payroll_group'
        ]
    ]);
    */
    ?>
   
    
    <?php /* echo GridView::widget([
        'dataProvider'=>$providerTest,
    ]);*/?>
    
<?php 
    //var_dump($dt_arr_payroll);

    foreach ($dt_arr_payroll as $dt){ ?>
    <table class="table table-bordered">
        
    <tr class="bg-primary">
        <td scope="col" style="text-align: center">reg_number</td>
        <td colspan ="3" col" style="text-align: center">name</td>
        <td colspan ="10" col" style="text-align: center">PAYROLL PT.LINTECH DUTA PRATAMA</td>
        <td colspan ="" scope="col" style="text-align: center">basic</td>
        <td colspan="2" scope="col" style="text-align: center">doh</td>
    </tr>
  
    
    <tbody>
        <tr class="bg-primary">
            <td><?=$dt['reg_number']?>
            <td colspan="3" style="text-align: center"><?=$dt['employee_name']?></td>
            <td colspan="10" style="text-align: center"><?="Period :".$period->period_name//$dt['employee_name']?></td>
            <td colspan=""><?=$dt['basic']?></td>
            <td colspan="2" style="text-align: center"><?=$dt['doh']?></td>
        </tr>
    </tbody>
    <tbody>
        <tr class="bg-primary">
            <th style="text-align: center">Date</th>
            <th style="text-align: center">Theday</th>
            <th style="text-align: center">in</th>
            <th style="text-align: center">Out</th>
            <th style="text-align: center">O_start</th>
            <th style="text-align: center">O_stop</th>
            <th style="text-align: center">O ev</th>
            <th style="text-align: center">ev</th>
            <th style="text-align: center">ot</th>
            <th>g_basic</th>
            <th>g_ot</th>
            <th>t_mskerja</th>
            <th>Insentif</th>
            <th>telat</th>
            <th>pot_telat</th>
            <th>ket</th>
            <th>sub_total</th>
            

        </tr>
        <?php
        $bg="";
            foreach ($dt['detil'] as $detil){ 
                if ($detil['is_doff']==TRUE){
                    $bg="danger";
                }else {
                    $bg="success";
                }
        ?>
            <tr class=<?=$bg?>>
                <td style="text-align: center"><?=$detil['date_now']?></td>
                <td style="text-align: center"><?=$detil['name_day']?></td>
                <td style="text-align: center"><?=$detil['person_in']?></td>
                <td style="text-align: center"><?=$detil['person_out']?></td>
                <td style="text-align: center"><?=$detil['office_start']?></td>
                <td style="text-align: center"><?=$detil['office_stop']?></td>
                <td style="text-align: center"><?=$detil['o_ev']?></td>
                <td style="text-align: center"><?=$detil['p_ev']?></td>                
                <td style="text-align: center"><?=$detil['ot']?></td>
                <td style="text-align: right"><?=$formater->asCurrency($detil['basic_salary'],'')?></td>
                <td style="text-align: right"><?=$formater->asCurrency($detil['sal_ot'],'')?></td>
                <td style="text-align: right"><?=$formater->asCurrency($detil['t_masakerja'],'')?></td>
                <td style="text-align: right"><?=$detil['ins']?></td>
                <td style="text-align: center"><?=$detil['telat']?></td>
                <td style="text-align: right"><?=$formater->asCurrency($detil['pot_telat'],'')?></td>
                <td style="text-align: center"><?=$detil['ket']?></td>
                <td style="text-align: center"><?=$formater->asCurrency($detil['salary_day'],'')?></td>
            </tr>
            <?php } ?>
            <tr>
                <td colspan="6"><?="Insentif : ".$dt['ins_master']?></td>
                <td colspan=""><?="WT : "?></td>
                <td colspan=""><?=$dt['wt']?></td>
                <td colspan=""><?="PT : "?></td>
                <td colspan=""><?=$dt['pt']?></td>
                <td colspan=""><?=" "?></td>
                <td colspan="3"><?=""?></td>
                <td colspan="2"><?="Total Gaji"?></td>
                <td colspan="1"><?=$formater->asCurrency(round($dt['total_gaji']),'')?></td>
            </tr>
            <tr>
                <td colspan="3">Kasbon :<?=$formater->asCurrency(round($dt['kasbon']),'')?></td>
                <td colspan="4">Total Bayar : <?=$formater->asCurrency($dt['kasbon_total_cicilan'],'')?></td>
                <td colspan="6">Kurang Bayar : <?=$formater->asCurrency($dt['kasbon_kurang_bayar'],'')?></td>
                
                <td colspan=""></td>
                <td colspan="2"><?="Potongan Kasbon"?></td>
                <td colspan="1"><?=$formater->asCurrency(round($dt['kasbon_potongan']),'')?></td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td colspan="4"></td>
                <td colspan="6"></td>
                
                <td colspan=""></td>
                <td colspan="2"><?="Grand Total"?></td>
                <td colspan="1"><?=$formater->asCurrency(round($dt['grand_total_gaji']),'')?></td>
            </tr>
    </tbody>
    </table>
    <?php } 

}
?>
 

