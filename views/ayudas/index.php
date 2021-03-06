<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Beneficiarios;
use app\models\TiposAyudas;
use yii\helpers\ArrayHelper;
use app\models\Estados;
use app\models\Referentes;
use app\models\Areas;
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
        'filterModel' => $searchModel,
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
                // 'filter' => function ($model) {
                //     Beneficiarios::find()->andWhere(['apeynom' => $model->id_beneficiario])->all();
                // }
                'filter' => '',
            ],
            [
                'label' => 'DNI',
                'attribute'=>'id_beneficiario',
                'value'=>function ($model) {
                    if (!empty($model->id_beneficiario))
                    {
                        $beneficiario = beneficiarios::findOne($model->id_beneficiario);
                        if ($beneficiario !== null) {
                            return number_format($beneficiario->documento, 0, ',', '.');
                        }
                    }
                },
            ],
            [
                'label' => 'Tipo de ayuda',
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
                'filter'=> ArrayHelper::map(Estados::find()->groupBy('nombre')->OrderBy(['id_estado' =>SORT_ASC])->all(), 'id_estado', 'nombre'),  
            ],
            [
                'label' => 'Área',
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
                'format' => ['date', 'php:d/m/Y'],
                'filter'=> '',  
            ],
            [
                'attribute' => 'fecha_entrada',
                'format' => ['date', 'php:d/m/Y'],
                'filter'=> '',  
            ],
            [
                'attribute' => 'fecha_nota',
                'format' => ['date', 'php:d/m/Y'],
                'filter'=> '',  
            ],
            // [
            //     'class' => 'yii\grid\DataColumn',
            //     'header' => 'Expediente',
            //     'value' => function($model) {
            //         $ayudaExpediente = AyudasExpedientes::find()->where(['id' => $model->id_ayuda])->one();
            //         if($ayudaExpediente) {
            //             $expediente = Expedientes::findOne($ayudaExpediente->id_expediente)->numero;
            //             return $expediente;
            //         }
            //         else {
            //             return 'No asignado';
            //         }
            //     },
            // ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Ver/Editar/Borrar',
                'template' => '{view} {update} {delete} {devolucion}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [ 'title' => Yii::t('app', 'Ver'),'class' => 'btn btn-success btn-xs', ]);
                    },
                    'update' => function ($url, $model) {
                        if ($model->id_estado==1 or $model->id_estado==3){ 
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [ 'title' => Yii::t('app', 'Editar'),'class' => 'btn btn-primary btn-xs', ]);
                        }
                    },
                    'delete' => function ($url, $model) {
                        if ($model->id_estado == 1) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id_ayuda], [
                                'class' => 'btn btn-danger btn-xs',
                                'data' => [
                                'confirm' => 'Estás seguro de que quieres eliminar este Registro?',
                                'method' => 'post',
                                ],
                            ]);
                        }
                    },
                    'devolucion' => function ($url, $model) {
                        if ($model->id_estado==3) { 
                            return Html::a('<span class="glyphicon glyphicon-th-list"></span>', ['/devoluciones/view', 'id' => $model->id_ayuda], ['title' => Yii::t('app', 'Ver motivo de devolucion'),'class' => 'btn btn-warning btn-xs']);
                        }
                    },
                ],
                'options' => ['class' => 'tbl-col-btn-ben'],
            ],
            // [
            //     'class' => 'yii\grid\ActionColumn',
            //     'header' => 'Agregar/Quitar expediente',
            //     // 'template' => '{view} {update} {delete} {devolucion} {expediente} {expediente2}',
            //     'template' => '{expediente}',
            //     'buttons' => [
            //         'expediente' => function ($url, $model) {
            //             $ayudaExpediente = AyudasExpedientes::find()->where(['id' => $model->id_ayuda])->one();
            //             if($model->id_estado != 4 && !$ayudaExpediente)
            //                 return Html::a('<span class="glyphicon glyphicon-plus"></span>', ['/expedientes/ayudas', 'id' => $model->id_ayuda], ['title' => Yii::t('app', 'Agregar a expediente'),'class' => 'btn btn-success btn-xs']);
            //             else
            //                 return Html::a('<span class="glyphicon glyphicon-minus"></span>', ['/expedientes/ayudas', 'id' => $model->id_ayuda], ['title' => Yii::t('app', 'Quitar de expediente'),'class' => 'btn btn-danger btn-xs']);
            //         },
            //         // 'expediente2' => function ($url, $model) {
            //         //     return Html::a('<span class="glyphicon glyphicon-minus"></span>', ['/expedientes/ayudas', 'id' => $model->id_ayuda], ['title' => Yii::t('app', 'Crear ayuda'),'class' => 'btn btn-danger btn-xs']);
            //         // },
            //     ],
            // ],
        ],
        'options' => ['class' => 'tbl-completa'],
    ]); ?>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><b>Generar listado</b></h5>
            </div>
            <div class="modal-body">
                
                <div class="form-group">
                    <label for="nombreListado">Nombre del listado</label>
                    <input type="text" class="form-control" id="input-nombre-listado">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <!-- <button type="button" class="btn btn-success" id="btn-pdf">Generar</button> -->
            </div>
            </div>
        </div>
    </div>
</div>

<script language="JavaScript" type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src='js/ayudas/index.js'></script>

<!-- <script>
var url_string = window.location.href;
var url = new URL(url_string);
var c = url.searchParams.get("AyudasSearch[id_area]");
console.log(c);
</script> -->