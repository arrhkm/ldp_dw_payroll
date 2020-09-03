<?php

use yii\helpers\Html;
use yii\grid\GridView;

?>
<table class="table">

    
    <?php 
    foreach ($data_period as $dt){?>
    <tbody>
    <thead style="background-color: #C5BEC8;">       
        <th colspan="15" style="text-align: center">PAYROLL <?=$dt['payroll_name']?></th>
    </thead>
    <tr style="background-color: #C5BEC8;">
        <th colspan=""><?="{$dt['reg_number']}"?></th>
        <th colspan="3"><?=$dt['name']?></th>
        <th colspan="9"></th>
        <th colspan="2" style="text-align: right;"><?="D O H : {$dt['doh']}"?></th>
    </tr>
    <tr style="text-align:center; background-color:grey;" >
        <th>Tgl.Payroll</th>
        <th style="text-align:center">Hari</th>
        <th>start</th>
        <th>stop</th>
        <th>in</th>
        <th>out</th>
        <th>ev</th>
        <th>ot</th>
        <th>basic</th>
        <th>ot_salary</th>
        <th>t_masakerja</th>
        <th>insentif</th>
        <th>Potongan</th>
        <th>Ds.Cription</th>
        <th>salary</th>
    </tr> 
        <?php foreach ($dt['list_hari'] as $dtday){?>
        <?php 
        $bg="";
            if ($dtday['isDayOff']==TRUE || $dtday['isDayOffNational']==TRUE){
                $bg="danger";
            }else {
                $bg="success";
            }
        ?>
        <tr class=<?=$bg?>>
            <td  style="text-align:center;"><?=date_format(date_create($dtday['date_now']), 'Y-m-d')?></td>
            <td  style="text-align:center;"><?=$dtday['name_day']?></td>
            <td  style="text-align:center;"><?=$dtday['office_start']?date_format(date_create($dtday['office_start']), 'H'):NULL?></td>
            <td  style="text-align:center;"><?=$dtday['office_stop']?date_format(date_create($dtday['office_stop']), 'H'):NULL?></td>
            <td  style="text-align:center;"><?=$dtday['in']?date_format(date_create($dtday['in']), 'H:i:s'):NULL?></td>
            <td  style="text-align:center;"><?=$dtday['out']?date_format(date_create($dtday['out']), 'H:i:s'):NULL?></td>
            <td  style="text-align:center;"><?=$dtday['ev']?></td>
            <td  style="text-align:center;"><?=$dtday['ot']?></td>
            <td  style="text-align: right;"><?=Yii::$app->formatter->asCurrency($dtday['basic_salary'],'')?></td>
            <td  style="text-align: right;"><?=Yii::$app->formatter->asCurrency($dtday['ot_salary'],'')?></td>
            <td  style="text-align: right;"><?=Yii::$app->formatter->asCurrency($dtday['t_masakerja'],'')?></td>
            <td  style="text-align: right;"><?=Yii::$app->formatter->asCurrency($dtday['insentif'],'')?></td>
            <td  style="text-align: right;"><?=Yii::$app->formatter->asCurrency($dtday['potongan'],'')?></td>
            <td  style="text-align: center;"><?=$dtday['ket']?></td>
            <td  style="text-align: right;"><?=Yii::$app->formatter->asCurrency($dtday['salary_day'],'')?></td>
        </tr>
        <?php }?>
        <tr>
        <th colspan="5">Total</th>
        <th colspan="1">WT/PT</th>
        <th colspan=""><?=$dt['wt']?></th>
        <th colspan=""><?=$dt['pt']?></th>
        <th colspan="6"></th>
        <th colspan="" style="text-align: right;"><?=Yii::$app->formatter->asCurrency($dt['salary_period'],'')?></th>
    </tr>
    <tr>
        <td colspan="12"></td>
        <td colspan="2">Potongan Kasbon</td>
        <td colspan="" style="text-align: right;"><?=Yii::$app->formatter->asCurrency($dt['potongan_kasbon'],'')?></td>
    </tr>
    <tr class="table-dark text-dark">
        <th colspan="12"></th>
        <th colspan="2">Total salary period</th>
        <th colspan="" style="text-align: right;"><?=Yii::$app->formatter->asCurrency($dt['salary_period_total'],'')?></th>
    </tr>
    
    <tr>
        <td colspan="15">dscriprion insentif : <?=$dt['insentif_dscription']?></td>
    </tr>
    <tr>
        <td colspan="15">dscriprion Kasbon : <?=$dt['kasbon_dscription']?></td>
    </tr>
    </tbody>
    <?php }?>



</table>
