<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Expedientes */

$this->title = 'Actualización Exitosa';
$this->params['breadcrumbs'][] = ['label' => 'Ayudas', 'url' => ['/ayudas/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="expedientes-create">
    <div class="jumbotron">
       <h2 class="titulo-area"><?= Html::encode($this->title) ?></h2>
       <hr>
    </div>

    <div class="alert alert-success fade in alert-dismissable">
        <strong>Felicidades. La Ayuda fue enviada al área de pago.</strong>
    </div>

</div>
