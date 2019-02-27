<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Expedientes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expedientes-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Crear expediente', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id_expediente',
            'numero',
            [
                'label' => 'Monto total',
                'attribute' => 'monto_total',
                'value' => function($model){
                    // if(!empty($model->id_referente)){
                        return '$' . number_format($model->monto_total, 2, ',', '.');
                    // }
                },
            ],
            [
                'label' => 'Estado',
                'attribute' => 'id_estado',
                'value' => function($model) {
                    if ($model->estado == 1)
                        return 'Activo';
                    else
                        return 'Inactivo';
                }
            ],
            [
                'attribute' => 'fecha_alta',
                'format' => ['date', 'php:d/m/Y']
            ],
            [
                'attribute' => 'fecha_cierre',
                'format' => ['date', 'php:d/m/Y']
            ],
            // 'fecha_cierre',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Ver/Editar/Borrar',
                'template' => '{view} {update}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [ 'title' => Yii::t('app', 'Ver'),'class' => 'btn btn-success btn-xs', ]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [ 'title' => Yii::t('app', 'Editar'),'class' => 'btn btn-primary btn-xs', ]);
                    },
                ],
                'options' => ['class' => 'tbl-col-btn-ben'],
            ],
        ],
    ]); ?>
</div>
