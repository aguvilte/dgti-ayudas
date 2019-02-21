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




/* @var $this yii\web\View */
/* @var $searchModel app\models\AyudasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Consulta General';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ayudas-index">

    <h2 class="titulo-area"><?= Html::encode($this->title) ?></h2>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    

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
                        $beneficiario = beneficiarios::findOne($model->id_beneficiario);
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
                      $beneficiario = beneficiarios::findOne($model->id_beneficiario);
                      if ($beneficiario !== null) {
                          return $beneficiario->documento;
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
            //'entrega_dni',
            //'entrega_cuil',
            // 'asunto',
             'monto',
            // 'fecha_nota',
            // 'doc_adjunta',
             //'area',
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
            [
             'class' => 'yii\grid\ActionColumn',
             'template' => '{view} {observaciones} ',
             'buttons' => [
                           'view' => function ($url, $model)
                                    {
                                       if($model->id_estado != 1)
                                       return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [ 'title' => Yii::t('app', 'Ver'),'class' => 'btn btn-success btn-xs', ]);
                                     },
                            'observaciones' => function ($url, $model)
                                   {
                                    $observaciones= Observaciones::find()
                                                  ->where(['id_ayuda'=>$model->id_ayuda])
                                                  ->all();
                                    if(!empty($observaciones))  //estado en proceso
                                        {
                                           return Html::a('<span class="glyphicon glyphicon-tags"></span>', ['/observaciones/view', 'id' => $model->id_ayuda], ['title' => Yii::t('app', 'Observaciones'),'class' => 'btn btn-warning btn-xs']);
                                        } else {
                                           return Html::a('<span class="glyphicon glyphicon-tags"></span>', ['/observaciones/view', 'id' => $model->id_ayuda], ['title' => Yii::t('app', 'Observaciones'),'class' => 'btn btn-info btn-xs']);
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