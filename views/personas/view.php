<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Usuarios;


/* @var $this yii\web\View */
/* @var $model app\models\Personas */

$this->title = 'Ver Persona';
$this->params['breadcrumbs'][] = ['label' => 'Persona', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="personas-view">

    <div>
       <h2 class="titulo-area"><?= Html::encode($this->title) ?></h2>
       <hr>
    </div>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id_persona], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id_persona], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Estás seguro de que quieres eliminar este Registro?',
                'method' => 'post',
            ],
        ]) ?>

        <?php
        $UsuariosExistCount = Usuarios::find()
                              ->where(['id_persona'=>$model->id_persona])
                              ->count();

        if($UsuariosExistCount>0){

        }else{ 
           echo Html::a('Crear Usuario', ['/usuarios/create', 'id' => $model->id_persona , 'documento' => $model->documento ], ['title' => Yii::t('app', 'Crear Usuario'),'class' => 'btn btn-warning ']);
        }

        ?>
    
              
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [ 
            'documento',
            [
                'label' => 'Apellido y Nombre',
                'value' => function ($model) {
                     return $model->apellido.','.$model->nombre;
                },
            ],
            [
                'label' => 'Sexo',
                'attribute'=>'sexo',
                'filter'=>array("0"=>"Femenino","1"=>"Masculino"),
                'value' => function ($model) {
                     if($model->sexo == '0') //0 Desactivada
                     {
                        return 'Femenino'; // or return true;
                     } else {
                        return 'Masculino'; // or return false;
                     }
                },
            ],
            'fecha_nacimiento',
            'telefono',
            'profesion',
            'correo',
        ],
    ]) ?>

</div>
