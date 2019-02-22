<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\TiposArchivos;
use app\models\Relaciones;
use app\models\Archivos;

?>
<div class="archivos-view">

    <h1 style="text-align: center;">Normas que modifica/complementa 
        <?php
        // echo TiposArchivos::findOne($model->id_tipo_archivo)->nombre . ' ';
        // echo $model->numero;
        ?>
    </h1>
    <br>
    <br>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'id_accion',
                'label' => ' ',
                'value' => 'acciones.nombre',
            ],
            [
                'attribute' => 'descripcion',
            ],
            [
                'attribute' => 'tipo_archivo_modificado',
                'label' => 'Norma',
                'value' => function($model) {
                    return $model->tipo_archivo_modificado . ' ';
                }
            ],
            [
                'attribute' => 'id_modificado',
                'label' => 'Número',
                'value' => 'modificados.numero',
            ],
            [
                'attribute' => 'fecha_modificado',
                'label' => 'Fecha',
                'format' => ['date', 'php:d/m/Y'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span> Ver detalles', 'index.php?r=archivos/view&id=' . $model->id_modificado, ['style' => 'font-size: 11px;']);
                    }     
                ],
                'headerOptions' => ['style' => 'width: 9%'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{viewpdf}',
                'buttons' => [        
                    'viewpdf' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span> Ver PDF', Archivos::findOne($model->id_modificado)->ruta_pdf, ['style' => 'font-size: 11px;', 'target' => '_blank']);
                    }        
                ],
                'headerOptions' => ['style' => 'width: 9%'],
            ],
        ],
    ]) ?>
    <br>

</div>