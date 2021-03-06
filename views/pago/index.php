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
use app\models\Usuarios;

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
            [
                'class' => 'yii\grid\DataColumn',
                'header' => 'Expediente',
                'value' => function($model) {
                    $ayudaExpediente = AyudasExpedientes::find()->where(['id_ayuda' => $model->id_ayuda])->one();
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
                        if($model->id_estado != 4 AND $model->id_estado != 1) {//si los estados de la ayuda son iniciados o cancelados no permite agregarlas a un expediente
                        $ayudaExpediente = AyudasExpedientes::find()->where(['id_ayuda' => $model->id_ayuda])->one();

                         if($ayudaExpediente!=NULL) { //si ya se asigno a un expediente
                            $Expediente = Expedientes::find()->where(['id_expediente' => $ayudaExpediente->id_expediente])->one();
                                if($Expediente!=NULL AND $Expediente->estado==1) { //si la ayuda ya esta en un expediente cerrado no visualiza los botones
                                return Html::a('<span class="glyphicon glyphicon-minus"></span>', ['/expedientes/quitar', 'id' => $model->id_ayuda], ['title' => Yii::t('app', 'Quitar de expediente'),'class' => 'btn btn-danger btn-xs']);
                                }
                                }else{
                                return Html::a('<span class="glyphicon glyphicon-plus"></span>', ['/expedientes/ayudas', 'id' => $model->id_ayuda], ['title' => Yii::t('app', 'Agregar a expediente'),'class' => 'btn btn-success btn-xs']);
                            }
                        }

                    },
                    // 'expediente2' => function ($url, $model) {
                    //     return Html::a('<span class="glyphicon glyphicon-minus"></span>', ['/expedientes/ayudas', 'id' => $model->id_ayuda], ['title' => Yii::t('app', 'Crear ayuda'),'class' => 'btn btn-danger btn-xs']);
                    // },
                ],
            ],
            [
                'label' => 'Usuario',
                'attribute' => 'id_usuario',
                'value' => function($model){
                    $usuario = Usuarios::findOne($model->id_usuario);
                    if ($usuario !== null) {
                        return $usuario->username;
                    }
                },
                'filter'=> ArrayHelper::map(Usuarios::find()->groupBy('username')->where(['id_rol' => 2])->all(), 'id', 'username'),  
            ],
        ],
        'options' => ['class' => 'tbl-completa'],
    ]); ?>

</div>

<script language="JavaScript" type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src='js/pago/index.js'></script>

