<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Usuarios;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PersonasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Personas';
$this->params['breadcrumbs'][] = $this->title;  

?>

<div class="personas-index">

    <div>
       <h2 class="titulo-area"><?= Html::encode($this->title) ?></h2>
       <hr>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nueva Persona', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
 
            'documento',
            'apellido',
            'nombre',
            'telefono',
            'profesion',
            'correo',
            [
             'class' => 'yii\grid\ActionColumn',
             'template' => '{view} {update} {delete} {crear}',
             'buttons' => [
                            'view' => function ($url, $model)
                                     {
                                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [ 'title' => Yii::t('app', 'Ver'),'class' => 'btn btn-success btn-xs', ]);
                                      },
                            'update' => function ($url, $model)
                                     {
                                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [ 'title' => Yii::t('app', 'Editar'),'class' => 'btn btn-primary btn-xs', ]);
                                      },
                            'crear' => function ($url, $model)
                                     {
                                        $UsuariosExistCount = Usuarios::find()
                                                              ->where(['id_persona'=>$model->id_persona])
                                                              ->count();

                                        if($UsuariosExistCount>0){

                                        }else{ 
                                            return Html::a('<span class="glyphicon glyphicon-plus"></span>', ['/usuarios/create', 'id' => $model->id_persona , 'documento' => $model->documento], ['title' => Yii::t('app', 'Crear Usuario'),'class' => 'btn btn-warning btn-xs']);
                                        }
                                      },
                          ],
			  'options' => ['class' => 'tbl-col-btn'],
            ],
        ],
        'options' => ['class' => 'tbl-completa'],
    ]); ?>
</div>
