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
                ['label' => 'Master EMployee', 'url' => ['/employee/']],
                ['label' => 'Insetif Rresiko', 'url' => ['/iresiko/']],
                ['label' => 'Foreman', 'url' => ['/foreman']],
                ['label' => 'Anggota Foreman', 'url' => ['/childforeman']],
                ['label' => 'Ubah Gaji', 'url' => ['/employee/ubahgaji']],
                ['label' => 'Ubah Jamsostek', 'url' => ['/employee/ubahjamsostek']],
                ['label' => 'Plusmin Gaji', 'url' => ['/plusmin/']],
                

                
            ]],
            ['label' => 'Tarif Masakerja', 'url'=>['/tarifmasakerja/']],
            ['label' => 'Configure', 'url'=>['#'], 'items'=>[
                ['label' => 'Jabatan', 'url'=>['/jabatan/']],
                //['label' => 'Insert Tunjangan', 'url'=>['/tunjangan/']],
            ]],
            ['label' => 'Tunjangan', 'url'=>['#'], 'items'=>[
                ['label' => 'Jenis Tunjangan', 'url'=>['/jenistunjangan/']],
                ['label' => 'Insert Tunjangan', 'url'=>['/tunjangan/']],
            ]],
            ['label' => 'Periode', 'url'=>['/periode/']],
            ['label' => 'S P L', 'url'=>['#'], 'items'=>[
                ['label' => 'Surat Perintah Lembur(SPL)', 'url'=>['/spl/']],
                
            ]],
            ['label' => 'Attendance', 'url'=>['#'], 'items'=>[
                ['label' => 'Machine Att', 'url'=>['/machineatt']],
                ['label' => 'Integrasi', 'url'=>['/machineatt/integrasi']],
                ['label'=>'Absensi', 'url'=>['/absensi/']],
                ['label'=>'Set Pulang', 'url'=>['/absensi/setpulang']],

            ]],
            ['label' => 'Sales Order', 'url'=>['/salesorder/']],
           
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
