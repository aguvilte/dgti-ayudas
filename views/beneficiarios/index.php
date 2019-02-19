<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Beneficiarios';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="beneficiarios-index">

    <h2 class="titulo-area"><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::a('Crear persona', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'apeynom',
            'documento',
            'domicilio',
            [
                'attribute' => 'pdf_dni',
                'label' => 'DNI',
                'format' => 'raw',
                'value' => function ($model) {
                    if (!empty($model->pdf_dni))
                        return Html::a('<span class="glyphicon glyphicon-file"></span>', $model->pdf_dni, ['title' => Yii::t('app', 'Ver Pdf'), 'target'=>'_blank', 'class' => 'btn btn-success btn-xs']) . ' ' . Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', ['updatepdfdni', 'id' => $model->id_beneficiario], ['title' => Yii::t('app', 'Actualizar PDF'), 'target'=>'_blank', 'class' => 'btn btn-info btn-xs']);
                    else
                        return Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', ['updatepdfdni', 'id' => $model->id_beneficiario ], ['title' => Yii::t('app', 'Subir PDF'), 'target'=>'_blank', 'class' => 'btn btn-info btn-xs']);
                },
                'options' => ['class' => 'tbl-col-pdf-ben'],
                'headerOptions' => ['style' => 'width: 7%'],
            ],
            [
                'attribute' => 'pdf_cuil',
                'label' => 'CUIL',
                'format' => 'raw',
                'value' => function ($model) {
                    if (!empty($model->pdf_cuil))
                        return Html::a('<span class="glyphicon glyphicon-file"></span>', $model->pdf_cuil, ['title' => Yii::t('app', 'Ver Pdf'), 'target'=>'_blank', 'class' => 'btn btn-success btn-xs']) . ' ' . Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', ['updatepdfcuil', 'id' => $model->id_beneficiario ], ['title' => Yii::t('app', 'Actualizar PDF'), 'target'=>'_blank', 'class' => 'btn btn-info btn-xs']);
                    else
                        return Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', ['updatepdfcuil', 'id' => $model->id_beneficiario ], ['title' => Yii::t('app', 'Subir PDF'), 'target'=>'_blank', 'class' => 'btn btn-info btn-xs']);
                },
                'options' => ['class' => 'tbl-col-pdf-ben'],
                'headerOptions' => ['style' => 'width: 7%'],
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {crear} {historial}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [ 'title' => Yii::t('app', 'Ver'),'class' => 'btn btn-success btn-xs', ]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [ 'title' => Yii::t('app', 'Editar'),'class' => 'btn btn-primary btn-xs', ]);
                    },
                    'crear' => function ($url, $model) {
                        if ($model->estado == '1') //0 Desactivada
                            return Html::a('<span class="glyphicon glyphicon-plus"></span>', ['/ayudas/create', 'id' => $model->id_beneficiario , 'documento' => $model->documento], ['title' => Yii::t('app', 'Crear ayuda'),'class' => 'btn btn-warning btn-xs']);
                    },
                ],
                'options' => ['class' => 'tbl-col-btn-ben'],
            ],
        ],
        'options' => ['class' => 'tbl-completa'],
    ]);
     ?>
</div>

<script>
    inputCodigo1 = document.getElementsByClassName('form-control')[3];
    inputCodigo2 = document.getElementsByClassName('form-control')[4];
    
    inputCodigo1.parentNode.removeChild(inputCodigo1);
    inputCodigo2.parentNode.removeChild(inputCodigo2);
</script>