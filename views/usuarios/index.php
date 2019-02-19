<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\Personas;
use app\models\Rol;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuarios-index">

    <div>
       <h2 class="titulo-area"><?= Html::encode($this->title) ?></h2>
       <hr>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
              'label' => 'Documento',
              'attribute'=>'id_persona',
              'value'=>function ($model) {
                   return Personas::findOne($model->id_persona)->documento;
              },
              'filterInputOptions' => [
                                      'class'       => 'form-control',
                                      'placeholder' => '36035956'
                                      ]
            ],
            [
              'label' => 'Nombre y Apellido',
              'value'=>function ($model) {
                    $apellido = Personas::findOne($model->id_persona)->apellido;
                    $nombre = Personas::findOne($model->id_persona)->nombre;
                    return $apellido.','.$nombre;
              },
            ],
            'username',
            'password',
            [
              'label' => 'Rol',
              'value'=>function ($model) {
                $Rol = Rol::findOne($model->id_rol)->nombre;
                return $Rol;
              },
            ],
            'ultimo_acceso_fecha',
            [
             'class' => 'yii\grid\ActionColumn',
             'template' => '{view} {update} {delete}',
             'buttons' => [
                            'view' => function ($url, $model)
                                     {
                                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [ 'title' => Yii::t('app', 'Ver'),'class' => 'btn btn-success btn-xs', ]);
                                      },
                            'update' => function ($url, $model)
                                     {
                                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [ 'title' => Yii::t('app', 'Editar'),'class' => 'btn btn-primary btn-xs', ]);
                                      },
                          ],
			    'options' => ['class' => 'tbl-col-btn'],
            ],
        ],
        'options' => ['class' => 'tbl-completa'],
    ]); ?>
</div>
