<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Beneficiarios;
use app\models\TiposAyudas;
use yii\helpers\ArrayHelper;
use app\models\Estados;
use app\models\Referentes;
use app\models\Areas;



/* @var $this yii\web\View */
/* @var $searchModel app\models\AyudasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

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

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    

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
                        $beneficiario = beneficiarios::findOne($model->id_beneficiario);
                        if ($beneficiario !== null) {
                            return $beneficiario->apeynom;
                        }
                    }
                },
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
                    if(!empty($model->id_referente)){
                        return number_format($model->monto, 2, ',', '.');
                    }
                },
            ],
            //'entrega_dni',
            //'entrega_cuil',
            // 'asunto',
            //  'monto',
            // 'fecha_nota',
            // 'doc_adjunta',
             //'area',
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
            // 'encargado',
            // 'pdf_doc_adjunta',
            // 'pdf_nota',
            // 'pdf_gestor',
            // 'pdf_domicilio',
            // 'id_beneficiario',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {devolucion} {expediente}',
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
                    'expediente' => function ($url, $model) {
                        
                        
                        return Html::a('<span class="glyphicon glyphicon-plus"></span>', ['/expedientes/ayudas', 'id' => $model->id_ayuda], ['title' => Yii::t('app', 'Crear ayuda'),'class' => 'btn btn-warning btn-xs']);
                    },
                ],
                'options' => ['class' => 'tbl-col-btn-ben'],
            ],
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

<script src='js/ayudas/index.js'></script>
<script>
   /*  btnPDF = document.getElementById('btn-pdf');
          inputCodigo = document.getElementsByClassName('form-control')[1];
          inputCodigo2 = document.getElementsByClassName('form-control')[2];
          inputCodigo3 = document.getElementsByClassName('form-control')[3];
          inputCodigo4 = document.getElementsByClassName('form-control')[4];
          inputCodigo5 = document.getElementsByClassName('form-control')[5];
          btnPDF.addEventListener('click', function() {
              var searchParams = new URLSearchParams(window.location.search);
              searchParams.set('r','ayudas/mpdf')
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