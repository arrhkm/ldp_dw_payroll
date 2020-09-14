<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

//$urlku = "../".$baseUrl."/payroll_lsf_v2";
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    $image_url = Yii::$app->basePath."/web";
    NavBar::begin([
        'brandLabel' => '<img src="lintech.png" class="pull-left"/> L I N T E C H', //Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
           // 'class' => 'navbar-inverse navbar-fixed-top',
            'class'=> 'navbar-default navbar-fixed-top', 
        ],
    ]);
  
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],       
        'items' => [
            ['label' => 'HOME', 'url'=>['/site/index/']],
            
            ['label' => 'EMPLOYEE', 'url' => ['#'], 'items'=>[
                ['label' => 'Employee Active', 'url' => ['/employee']],
                ['label' => 'Employee Close', 'url' => ['/employee/employeeclose']],
                ['label' => 'Person', 'url' => ['/coreperson']],
                ['label' => 'Contract', 'url' => ['/contract']],
            ]],
           
            ['label' => 'CONFIG', 'url'=>['#'], 'items'=>[
                //['label' => 'Jabatan', 'url'=>['/jabatan/']],
                ['label'=>'Payroll Group', 'url'=>['/payrollgroup/']],
                ['label' => 'Master Insentif', 'url'=>['/insentifmaster/']],
                ['label'=>'Master Leave Type', 'url'=>['/leavetype']],
                ['label' => 'Master Timeshift', 'url'=>['/timeshift']],
                ['label' => 'Setup Timeshift Option', 'url'=>['/timeshiftoption']],                
                ['label'=>'Dayoff', 'url'=>['/dayoff']],
                ['label'=>'Payroll Dihitung', 'url'=>['/payrolldihitung']],                
              
            ]],
           
            ['label' => 'PERIOD', 'url'=>['/period/'], 'items'=>[
                ['label' => 'Periode', 'url'=>['/period/']],
                ['label'=>'Insentif', 'url'=>['/insentif/']],
            ]],
            
            ['label' => 'SPK LEMBUR', 'url'=>['#'], 'items'=>[
                ['label' => 'Surat Perintah Lembur(SPL)', 'url'=>['/spkl/']],
                
            ]],
            ['label' => 'DEDUCTION', 'url'=>['#'], 'items'=>[
                ['label'=>'Insentif Employee', 'url'=>['/insentif/']],
                ['label' => 'Kasbon', 'url'=>['/kasbon/']],
                ['label' => 'Kasbon Close', 'url'=>['/kasbon/close']],
                ['label'=>'Component Pengurangan', 'url'=>['/componentpayroll']],
                ['label'=>'Component Daily Covid19','url'=>['/dailycomponent']],
                ['label'=>'BPJS', 'url'=>['/bpjs']],
                
                
            ]],
            ['label' => 'ATTENDANCE', 'url'=>['#'], 'items'=>[
                ['label' => 'Machine', 'url'=>['/attmachine']],
                ['label' => 'Machine Coba', 'url'=>['/attmachine/coba']],                
                ['label' => 'Setup Timeshift Employee', 'url'=>['/timeshiftemployee']],     
                ['label' => 'card', 'url'=>['/cardlog']],
                ['label'=>'Absensi', 'url'=>['/attendance']],
                ['label'=>'Set Pulang', 'url'=>['/absensi/setpulang']],
                ['label'=>'Leaves', 'url'=>['/leave']],
            ]],
            ['label' => 'LEAVE', 'url'=>['#'], 'items'=>[
                ['label' => 'Cuti & Sakit', 'url'=>['/leave']],
                ['label' => 'Sakit Lama', 'url'=>['/sakitlama']],
            ]],
           
            //['label' => 'Contact', 'url' => ['/site/contact']],
            Yii::$app->user->isGuest ? (
                ['label' => 'LOGIN', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'LOGOUT (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; PT. LINTECH DUTA PRATAMA <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
