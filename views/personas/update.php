<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Personas */

$this->title = 'Actualizar Persona';
$this->params['breadcrumbs'][] = ['label' => 'Persona', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id_persona, 'url' => ['view', 'id' => $model->id_persona]];
$this->params['breadcrumbs'][] = 'Actualizar Persona';

?>
<div class="personas-update">

    <div class="jumbotron">
       <h2 class="titulo-area"><?= Html::encode($this->title) ?></h2>
       <hr>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
