<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Listado';

?>

<div class="pdf-ayudas">

    <!-- <img src="img/encabezado-listados.png"> -->

    <img src="/img/cabecera.png" alt="La Rioja - Argentina">
    <br>
    <h1 style="text-align: center;color:#0078CF;"><a name="top"></a>Listado de ayudas</h1>

    <br>
    <br>

    <?php 
    if($_GET['filtros'] == 'v') {
        echo '<h4><b>Filtros aplicados:</b></h4>';
    
        if($_GET['dni'])
            echo '<p style="margin-left: 8%;"><b>DNI de beneficiario:</b> ' . $_GET['dni'] . '</p>';
    
        if($_GET['tipo'])
            echo '<p style="margin-left: 8%;"><b>Tipo de ayuda:</b> ' . $_GET['tipo'] . '</p>';
    
        if($_GET['estado'])
            echo '<p style="margin-left: 8%;"><b>Estado:</b> ' . $_GET['estado'] . '</p>';
            
        if($_GET['area'])
            echo '<p style="margin-left: 8%;"><b>Área:</b> ' . $_GET['area'] . '</p>';
        
        if($_GET['referente'])
            echo '<p style="margin-left: 8%;"><b>Referente:</b> ' . $_GET['referente'] . '</p>';
    
        if($_GET['usuario'])
            echo '<p style="margin-left: 8%;"><b>Usuario de carga:</b> ' . $_GET['usuario'] . '</p>';
    
        if($_GET['monto'])
            echo '<p style="margin-left: 8%;"><b>Monto:</b> $' . number_format($_GET['monto'], 0, ',', '.') . '</p>';

        echo '<br><br>';
    }
    ?>


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
