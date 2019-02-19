<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Beneficiarios;
use app\models\TiposAyudas;
use yii\helpers\ArrayHelper;
use app\models\Estados;


/* @var $this yii\web\View */
/* @var $searchModel app\models\AyudasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Consulta General';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ayudas-index">

    <h2 class="titulo-area"><?= Html::encode($this->title) ?></h2>
   <button class="btn btn-danger" id="btn-pdf">Generar pdf</button>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id_ayuda',
            [
                'label' => 'Apellido y Nombre',
                'attribute'=>'id_persona',
                'value'=>function ($model) {
                   if (!empty($model->id_persona))
                   {
                      $persona = beneficiarios::findOne($model->id_persona);
                      if ($persona !== null) {
                          return $persona->apeynom;
                      }
                   }
                },
              ],
              [
                'label' => 'Documento',
                'attribute'=>'id_persona',
                'value'=>function ($model) {
                   if (!empty($model->id_persona))
                   {
                      $persona = beneficiarios::findOne($model->id_persona);
                      if ($persona !== null) {
                          return $persona->documento;
                      }
                   }
                },
              ],
            [
                'label' => 'Tipo de Ayuda',
                'attribute' => 'id_tipo',
                'value' => function($model){
                   if(!empty($model->id_tipo)){
                     $Tipo = TiposAyudas::findOne($model->id_tipo);
                     if ($Tipo !== null) {
                       return $Tipo->nombre;
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
                'filter'=> ArrayHelper::map(Estados::find()->groupBy('nombre')->all(), 'id_estado', 'nombre'),  
            ],
            //'entrega_dni',
            //'entrega_cuil',
            // 'asunto',
             'monto',
            // 'fecha_nota',
            // 'doc_adjunta',
             'area',
             [
                'attribute' => 'fecha_pago',
                'format' => ['date', 'php:d-m-Y']
            ],
             [
                'attribute' => 'fecha_entrada',
                'format' => ['date', 'php:d-m-Y']
            ],
            [
                'attribute' => 'fecha_nota',
                'format' => ['date', 'php:d-m-Y']
            ],
            // 'encargado',
            // 'pdf_doc_adjunta',
            // 'pdf_nota',
            // 'pdf_gestor',
            // 'pdf_domicilio',
            // 'id_persona',

            [
             'class' => 'yii\grid\ActionColumn',
             'template' => '{view} {pagar} {regresar}',
             'buttons' => [
                           'view' => function ($url, $model)
                                    {
                                       if($model->id_estado != 1 and $model->id_estado != 4)
                                       return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [ 'title' => Yii::t('app', 'Ver'),'class' => 'btn btn-success btn-xs', ]);
                                     },
                            'pagar' => function ($url, $model)
                                   {
                                    if($model->id_estado == 2)  //estado en proceso
                                        {
                                           return Html::a('<span class="glyphicon glyphicon-usd"></span>', ['pago', 'id' => $model->id_ayuda], ['title' => Yii::t('app', 'Pagar'),'class' => 'btn btn-info btn-xs']);
                                        }
                                   },
                            'regresar' => function ($url, $model)
                                   {
                                    if($model->id_estado == 2)  //estado en proceso
                                        {
                                           return Html::a('<span class="glyphicon glyphicon-thumbs-down"></span>', ['/devoluciones/create', 'id' => $model->id_ayuda], [ 'title' => Yii::t('app', 'Regresar'),'class' => 'btn btn-danger btn-xs']);
                                        }
                                      },
                          ],
            'options' => ['class' => 'tbl-col-btn-ben'],
            ],
        ],
        'options' => ['class' => 'tbl-completa'],
    ]); ?>
</div>

<script>
      btnPDF = document.getElementById('btn-pdf');
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
    inputCodigo8.parentNode.removeChild(inputCodigo8);
</script>