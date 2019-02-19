<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Devoluciones */

$this->title = 'Motivo de devolución';
$this->params['breadcrumbs'][] = ['label' => 'Ayudas', 'url' => ['/ayudas/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="devoluciones-view">

    <h2 class="titulo-area"><?= Html::encode($this->title) ?></h2>


    <h4><i class="glyphicon glyphicon-folder-open"></i>&nbsp;&nbsp;Historial de Devoluciones de la Ayuda.</h4>

    <?php
      foreach($Devoluciones as $Devolucion) {

        echo "<div class='panel panel-default'>";
          echo DetailView::widget([
                 'model' => $Devolucion,
                 'attributes' => [
            'descripcion',
            [
                'attribute' => 'fecha',
                'format' => ['date', 'php:d-m-Y']
            ],
                 ],
             ]);
      echo "</div>";
    }
    ?>

</div>
