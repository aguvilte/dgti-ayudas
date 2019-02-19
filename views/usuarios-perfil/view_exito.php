<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Personas;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = 'Mi Perfil';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="usuarios-view">

    <div>
       <h2 class="titulo-area"><?= Html::encode($this->title) ?></h2>
       <hr>
    </div>

    <p>
        <?= Html::a('Cambiar Contraseña', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <div class="alert alert-info">
       Felicidades.! La contraseña fue modificada correctamente.
    </div>
    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            'password',
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
        ],
    ]) ?>

</div>
