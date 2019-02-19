<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Expedientes */

$this->title = 'Actualización Exitosa';
$this->params['breadcrumbs'][] = ['label' => 'Pago', 'url' => ['/pago/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="expedientes-create">
    <div class="jumbotron">
       <h2 class="titulo-area"><?= Html::encode($this->title) ?></h2>
       <hr>
    </div>

    <div class="alert alert-success fade in alert-dismissable">
        <strong>La Ayuda fue regresada al area de Carga para su revisión.</strong>
    </div>

</div>
