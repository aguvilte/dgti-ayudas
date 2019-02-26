<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Beneficiarios;
use app\models\TiposAyudas;
use yii\helpers\ArrayHelper;
use app\models\Estados;
use app\models\Referentes;
use app\models\Areas;
use app\models\Observaciones;
use app\models\Expedientes;
use app\models\AyudasExpedientes;

$this->title = 'Consulta General';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ayudas-index">

    <p>
        <?= Html::a('Realizar nueva búsqueda', ['filters'], ['class' => 'btn btn-primary']) ?>
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal" id="btn-pdf">
            Generar PDF
        </button>
        <?= Html::a('Generar Excel', ['excel'], ['class' => 'btn btn-success']) ?>
    </p>

    <h2 class="titulo-area"><?= Html::encode($this->title) ?></h2>    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'rowOptions' => function($model) {
            if($model->id_estado == 3) //0 inconvenientes
                return ['class' => 'danger'];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id_ayuda',
            [
                'label' => 'Apellido y Nombre',
                'attribute' => 'id_beneficiario',
                'value' => function ($model) {
                   if (!empty($model->id_beneficiario)) {
                        $beneficiario = Beneficiarios::findOne($model->id_beneficiario);
                        if ($beneficiario !== null) {
                            return $beneficiario->apeynom;
                        }
                    }
                },
            ],
            [
                'label' => 'Documento',
                'attribute'=>'id_beneficiario',
                'value'=>function ($model) {
                    if (!empty($model->id_beneficiario))
                    {
                        $beneficiario = Beneficiarios::findOne($model->id_beneficiario);
                        if ($beneficiario !== null) {
                            return number_format($beneficiario->documento, 0, ',', '.');
                        }
                    }
                },
            ],
            [
                'label' => 'Tipo de Ayuda',
                'attribute' => 'id_tipo',
                'value' => function($model){
                    if(!empty($model->id_tipo)){
                        $tipo = TiposAyudas::findOne($model->id_tipo);
                        if ($tipo !== null) {
                            return $tipo->nombre;
                        }
                    }
                },
                'filter'=> ArrayHelper::map(TiposAyudas::find()->groupBy('nombre')->all(), 'id_tipo', 'nombre'),  
            ],
            [
                'label' => 'Estado',
                'attribute' => 'id_estado',
                'value' => function($model){
                    if(!empty($model->id_estado)){
                        $estado = Estados::findOne($model->id_estado);
                        if ($estado !== null) {
                            return $estado->nombre;
                        }
                    }
                },
                'filter'=> ArrayHelper::map(Estados::find()->groupBy('nombre')->OrderBy(['id_estado' => SORT_ASC])->all(), 'id_estado', 'nombre'),  
            ],
            [
                'label' => 'Area',
                'attribute' => 'id_area',
                'value' => function($model){
                    if(!empty($model->id_area)){
                        $area = Areas::findOne($model->id_area);
                        if ($area !== null) {
                            return $area->nombre;
                        }
                    }
                },
                'filter'=> ArrayHelper::map(Areas::find()->groupBy('nombre')->all(), 'id_area', 'nombre'),  
            ],
            [
                'label' => 'Referente',
                'attribute' => 'id_referente',
                'value' => function($model){
                    if(!empty($model->id_referente)){
                        $referente = Referentes::findOne($model->id_referente);
                        if ($referente !== null) {
                            return $referente->apeynom;
                        }
                    }
                },
                'filter'=> ArrayHelper::map(Referentes::find()->groupBy('apeynom')->all(), 'id_referente', 'apeynom'),  
            ],
            [
                'label' => 'Monto',
                'attribute' => 'monto',
                'value' => function($model){
                    return number_format($model->monto, 2, ',', '.');
                },
            ],
            [
                'attribute' => 'fecha_pago',
                'format' => ['date', 'php:d/m/Y']
            ],
            [
                'attribute' => 'fecha_entrada',
                'format' => ['date', 'php:d/m/Y']
            ],
            [
                'attribute' => 'fecha_nota',
                'format' => ['date', 'php:d/m/Y']
            ],
            [
                'class' => 'yii\grid\DataColumn',
                'header' => 'Expediente',
                'value' => function($model) {
                    $ayudaExpediente = AyudasExpedientes::find()->where(['id' => $model->id_ayuda])->one();
                    if($ayudaExpediente) {
                        $expediente = Expedientes::findOne($ayudaExpediente->id_expediente)->numero;
                        return $expediente;
                    }
                    else {
                        return 'No asignado';
                    }
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {observaciones} ',
                'buttons' => [
                    'view' => function ($url, $model) {
                        if($model->id_estado != 1)
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [ 'title' => Yii::t('app', 'Ver'),'class' => 'btn btn-success btn-xs', ]);
                    },
                    'observaciones' => function ($url, $model) {
                        $observaciones= Observaciones::find()
                            ->where(['id_ayuda'=>$model->id_ayuda])
                            ->all();
                        if(!empty($observaciones)) {
                            return Html::a('<span class="glyphicon glyphicon-tags"></span>', ['/observaciones/view', 'id' => $model->id_ayuda], ['title' => Yii::t('app', 'Observaciones'),'class' => 'btn btn-warning btn-xs']);
                        } else {
                            return Html::a('<span class="glyphicon glyphicon-tags"></span>', ['/observaciones/view', 'id' => $model->id_ayuda], ['title' => Yii::t('app', 'Observaciones'),'class' => 'btn btn-info btn-xs']);
                        }
                    },
                ],
                'options' => ['class' => 'tbl-col-btn-ben'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Agregar/Quitar expediente',
                // 'template' => '{view} {update} {delete} {devolucion} {expediente} {expediente2}',
                'template' => '{expediente}',
                'buttons' => [
                    'expediente' => function ($url, $model) {
                        $ayudaExpediente = AyudasExpedientes::find()->where(['id' => $model->id_ayuda])->one();
                        if($model->id_estado != 4 && !$ayudaExpediente)
                            return Html::a('<span class="glyphicon glyphicon-plus"></span>', ['/expedientes/ayudas', 'id' => $model->id_ayuda], ['title' => Yii::t('app', 'Agregar a expediente'),'class' => 'btn btn-success btn-xs']);
                        else
                            return Html::a('<span class="glyphicon glyphicon-minus"></span>', ['/expedientes/ayudas', 'id' => $model->id_ayuda], ['title' => Yii::t('app', 'Quitar de expediente'),'class' => 'btn btn-danger btn-xs']);
                    },
                    // 'expediente2' => function ($url, $model) {
                    //     return Html::a('<span class="glyphicon glyphicon-minus"></span>', ['/expedientes/ayudas', 'id' => $model->id_ayuda], ['title' => Yii::t('app', 'Crear ayuda'),'class' => 'btn btn-danger btn-xs']);
                    // },
                ],
            ],
        ],
        'options' => ['class' => 'tbl-completa'],
    ]); ?>
</div>

<script src='js/pago/index.js'></script>
<script>
   /*   btnPDF = document.getElementById('btn-pdf');
          inputCodigo = document.getElementsByClassName('form-control')[1];
          inputCodigo2 = document.getElementsByClassName('form-control')[2];
          inputCodigo3 = document.getElementsByClassName('form-control')[3];
          inputCodigo4 = document.getElementsByClassName('form-control')[4];
          inputCodigo5 = document.getElementsByClassName('form-control')[5];
          btnPDF.addEventListener('click', function() {
              var searchParams = new URLSearchParams(window.location.search);
              searchParams.set('r','pago/mpdf')
              searchParams.set('inputdni', inputCodigo.value)
              searchParams.set('inputtipoayuda', inputCodigo2.value)
              searchParams.set('inputestado', inputCodigo3.value)
              searchParams.set('inputmonto', inputCodigo4.value)
              searchParams.set('inputarea', inputCodigo5.value)
              var newParams = searchParams.toString()
              
              var nuevaURL = location.protocol + '//' + location.host + location.pathname + '?' + newParams;
              // window.location = nuevaURL;
              window.open(nuevaURL, '_blank');
          });
    inputCodigo0 = document.getElementsByClassName('form-control')[0];
    inputCodigo6 = document.getElementsByClassName('form-control')[6];
    inputCodigo7 = document.getElementsByClassName('form-control')[7];
    inputCodigo8 = document.getElementsByClassName('form-control')[8];
    
    inputCodigo0.parentNode.removeChild(inputCodigo0);
    inputCodigo6.parentNode.removeChild(inputCodigo6);
    inputCodigo7.parentNode.removeChild(inputCodigo7);
    inputCodigo8.parentNode.removeChild(inputCodigo8); */
</script>