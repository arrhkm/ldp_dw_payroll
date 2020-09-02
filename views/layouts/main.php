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
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
  
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url'=>['/site/index/']],
            //['label' => 'App Old', 'url' =>['<a href=www.google.com>']],
            ['label' => 'Employee', 'url' => ['#'], 'items'=>[
                ['label' => 'Employee Active', 'url' => ['/employee']],
                ['label' => 'Employee Close', 'url' => ['/employee/employeeclose']],
                ['label' => 'Person', 'url' => ['/coreperson']],
               
                ['label' => 'contract', 'url' => ['/contract']],
                /*['label' => 'Anggota Foreman', 'url' => ['/childforeman']],
                ['label' => 'Ubah Gaji', 'url' => ['/employee/ubahgaji']],
                ['label' => 'Ubah Jamsostek', 'url' => ['/employee/ubahjamsostek']],
                ['label' => 'Plusmin Gaji', 'url' => ['/plusmin/']],
                */

                
            ]],
            //['label' => 'Tarif Masakerja', 'url'=>['/tarifmasakerja/']],
            ['label' => 'Configure', 'url'=>['#'], 'items'=>[
                //['label' => 'Jabatan', 'url'=>['/jabatan/']],
                ['label'=>'Payroll Group', 'url'=>['/payrollgroup/']],
                ['label' => 'Master Insentif', 'url'=>['/insentifmaster/']],
                ['label'=>'Leave Type', 'url'=>['/leavetype']],
                ['label' => 'Timeshift', 'url'=>['/timeshift']],
                ['label' => 'Setup Timeshift Option', 'url'=>['/timeshiftoption']],
                ['label'=>'Component Payroll Daily','url'=>['/componentpayroll']],
                ['label'=>'Dayoff', 'url'=>['/dayoff']],
                ['label'=>'Component Payroll Group', 'url'=>['/componentpayroll']],
                ['label'=>'Component Payroll Detil', 'url'=>['/componentgroup']],
            ]],
            /*['label' => 'Tunjangan', 'url'=>['#'], 'items'=>[
                ['label' => 'Jenis Tunjangan', 'url'=>['/jenistunjangan/']],
                ['label' => 'Insert Tunjangan', 'url'=>['/tunjangan/']],
            ]],
            */
            ['label' => 'Periode', 'url'=>['/period/'], 'items'=>[
                ['label' => 'Periode', 'url'=>['/period/']],
                ['label'=>'Insentif', 'url'=>['/insentif/']],
            ]],
            ['label' => 'Insentif', 'url'=>['#'], 'items'=>[
                ['label'=>'Insentif Employee', 'url'=>['/insentif/']],
            ]],
            ['label' => 'S P K L', 'url'=>['#'], 'items'=>[
                ['label' => 'Surat Perintah Lembur(SPL)', 'url'=>['/spkl/']],
                
            ]],
            ['label' => 'Deduction $ Reduction', 'url'=>['#'], 'items'=>[
                ['label' => 'Kasbon', 'url'=>['/kasbon/']],
                ['label' => 'Kasbon Close', 'url'=>['/kasbon/close']],
                ['label'=>'Daily Component','url'=>['/dailycomponent']],
                ['label'=>'Daily Component Detil','url'=>['/dailycomponentdetil/']],
                
            ]],
            ['label' => 'Attendance', 'url'=>['#'], 'items'=>[
                ['label' => 'Machine', 'url'=>['/attmachine']],
                
                
                ['label' => 'Setup Timeshift Employee', 'url'=>['/timeshiftemployee']],
               
                //['label' => 'Integrasi', 'url'=>['/attmachine/integration']],
                ['label' => 'card', 'url'=>['/cardlog']],
                ['label'=>'Absensi', 'url'=>['/attendance']],
                ['label'=>'Set Pulang', 'url'=>['/absensi/setpulang']],
                
                ['label'=>'Leaves', 'url'=>['/leave']],

            ]],
            //['label' => 'Sales Order', 'url'=>['/salesorder/']],
           
            //['label' => 'Contact', 'url' => ['/site/contact']],
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
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
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
