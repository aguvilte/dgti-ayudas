<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Expedientes */

$this->title = 'Aviso';
$this->params['breadcrumbs'][] = ['label' => 'Beneficiarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="expedientes-create">
    <div class="jumbotron">
       <h2 class="titulo-area"><?= Html::encode($this->title) ?></h2>
       <hr>
    </div>

    <div class="alert alert-warning fade in alert-dismissable">
        <strong>La persona fue cargada anteriormente y eliminada. Nuevamente está disponible en el sistema. Procure actualizar y/o verificar los datos que acompañan a este antiguo registro.</strong>
    </div>

</div>
