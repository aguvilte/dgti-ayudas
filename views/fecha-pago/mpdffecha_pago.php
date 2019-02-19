<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Beneficiarios;
use app\models\TiposAyudas;
use yii\helpers\ArrayHelper;
use app\models\Estados;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DecretosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="ayudas-index">
<img src="/img/cabecera.png" alt="La Rioja - Argentina">
    <h2 style="text-align: center;color:#0078CF;">Consulta por Fecha de Pago</h2>
    <h3 style="text-align: center;"> <?php echo $_GET['inputfecha_pago']?></h3>
    <br>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => '{items}{pager}',
        'columns' => [
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
                'enableSorting' => false,
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
                'enableSorting' => false,
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
                'enableSorting' => false,
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
                'enableSorting' => false,
                'filter'=> ArrayHelper::map(Estados::find()->groupBy('nombre')->all(), 'id_estado', 'nombre'),  
            ],
            //'entrega_dni',
            //'entrega_cuil',
            // 'asunto',
            ['label' => 'Monto',
             'attribute' => 'monto',
             'enableSorting' => false,
             ],
            // 'fecha_nota',
            // 'doc_adjunta',
             ['label' => 'Área',
             'attribute' => 'area',
             'enableSorting' => false,
             ],
             [
                'attribute' => 'fecha_pago',
                'format' => ['date', 'php:d-m-Y'],
                'enableSorting' => false,
            ],
            [
                'attribute' => 'fecha_entrada',
                'format' => ['date', 'php:d-m-Y'],
                'enableSorting' => false,
            ],
            [
                'attribute' => 'fecha_nota',
                'format' => ['date', 'php:d-m-Y'],
                'enableSorting' => false,
            ],
             //'fecha_entrada',
            // 'encargado',
            // 'pdf_doc_adjunta',
            // 'pdf_nota',
            // 'pdf_gestor',
            // 'pdf_domicilio',
            // 'id_persona',
        ],
    ]); ?>

    
</div>
