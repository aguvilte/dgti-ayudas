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


    <h4><i class="glyphicon glyphicon-folder-open"></i>&nbsp;&nbsp;Historial de devoluciones de la ayuda.</h4>

    <?php
      foreach($devoluciones as $devolucion) {

        echo "<div class='panel panel-default'>";
          echo DetailView::widget([
                 'model' => $devolucion,
                 'attributes' => [
            'descripcion',
            [
                'attribute' => 'fecha',
                'format' => ['date', 'php:d/m/Y']
            ],
                 ],
             ]);
      echo "</div>";
    }
    ?>

</div>
