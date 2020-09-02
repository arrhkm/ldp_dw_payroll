<?php

use yii\helpers\Html;
use yii\grid\GridView;

?>
<table class="table">

    
    <?php 
    foreach ($data_period as $dt){?>
    <tbody>
    <thead style="background-color: greenyellow;">
        <th colspan="">Reg Number</th>
        <th colspan="">Nama</th>
        <th colspan="10" style="text-align: center">PAYROLL <?=$dt['payroll_name']?></th>
        <th colspan="2" style="text-align: center">DOH</th>
    </thead>
    <tr style="background-color: greenyellow;">
        <th><?=$dt['reg_number']?></th>
        <th colspan="2"><?=$dt['name']?></th>
        <th colspan="9"></th>
        <th colspan="2" style="text-align: center;"><?=$dt['doh']?></th>
    </tr>
    <tr>
        <th>tanggal</th>
        <th>Hari</th>
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
            <td><?=date_format(date_create($dtday['date_now']), 'dMy')?></td>
            <td><?=$dtday['name_day']?></td>
            <td><?=$dtday['in']?date_format(date_create($dtday['in']), ' h:i:s'):NULL?></td>
            <td><?=$dtday['out']?date_format(date_create($dtday['out']), 'h:i:s'):NULL?></td>
            <td><?=$dtday['ev']?></td>
            <td><?=$dtday['ot']?></td>
            <td><?=Yii::$app->formatter->asCurrency($dtday['basic_salary'],'')?></td>
            <td><?=Yii::$app->formatter->asCurrency($dtday['ot_salary'],'')?></td>
            <td><?=Yii::$app->formatter->asCurrency($dtday['t_masakerja'],'')?></td>
            <td><?=Yii::$app->formatter->asCurrency($dtday['insentif'],'')?></td>
            <td><?=Yii::$app->formatter->asCurrency($dtday['potongan'],'')?></td>
            <td><?=$dtday['ket']?></td>
            <td><?=Yii::$app->formatter->asCurrency($dtday['salary_day'],'')?></td>
        </tr>
        <?php }?>
        <tr>
        <th colspan="3">Total</th>
        <th colspan="">WT/PT</th>
        <th colspan=""><?=$dt['wt']?></th>
        <th colspan=""><?=$dt['pt']?></th>
        <th colspan="6"></th>
        <th colspan=""><?=Yii::$app->formatter->asCurrency($dt['salary_period'],'')?></th>
    </tr>
    <tr>
        <td colspan="12">Potongan Kasbon</td>
        <td colspan=""><?=Yii::$app->formatter->asCurrency($dt['potongan_kasbon'],'')?></td>
    </tr>
    <tr class="table-dark text-dark">
        <th colspan="12">Total salary period</th>
        <th colspan=""><?=Yii::$app->formatter->asCurrency($dt['salary_period_total'],'')?></th>
    </tr>
    
    <tr>
        <td colspan="13">dscriprion insentif : <?=$dt['insentif_dscription']?></td>
    </tr>
    </tbody>
    <?php }?>



</table>
