<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Listado';

?>

<div class="pdf-ayudas">

    <img src="/img/cabecera.png" alt="La Rioja - Argentina">
    <br>
    <h1 style="text-align: center;color:#0078CF;"><a name="top"></a>Listado de ayudas</h1>

    <br>
    <br>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => '{items}{pager}',
        'columns' => [
            [
                'attribute' => 'id_beneficiario',
                'label' => 'Beneficiario',
                'value' => 'beneficiarios.apeynom',
                'enableSorting' => false
            ],
            [
                'attribute' => 'id_tipo',
                'label' => 'Tipo',
                'value' => 'tiposAyudas.nombre',
                'enableSorting' => false
            ],
            [
                'attribute' => 'monto',
                'label' => 'Monto',
                'value' => function($model) {
                    return '$' . number_format($model->monto, 0, ',', '.');
                },
                'enableSorting' => false
            ],
            [
                'attribute' => 'id_estado',
                'label' => 'Estado',
                'value' => 'estados.nombre',
                'enableSorting' => false
            ],
            [
                'attribute' => 'id_area',
                'label' => 'Area',
                'value' => 'areas.nombre',
                'enableSorting' => false
            ],
            [
                'attribute' => 'id_referente',
                'label' => 'Referente',
                'value' => 'referentes.apeynom',
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