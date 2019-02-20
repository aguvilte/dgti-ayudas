<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Listado';

?>

<div class="pdf-ayudas">

    <!-- <img src="img/encabezado-listados.png"> -->

    <br>
    <br>
    <h1 style="text-align: center;"><?= Html::encode($this->title) ?> </h1>
    <br>
    <br>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => '{items}{pager}',
        'columns' => [
            [
                'attribute' => 'id_tipo',
                'label' => 'Tipo',
                'value' => 'tipo.nombre',
                'enableSorting' => false
            ],
            [
                'attribute' => 'id_estado',
                'label' => 'Estado',
                'value' => 'estado.nombre',
                'enableSorting' => false
            ],
            [
                'attribute' => 'id_area',
                'label' => 'Area',
                'value' => 'area.nombre',
                'enableSorting' => false
            ],
            [
                'attribute' => 'id_referente',
                'label' => 'Referente',
                'value' => 'referente.nombre',
                'enableSorting' => false
            ],
            [
                'attribute' => 'fecha_entrada',
                'format' => ['date', 'php:d/m/Y'],
                'enableSorting' => false
            ],
            [
                'attribute' => 'fecha_pago',
                'format' => ['date', 'php:d/m/Y'],
                'enableSorting' => false
            ],
            // [
            //     'attribute' => 'id_titulo',
            //     'label' => 'Título',
            //     'value' => 'titulo.nombre',
            //     'enableSorting' => false
            // ],
            // [
            //     'attribute' => 'concepto',
            //     'label' => 'Concepto',
            //     'value' => 'concepto',
            //     'enableSorting' => false
            // ],
            // [
            //     'attribute' => 'id_area',
            //     'label' => 'Área',
            //     'value' => 'area.nombre',
            //     'enableSorting' => false
            // ],
        ],
    ]); ?>
</div>
