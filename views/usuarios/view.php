<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Personas;
use app\models\Rol;
use app\models\UsuariosSecciones;
use app\models\Secciones;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = 'Ver Usuario';
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="usuarios-view">
    <div>
       <h2 class="titulo-area"><?= Html::encode($this->title) ?></h2>
       <hr>
    </div>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Estás seguro de que quieres eliminar este Registro?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            'password',
            [
              'label' => 'Rol',
              'value'=>function ($model) {
                $Rol = Rol::findOne($model->id_rol)->nombre;
                return $Rol;
              },
            ],
            [
              'label' => 'Nombre y Apellido',
              'value'=>function ($model) {
                   $apellido = Personas::findOne($model->id_persona)->apellido;
                   $nombre = Personas::findOne($model->id_persona)->nombre;
                   return $apellido.','.$nombre;
              },
            ],
            [
              'label' => 'Documento',
              'value'=> Personas::findOne($model->id_persona)->documento
            ],
            'ultimo_acceso_fecha',
        ],
    ]) ?>

    <div class="padding-v-md">
       <div class="line line-dashed"></div>
     </div>

     <div class="panel panel-default">
       <table  id="table"  class="table table-striped table-bordered">
         <thead>
           <tr>
             <th class="text-center titulo-tabla"><h4>Secciones</h4></th>
           </tr>
         </thead>
         <tbody>
           <?php
           if (empty($UsuariosSecciones)) {
             echo'
               <tr data-key="1">
                 <td>Todas</td>
               </tr>
             ';
           }else {
             foreach($UsuariosSecciones as $UsuariosSeccion) {
               $id_seccion = $UsuariosSeccion->id_seccion;
               $Secciones = Secciones::findOne(['id_seccion'=>$id_seccion]);

               echo'
                 <tr data-key="1">
                   <td>'.$Secciones->nombre.'</td>
                 </tr>
               ';
             }
           }
           ?>
         </tbody>
       </table>

</div>
